<?php

namespace App\Controllers;

use App\Models\Signup;
use PROJECT\View\View;
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
    Signup::signup();
  }
}
