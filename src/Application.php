<?php

namespace PROJECT;

use PROJECT\Database\DB;
use PROJECT\Database\Managers\MYSQLManager;
use PROJECT\Database\Managers\SQLITEManager;
use PROJECT\HTTP\Request;
use PROJECT\HTTP\Response;
use PROJECT\HTTP\Route;
use PROJECT\support\Config;
use PROJECT\support\Sessions;
use PROJECT\support\Languages;

class Application
{
  protected Route $route;
  protected Request $request;
  protected Response $response;
  protected Config $config;
  protected DB $db;
  protected Sessions $session;
  protected Languages $lang;
  public function __construct()
  {
    $this->request = new Request();
    $this->response = new Response();
    $this->session = new Sessions();
    $this->route = new Route($this->request, $this->response);
    $this->config = new Config($this->loadConfig());
    $this->db = new DB($this->getDBDriver());
    $this->lang = new Languages($this->loadLanguageSupport());
  }

  protected function getDBDriver(): SQLITEManager|MYSQLManager
  {
    return match (env("DB_DRIVER")) {
      'sqlite' => new SQLITEManager(),
      'mysql' => new MYSQLManager(),
      default => new MYSQLManager
    };
  }

  protected function loadLanguageSupport(): array
  {
    $lang = [];
    foreach (scandir(lang_path()) as $file) {
      if ($file == "." || $file == ".." || $file == "...") {
        continue;
      }
      $fileName = explode(".", $file)[0];
      $lang[$fileName] = require_once lang_path() . $file;
    }
    return $lang;
  }
  protected function loadConfig(): array
  {
    $config = [];
    foreach (scandir(config_path()) as $file) {
      if ($file == "." || $file == "..") {
        continue;
      }
      $fileName = explode(".", $file)[0];
      $config[$fileName] = require config_path() . $file;
    }
    return $config;
  }


  public function run(): void
  {
    $this->db->init();
    $this->route->resolve();
  }

  public function __get(string $name)
  {
    if (property_exists($this, $name)) {
      return $this->$name;
    }
  }
}
