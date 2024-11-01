<?php

namespace App\Controllers;

use PROJECT\View\View;

class HomeController
{
    public function index(): null
    {
        return View::makeView("index");
    }
}