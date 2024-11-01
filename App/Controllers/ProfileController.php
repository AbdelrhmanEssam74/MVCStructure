<?php

namespace App\Controllers;

use PROJECT\View\View;

class ProfileController
{
    public function index()
    {
        return View::makeView('Profile');
    }
}