<?php

namespace App\Models;

use PROJECT\HTTP\Response;
use PROJECT\Validation\Validation;
use PROJECT\View\View;

class Login extends Model
{
  private $email;
  private $password;

  /**
   * Handles the login process.
   *
   * This function validates the user's email and password, and if valid, redirects the user to the dashboard.
   * If the validation fails, it sets flash messages for errors and old input, and redirects back to the login page.
   *
   * @return void
   */
  public static function login()
  {
    if (hash_equals($_SESSION['csrf_token'], request('csrf_token'))) {
      // Token is valid
      $validator = new Validation();
      $validator->rules([
        'email' => 'required|email|email_exists:users,email',
        'password' => 'required|password_verification:users,password'
      ]);
      $validator->make(request()->all());

      if (!$validator->passes()) {
        if ($validator->errors('email')) {
          app()->session->setFlash('email', $validator->errors('email'));
        }
        if ($validator->errors('password')) {
          app()->session->setFlash('password', $validator->errors('password'));
          if (!$validator->errors('email'))
            app()->session->setFlash('oldEmail', request()->get('email'));
        }
        return backRedirect();
      }
      if (!$validator->passes()) {
        app()->session->setFlash('errors', $validator->errors());
        app()->session->setFlash('old', request()->all());
        return backRedirect();
      }
      $user_data = app()->db->row("SELECT * FROM `users` WHERE email = ?", [request()->get('email')]);
      $user_data = (object) $user_data[0];
      app()->session->set('login', true);
      app()->session->set('user_id', $user_data->user_id);
      app()->session->set('email', $user_data->email);
      return RedirectToView('user/profile/' . $user_data->user_id);
    } else {
      // Invalid token
      $response = new Response();
      $response->setStatusCode(403);
      View::makeErrorView('403');
    }
  }

  public static function logout()
  {
    session_unset();
    session_destroy();
    RedirectToView('login');
    exit();
  }
}
