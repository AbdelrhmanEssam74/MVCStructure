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
     * Extracts parameters from the current request URI based on predefined route patterns.
     *
     * This method analyzes the current URL path and attempts to match it against a set of
     * predefined route patterns. If a match is found, it extracts the parameters from the
     * URL and returns them as an associative array.
     *
     * The method supports dynamic route patterns with placeholders in curly braces, such as
     * '{year}' or '{article-title}'. These placeholders are then used as keys in the
     * returned parameter array.
     *
     * @return array An associative array of extracted parameters. If no match is found or
     *               no parameters are present in the URL, an empty array is returned.
     *               The keys of the array correspond to the placeholders in the matched
     *               route pattern, and the values are the actual values from the URL.
     */
    public static function params(): array
    {
        $urlPath = trim(self::path(), '/'); // Get the current path
        $params = [];
        $segments = explode('/', $urlPath);
        // Define the route patterns you want to match
        $routePatterns = [];
        if (count($segments) > 1) {
            $routePatterns = [
                $segments[0] . '/' . $segments[1] . '/{category}/{postTitle}/{postID}', // For patterns like /controller/method/{id}
                $segments[0] . '/' . $segments[1] . '/{year}/{month}', // Optional pattern example
            ];
        }
        foreach ($routePatterns as $routePattern) {
            preg_match_all('/\{([^}]+)\}/', $routePattern, $keys); // Extract parameter names
            $keys = $keys[1]; // ['id', 'year', 'month', etc.]

            // Convert route pattern into a regex
            $regex = preg_replace('/\{[^}]+\}/', '([^/]+)', $routePattern);
            $regex = '/^' . str_replace('/', '\/', $regex) . '$/';
            // Try to match the URL path to the pattern
            if (preg_match($regex, $urlPath, $matches)) {
                array_shift($matches); // Remove the full match (the entire URL)
                $params = array_combine($keys, $matches); // Map keys to values
                break; // Stop once a pattern matches
            }
        }
        return $params;
    }


    public function all(): array
    {
        return $_REQUEST;
    }

    public function get($key)
    {
        return Arr::get($this->all(), $key);
    }

    public function only($keys)
    {
        return Arr::get($this->all(), $keys);
    }
}