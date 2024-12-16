<?php

namespace App\Controllers;

use App\Models\User;
use PROJECT\View\View;

class UserController
{
  public function profile($id = null)
  {
    $userData = User::getUserData('user_id', $id);
    return View::makeView('profile', $userData);
  }
}
