<?php

namespace App\Controllers;

use http\Env\Request;
use PROJECT\View\View;

class UserController
{
    public function profile($id = null)
    {// Fetch user data
        $userData = app()->db->row("SELECT * FROM `users` WHERE user_id = ?", [$id]);
        $userData = (object) $userData[0];
        $date = [
            "userData" => [
                'full_name' => $userData->full_name,
                'username' => $userData->username,
            ]
        ];
        if ($date)
            return View::makeView('profile', $date);
    }
}