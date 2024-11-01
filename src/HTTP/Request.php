<?php

namespace PROJECT\HTTP;

use PROJECT\support\Arr;

class Request
{
    /**
     * @return   HTTP method of the current request in lowercase
     */
    public static function method(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD'] ?? 'get');
    }

    /**
     * retrieves the path of the current request URI
     * It first checks if the request URI contains a query string
     * If it does, it extracts the path part before the query string
     * @return the full path.
     */
    public static function path(): string
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        return strtok($path, "?");
    }

    /**
     * Attempts to extract parameters from the query string of the current request URI.
     * It follows a similar logic to the path() method, first checking if there are parameters in the request URI.
     * If found, it splits the parameters by '&' and returns an array of individual parameters.
     * If there is no query string, it returns an empty array.
     * @return array
     */
    public static function params(): array
    {
        $params = [];

        if (isset($_SERVER['REQUEST_URI'])) {
            $query = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);

            if ($query) {
                parse_str($query, $params);
            }
        }

        return $params;
    }
    public  function all(): array
    {
        return $_REQUEST;
    }
    public function get($key){
        return Arr::get($this->all() , $key);
    }
    public function only($keys){
        return Arr::get($this->all() , $keys);
    }
}

