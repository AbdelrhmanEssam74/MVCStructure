<?php

namespace PROJECT\HTTP;

use PROJECT\HTTP\Request;
use PROJECT\HTTP\Response;
use PROJECT\View\View;

class Route
{
    public Request $request;
    protected Response $response;
    public static array $RoutesMap = [];

    public function __construct($request, $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public static function get($route, $action): void
    {
        self::$RoutesMap['get'][$route] = $action;
    }

    public static function post($route, $action): void
    {
        self::$RoutesMap['post'][$route] = $action;
    }

    public function resolve(): void
    {
        $path = $this->request->path();
        $method = $this->request->method();
        $params = $this->request->params();

        // Check if the method exists in the RoutesMap array
        if (array_key_exists($method, self::$RoutesMap) && array_key_exists($path, self::$RoutesMap[$method])) {
            $action = self::$RoutesMap[$method][$path];

            // If the action is a callback
            if (is_callable($action)) {
                call_user_func_array($action, $params);
            }

            // If the action is an array
            if (is_array($action)) {
                call_user_func_array([new $action[0], $action[1]], $params);
            }
        } else {
            // Handle a 404 error when the route or method is not found
            View::makeErrorView('404');
            $this->response->setStatusCode(404);
        }
    }

}