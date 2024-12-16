<?php

use Dotenv\Dotenv;

require_once '../src/support/helpers.php';
require_once base_path() . 'vendor/autoload.php';
require_once base_path() . 'routes/web.php';
$env = Dotenv::createImmutable(base_path());
date_default_timezone_set('Africa/Cairo');
$env->load();
app()->run();
