<?php

namespace App\Controllers;

use PROJECT\support\EmailHelper;
use PROJECT\Validation\Validation;
use PROJECT\HTTP\Response;
use PROJECT\View\View;
use App\Models\User;
use PROJECT\support\Hash;

class SignupController
{
  public function index(): null
  {
    $csrfToken = Hash::makeToken(date('Y-m-d H:i:s'));
    $security = array(
      'csrf_token' => $csrfToken
    );
    app()->session->set('csrf_token', $security['csrf_token']);
    return View::makeView("auth.signup", $security);
  }

  public function store()
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
      $user_id = uniqid();
      self::sendAuthenticationCode(request('email'));
      User::create([
        'user_id' => $user_id,
        'full_name' => request('full_name'),
        'username' => request('username'),
        'email' => request('email'),
        'password' => bcrypt(request('password')),
        'authentication_code' => app()->session->get('auth_code'),
        'created_at' => date('Y-m-d H:i:s'),
        'auth_code_created_at' => date('Y-m-d H:i:s'),
      ]);
      app()->session->set('user_id', $user_id);
      return RedirectToView('verify');
    else:
      // Invalid token
      $response = new Response();
      $response->setStatusCode(403);
      View::makeErrorView('403');
    endif;
  }
  public function verification()
  {
    if (!empty(request('email'))) {
      app()->session->set('email', request('email'));
    }
    View::makeView("auth.verification");
  }
  public static function sendAuthenticationCode($email)
  {
    // Send authentication code to user's email
    $send_mail = new EmailHelper();
    $authentication_code = GenerateAuthCode(); // Function to generate a random code
    app()->session->set('auth_code', $authentication_code);
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
      <div class=\"code\">$authentication_code</div>
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
    $result =  $send_mail->sendEmail($email, $subject, $body);
    ($result) ?  User::update('email', $email, ['auth_code_created_at' => date('Y:m:d h:s:i'), 'authentication_code' => $authentication_code]) : false;
    return  $result;
  }
  public function checkAuthCode()
  {
    $user_id =
      (!empty(app()->session->get('user_id')))
      ? app()->session->get('user_id')
      : null;
    $auth_code_input = request('auth_code');
    // check if the id exists
    if ($user_id):
      $authCodeData = app()->db->row(
        "SELECT  authentication_code, auth_code_created_at 
          FROM users 
          WHERE user_id = ?",
        [$user_id]
      )[0] ?? null;
      // check if the input code === the code which stored in db
      if ($authCodeData && $authCodeData->authentication_code == $auth_code_input):
        // if the code is correct, Check if the code is expired (15-minute TTL)
        $codeAge = time() - strtotime($authCodeData->auth_code_created_at);
        echo $codeAge;
        if ($codeAge > 900) { // 900 seconds = 15 minutes
          app()->session->setFlash('expiredCode', 'Your authentication code has expired. Please request a new one.');
          return RedirectToView('verify');
        }
      endif;
    endif;
    // if the code is not expired, proceed with the Activation process
    User::update('user_id', $user_id, ['active' => 1, 'authentication_code' => null]); // Clear the code after use

    // Provide success feedback
    app()->session->setFlash('success', 'Registered successfully! You can now log in.');
    return RedirectToView('login');
  }
  public function resendAuthCode()
  {
    // Get Email Address from request
    $email = request('email');
    // Check if email exists in database
    $user = app()->db->row("SELECT * FROM users WHERE email = ?", [$email]);
    app()->session->set('user_id', $user[0]->user_id);
    if (!$user) {
      // Email not found
      app()->session->setFlash('invalidEmail', 'Oops! That email doesn\'t exist.');
      return RedirectToView('verify');
    } else {
      // Send a new authentication code
      var_dump($user);
      if (self::sendAuthenticationCode($email)) {
        app()->session->setFlash('validEmail', 'Authentication code was sent successfully  Check your mail box ');
        return RedirectToView('verify');
      }
    }
  }
}
