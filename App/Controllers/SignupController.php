<?php

namespace App\Controllers;

use App\Models\User;
use PROJECT\Validation\Validation;
use PROJECT\View\View;
use PROJECT\HTTP\Request;

class SignupController
{
    public function index(): null
    {
        return View::makeView("auth.signup");
    }

    public function store()
    {
        User::signup();
    }
}