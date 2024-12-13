<?php

namespace App\Models;

use PROJECT\Validation\Validation;

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
        // TODO: fix mysql error when user try to create a new account
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