<?php

namespace App\Models;

use PROJECT\support\EmailHelper;
use PROJECT\Validation\Validation;
use PROJECT\HTTP\Response;
use PROJECT\View\View;

class Signup extends Model
{
  private $id;
  private $user_id;
  private $full_name;
  private $username;
  private $email;
  private $password;

  public static function signup()
  {
    if (hash_equals($_SESSION['csrf_token'], request('csrf_token'))):
      $validator = new Validation();
      $validator->rules([
        'full_name' => 'required|alphaNum|between:6,30',
        'username' => 'required|alphaNum|between:5,20|unique:users,username',
        'email' => 'required|email|between:15,75|unique:users,email',
        'password' => 'required|password_confirmation',
        'password_confirmation' => 'required'
      ]);
      $validator->make(request()->all());
      if (!$validator->passes()) {
        app()->session->setFlash('errors', $validator->errors());
        app()->session->setFlash('old', request()->all());
        return backRedirect();
      }
      User::create([
        'user_id' => uniqid(),
        'full_name' => request('full_name'),
        'username' => request('username'),
        'email' => request('email'),
        'password' => bcrypt(request('password')),
      ]);
      self::sendAuthenticationCode(request('email'));
      return RedirectToView('verify');
    else:
      // Invalid token
      $response = new Response();
      $response->setStatusCode(403);
      View::makeErrorView('403');
    endif;
  }
  public static function sendAuthenticationCode($email)
  {
    // Send authentication code to user's email
    $send_mail = new EmailHelper();
    $verification_code = GenerateAuthCode(); // Function to generate a random code
    app()->session->set('auth_code', $verification_code);
    // Define the email subject and body
    $subject = "Your Authorization Code for Secure Access";

    $body = "
<!DOCTYPE html>
<html>
<head>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f9f9f9;
      color: #333;
      margin: 0;
      padding: 0;
    }
    .email-container {
      max-width: 600px;
      margin: 20px auto;
      background-color: #ffffff;
      border: 1px solid #dddddd;
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .header {
      text-align: center;
      border-bottom: 2px solid #007bff;
      padding-bottom: 15px;
      margin-bottom: 20px;
    }
    .header h1 {
      color: #007bff;
    }
    .content {
      text-align: left;
      font-size: 16px;
      line-height: 1.5;
    }
    .code {
      font-size: 24px;
      font-weight: bold;
      color: #007bff;
      text-align: center;
      margin: 20px 0;
    }
    .footer {
      font-size: 12px;
      color: #666;
      text-align: center;
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <div class=\"email-container\">
    <div class=\"header\">
      <h1>Authorization Code</h1>
    </div>
    <div class=\"content\">
      <p>Dear User,</p>
      <p>You requested to sign in or perform a secure action. Use the authorization code below to complete the process:</p>
      <div class=\"code\">$verification_code</div>
      <p>If you did not request this code, please ignore this email or contact support immediately.</p>
      <p>Thank you for using our service!</p>
    </div>
    <div class=\"footer\">
      <p>&copy; 2024 Your Company Name. All rights reserved.</p>
    </div>
  </div>
</body>
</html>";

    // Send the email
    echo  $send_mail->sendEmail($email, $subject, $body);
  }
}
