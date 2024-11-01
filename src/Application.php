<?php

namespace PROJECT;

use mysql_xdevapi\Session;
use PROJECT\Database\DB;
use PROJECT\Database\Managers\MYSQLManager;
use PROJECT\HTTP\Request;
use PROJECT\HTTP\Response;
use PROJECT\HTTP\Route;
use PROJECT\support\Config;
use PROJECT\support\Sessions;

class Application
{
    protected Route $route;
    protected Request $request;
    protected Response $response;
    protected Config $config;
    protected DB $db;
    protected Sessions $session;

    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Sessions();
        $this->route = new Route($this->request, $this->response);
        $this->config = new Config($this->loadConfig());
        $this->db = new DB($this->getDBDriver());
    }

    protected function getDBDriver(): MYSQLManager
    {
        return match (env("DB_DRIVER")) {
            'mysql' => new MYSQLManager(),
            default => new MYSQLManager
    };
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