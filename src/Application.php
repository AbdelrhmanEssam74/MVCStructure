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
use eftec\bladeone\BladeOne;

class Application
{
  protected Route $route;
  protected Request $request;
  protected Response $response;
  protected Config $config;
  protected DB $db;
  protected Sessions $session;
  protected Languages $lang;
  protected BladeOne $blade;
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
  protected function loadFiles(string $path): array
  {
    $data = [];
    foreach (scandir($path) as $file) {
      if ($file === "." || $file === ".." || pathinfo($file, PATHINFO_EXTENSION) !== 'php') {
        continue;
      }
      $key = pathinfo($file, PATHINFO_FILENAME);
      $data[$key] = require $path . $file;
    }
    return $data;
  }

  protected function loadConfig(): array
  {
    return $this->loadFiles(config_path());
  }

  protected function loadLanguageSupport(): array
  {
    return $this->loadFiles(lang_path());
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
    throw new \InvalidArgumentException("Property '{$name}' does not exist in " . __CLASS__);
  }
}
