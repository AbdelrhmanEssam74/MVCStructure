<?php

namespace PROJECT\HTTP;

use PROJECT\HTTP\Request;
use PROJECT\HTTP\Response;
use PROJECT\View\View;

class Route
{
    /**
     * The current HTTP request instance.
     *
     * @var Request
     */
    public Request $request;

    /**
     * The HTTP response instance.
     *
     * @var Response
     */
    protected Response $response;

    /**
     * A static map of registered routes.
     *
     * The map organizes routes by HTTP methods (`get`, `post`) and their corresponding paths.
     * For each path, an associated action (e.g., controller method, closure) is stored.
     *
     * @var array
     */
    public static array $RoutesMap = [];

    /**
     * Route constructor.
     *
     * Initializes the Route class with a Request and Response instance.
     *
     * @param Request $request The HTTP request object.
     * @param Response $response The HTTP response object.
     */
    public function __construct($request, $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * Registers a GET route with the associated action.
     *
     * This method adds a new GET route to the static RoutesMap array.
     * The route is stored under the 'get' HTTP method key.
     *
     * @param string $route The URL path for the route.
     * @param mixed $action The action to execute when the route is matched.
     *                      It can be:
     *                      - A closure
     *                      - A string 'Controller@method'
     *                      - An array [ControllerClass::class, 'methodName']
     *
     * @return void
     */
    public static function get($route, $action): void
    {
        self::$RoutesMap['get'][$route] = $action;
    }

    /**
     * Registers a POST route with the associated action.
     *
     * Similar to the GET route method, this registers a POST route
     * under the 'post' key in the RoutesMap array.
     *
     * @param string $route The URL path for the route.
     * @param mixed $action The action to execute when the route is matched.
     *                      It can be:
     *                      - A closure
     *                      - A string 'Controller@method'
     *                      - An array [ControllerClass::class, 'methodName']
     *
     * @return void
     */
    public static function post($route, $action): void
    {
        self::$RoutesMap['post'][$route] = $action;
    }

    /**
     * Resolves the current request to the appropriate controller action.
     *
     * This method determines the controller and method to execute based on the:
     * - HTTP method (GET, POST, etc.)
     * - Request path
     *
     * It supports parameter mapping for methods that require dynamic arguments. If no matching
     * route is found, it renders a `404 Not Found` error page.
     *
     * **How it works:**
     * - It trims the request path to find a route match in `RoutesMap`.
     * - If the route exists, it dynamically maps any extra path segments to the method parameters.
     * - It invokes the controller method using `call_user_func_array`.
     *
     * @return void
     *
     * @throws \ReflectionException If the controller method cannot be reflected properly.
     */
    public function resolve(): void
    {
        $path = $this->request->path();
        $method = $this->request->method();

        // Get parameters from the request
        $params = $this->request->params();

        // Trim the path to extract the base route
        $path_arr = explode('/', $path);
        $trimmed_path = implode('/', array_slice($path_arr, 0, 3));
        $extra_segments = array_slice($path_arr, 3); // Additional segments for dynamic parameters

        // Check if the route exists for the current HTTP method
        if (array_key_exists($method, self::$RoutesMap) && array_key_exists($trimmed_path, self::$RoutesMap[$method])) {
            $action = self::$RoutesMap[$method][$trimmed_path]; // e.g., [Controller, Method]

            // If the action is an array (e.g., Controller@Method)
            if (is_array($action)) {
                $controller = new $action[0];
                $method_name = $action[1];

                // Reflect the method to dynamically map parameters
                $reflection = new \ReflectionMethod($controller, $method_name);
                $method_params = $reflection->getParameters();
                $mapped_params = [];

                // Map extra segments or request parameters to method arguments
                foreach ($method_params as $index => $param) {
                    $param_name = $param->getName();
                    $mapped_params[$param_name] = $params[$param_name] ?? ($extra_segments[$index] ?? null);
                }

                // Invoke the controller method with mapped parameters
                call_user_func_array([$controller, $method_name], $mapped_params);
            }
        } else {
            // Render 404 error page if no route matches
            View::makeErrorView('404');
            $this->response->setStatusCode(404);
        }
    }
}
