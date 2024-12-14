<?php

namespace App\Controllers;

use App\Models\Login;
use PROJECT\support\Hash;
use PROJECT\View\View;

class LoginController
{
  public function index(): void
  {
    $csrfToken = Hash::makeToken(date('Y-m-d H:i:s'));
    $security = array(
      'csrf_token' => $csrfToken
    );
    app()->session->set('csrf_token', $security['csrf_token']);
    View::makeView('auth.login', $security);
  }
  public function login(): void
  {
    Login::login();
  }


  public function logout(): void
  {
    Login::logout();
  }
}
