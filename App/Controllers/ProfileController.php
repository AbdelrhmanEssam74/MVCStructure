<?php

namespace App\Controllers;

use http\Env\Request;
use PROJECT\View\View;

class ProfileController
{
    public function index($id = null)
    {
        return View::makeView('profile');
    }
}