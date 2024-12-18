<?php

use PROJECT\Application;
use PROJECT\HTTP\Request;
use PROJECT\HTTP\Response;
use PROJECT\support\Hash;

/**
 * @description
 * Retrieves the value of an environment variable by its key.
 * Falls back to a default value if the variable is not set.
 *
 * @param string $key The environment variable name.
 * @param mixed $value The default value to return if the variable is not set.
 * @return mixed The environment variable value or the default value.
 */
if (!function_exists("env")):
    function env($key, $value = null)
    {
        return $_ENV[$key] ?? value($value);
    }
endif;

/**
 * @description
 * Determines if a value is a Closure and executes it, or returns the value directly.
 *
 * @param mixed $value The value to evaluate.
 * @return mixed The evaluated value.
 */
if (!function_exists("value")):
    function value($value)
    {
        return ($value instanceof Closure) ? $value() : $value;
    }
endif;

/**
 * @description
 * Returns the base directory path of the project.
 *
 * @return string The base path.
 */
if (!function_exists("base_path")):
    function base_path(): string
    {
        return dirname(__DIR__) . '/../';
    }
endif;

/**
 * @description
 * Returns the path to the views directory within the project.
 *
 * @return string The path to the views directory.
 */
if (!function_exists("view_path")):
    function view_path(): string
    {
        return base_path() . 'views/';
    }
endif;

/**
 * @description
 * Retrieves the previous value of a form field from the session flash data.
 *
 * @param string $key The form field name.
 * @return mixed|null The previous value, or null if not available.
 */
if (!function_exists("old")):
    function old($key)
    {
        if (app()->session->hasFlash('old')) {
            return app()->session->getFlash('old')[$key];
        }
    }
endif;

/**
 * @description
 * Handles HTTP requests and retrieves specific input data.
 *
 * @param string|array|null $key The key to retrieve or an array of keys for filtering.
 * @return mixed The input value(s) or the entire request instance.
 */
if (!function_exists("request")):
    function request($key = null)
    {
        $instance = new Request;
        if ($key) {
            return $instance->get($key);
        }
        if (is_array($key)) {
            return $instance->only($key);
        }
        return $instance;
    }
endif;

/**
 * @description
 * Redirects the user to the previous page.
 *
 * @return null
 */
if (!function_exists("backRedirect")):
    function backRedirect(): null
    {
        return (new Response)->back();
    }
endif;

/**
 * @description
 * Returns the singleton instance of the Application class.
 *
 * @return Application|null The Application instance.
 */
if (!function_exists("app")):
    function app(): ?Application
    {
        static $instance = null;
        if (!$instance) {
            $instance = new Application;
        }
        return $instance;
    }
endif;

/**
 * @description
 * Returns the base name of a class, stripping namespace information.
 *
 * @param object|string $class The class name or object.
 * @return string The base class name.
 */
if (!function_exists("class_basename")):
    function class_basename($class): string
    {
        $class = is_object($class) ? get_class($class) : $class;
        return basename(str_replace("\\", "/", $class));
    }
endif;

/**
 * @description
 * Hashes a password using the application's Hash utility.
 *
 * @param string $password The plain text password to hash.
 * @return string The hashed password.
 */
if (!function_exists("bcrypt")):
    function bcrypt($password): string
    {
        return Hash::hash($password);
    }
endif;

/**
 * @description
 * Returns the path to the configuration files directory.
 *
 * @return string The config directory path.
 */
if (!function_exists("config_path")):
    function config_path(): string
    {
        return base_path() . 'config/';
    }
endif;

/**
 * @description
 * Retrieves or sets application configuration values.
 *
 * @param string|array|null $key The config key or an array of key-value pairs to set.
 * @param mixed $default The default value if the key is not found.
 * @return mixed The configuration value or the entire config object.
 */
if (!function_exists("config")):
    function config($key = null, $default = null)
    {
        if (is_null($key)) {
            return app()->config;
        }
        if (is_array($key)) {
            return app()->config->set($key);
        }
        return app()->config->get($key, $default);
    }
endif;

/**
 * @description
 * Redirects the user to a specific path within the application.
 *
 * @param string $path The relative path to redirect to.
 */
if (!function_exists("RedirectTo")):
    function RedirectToView($path): void
    {
        header("Location:" . env('HOST') . $path);
    }
endif;

/**
 * @description
 * Returns the current date and time formatted by the specified selector.
 *
 * @param string $selector The date format. Defaults to "Y:m:d h:s:i".
 * @return string The formatted date and time.
 */
if (!function_exists('getCurrentDate')):
    function getCurrentDate(string $selector = "Y:m:d h:s:i"): string
    {
        return date($selector);
    };
endif;

/**
 * @description
 * Generates a random 6-digit authentication code.
 *
 * @return string The generated authentication code.
 */
if (!function_exists('GenerateAuthCode')):
    function GenerateAuthCode(): string
    {
        return rand(100000, 999999); // Generate a 6-digit random code
    };
endif;
