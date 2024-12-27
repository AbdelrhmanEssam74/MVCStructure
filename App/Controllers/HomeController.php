<?php

namespace App\Controllers;

use PROJECT\View\View;

class HomeController
{
  public function index(): null
  {
    $data = array(
      'translation' => app()->lang->get(getLanguage()),
    );
    return View::makeView("index", $data);
  }
}
