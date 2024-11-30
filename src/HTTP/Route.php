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

        // Get parameters from the request
        $params = $this->request->params();
        // Trim the path to get the base route
        $path_arr = explode('/', $path);
        $trimmed_path = implode('/', array_slice($path_arr, 0, 3));
        $extra_segments = array_slice($path_arr, 3); // Additional segments (e.g., param1, param2,...)
        // Check if the method and trimmed path match a route in the RoutesMap
        if (array_key_exists($method, self::$RoutesMap) && array_key_exists($trimmed_path, self::$RoutesMap[$method])) {
            $action = self::$RoutesMap[$method][$trimmed_path]; // action = array() => [Controller , Method ]
            // If the action is an array, ensure parameters match method signature
            if (is_array($action)) {
                $controller = new $action[0];
                $method_name = $action[1];

                // Use Reflection to match parameters dynamically
                $reflection = new \ReflectionMethod($controller, $method_name);
                $method_params = $reflection->getParameters();
                $mapped_params = [];

                // Map extra segments to method parameters
                foreach ($method_params as $index => $param) {
                    $param_name = $param->getName();
                    $mapped_params[$param_name] = $params[$param_name] ?? ($extra_segments[$index] ?? null);
                }

                call_user_func_array([$controller, $method_name], $mapped_params);
            }
        } else {
            View::makeErrorView('404');
            $this->response->setStatusCode(404);
        }
    }


}