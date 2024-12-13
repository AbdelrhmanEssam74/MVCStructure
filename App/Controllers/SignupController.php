<?php

namespace App\Controllers;

use App\Models\Signup;
use PROJECT\View\View;

class SignupController
{
    public function index(): null
    {
        return View::makeView("auth.signup");
    }

    public function store()
    {
        Signup::signup();
    }
}