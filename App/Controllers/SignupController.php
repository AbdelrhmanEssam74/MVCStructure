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
        app()->session->setFlash('success', 'Registered successfully Now You Can Login With Your Email Address');
        return RedirectToView('login');
    }
}