<?php

use App\Controllers\HomeController;
use PROJECT\HTTP\Route;

Route::get('/', [HomeController::class, 'index']);
