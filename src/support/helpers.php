<?php

use PROJECT\Application;
use PROJECT\HTTP\Request;
use PROJECT\HTTP\Response;
use PROJECT\support\Hash;

/**
 * @description
 * The env function is used to retrieve the value of an environment variable identified by the provided key.
 * If the variable is not found, the function falls back to a default value specified by the second argument.
 */
if (!function_exists("env")):
    function env($key, $value = null)
    {
        return $_ENV[$key] ?? value($value);
    }
endif;
/**
 * @description
 * the value function is a utility function that checks if the provided value is a Closure (anonymous function).
 * If it is a Closure, the function executes it and returns the result. Otherwise, it simply returns the provided value.
 */
if (!function_exists("value")):
    function value($value)
    {
        return ($value instanceof Closure) ? $value() : $value;
    }
endif;

/**
 * @description
 * The base_path function returns the base directory path of the project by using dirname(__DIR__) to get the parent directory of the current file and appending '/../' to move up one level in the directory structure.
 */
if (!function_exists("base_path")):
    function base_path(): string
    {
        return dirname(__DIR__) . '/../';
    }
endif;

/**
 * @description
 * The view_path function returns the path to the directory where views (templates or HTML files) are typically stored within the project. It utilizes the base_path function to get the base directory path and appends 'views/' to it.
 */
if (!function_exists("view_path")):
    function view_path(): string
    {
        return base_path() . 'views/';
    }
endif;

if (!function_exists("old")) {
    function old($key)
    {
        if (app()->session->hasFlash('old')) {
            return app()->session->getFlash('old')[$key];
        }
    }
}
if (!function_exists("request")) {
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
}
if (!function_exists("backRedirect")) {
    function backRedirect(): null
    {
        return (new Response)->back();
    }
}
if (!function_exists("app")) {
    function app(): ?Application
    {
        static $instance = null;
        if (!$instance) {
            $instance = new Application;
        }
        return $instance;
    }
}
if (!function_exists("class_basename")) {
    function class_basename($class): string
    {
        $class = is_object($class) ? get_class($class) : $class;
        return basename(str_replace("\\", "/", $class));
    }
}
if (!function_exists("bcrypt")) {
    function bcrypt($password): string
    {
        return Hash::hash($password);
    }
}

if (!function_exists("config_path")) {
    function config_path(): string
    {
        return base_path() . 'config/';
    }
}
if (!function_exists("config")) {
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

    if (!function_exists("RedirectTo")) {
        function RedirectToView($path): void
        {
            header("Location:" . env('HOST') . $path);
        }
    }
}