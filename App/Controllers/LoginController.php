<?php

namespace App\Controllers;

use App\Models\Login;
use PROJECT\View\View;

class LoginController
{
    public function index(): void
    {
        View::makeView('auth.login');
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