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
  public function verification()
  {
    View::makeView("auth.verification");
  }
  public function checkAuthCode()
  {
    $authCode = app()->session->get('auth_code');
    $authCodeInput = request('auth_code');
    if ($authCode !== $authCodeInput):
      app()->session->setFlash('invalidCode', 'Oops! That code didn\'t work. Please double-check and try again.');
      return RedirectToView('verification');
    else:
      app()->session->setFlash('success', 'Registered successfully Now You Can Login With Your Email Address');
      return RedirectToView('login');
    endif;
  }
}
