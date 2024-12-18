<?php

namespace PROJECT\support;

use ArrayAccess;

class Arr
{
    /**
     * Get a subset of the items from the given array.
     *
     * @param array $array The source array.
     * @param array|string $keys The keys to extract.
     * @return array The subset of the array.
     */
    public static function only($array, $keys): array
    {
        return array_intersect_key($array, array_flip((array)$keys));
    }

    /**
     * Determine if the given value is accessible like an array.
     *
     * @param mixed $value The value to check.
     * @return bool True if accessible, false otherwise.
     */
    public static function accessible($value): bool
    {
        return is_array($value) || $value instanceof ArrayAccess;
    }

    /**
     * Check if a given key exists in an array or ArrayAccess object.
     *
     * @param array|ArrayAccess $array The array or object to check.
     * @param string|int $key The key to look for.
     * @return bool True if the key exists, false otherwise.
     */
    public static function exists($array, $key): bool
    {
        if ($array instanceof ArrayAccess) {
            return $array->offsetExists($key);
        }

        return array_key_exists($key, $array);
    }

    /**
     * Set an array item to a given value, using dot notation for nested keys.
     *
     * @param array $array The array to modify.
     * @param string|int $key The key to set.
     * @param mixed $value The value to assign.
     * @return array The modified array.
     */
    public static function set(&$array, $key, $value): array
    {
        if (is_null($key)) {
            return $array = $value;
        }

        $keys = explode('.', $key);

        while (count($keys) > 1) {
            $key = array_shift($keys);

            if (!isset($array[$key]) || !is_array($array[$key])) {
                $array[$key] = [];
            }

            $array = &$array[$key];
        }

        $array[array_shift($keys)] = $value;

        return $array;
    }

    /**
     * Add an item to the array if it does not already exist.
     *
     * @param array $array The array to modify.
     * @param string|int $key The key to set.
     * @param mixed $value The value to assign.
     * @return array The modified array.
     */
    public static function add($array, $key, $value)
    {
        if (is_null(static::get($array, $key))) {
            static::set($array, $key, $value);
        }

        return $array;
    }

    /**
     * Remove specified keys from the array.
     *
     * @param array $array The array to modify.
     * @param array|string $keys The keys to remove.
     * @return array The modified array.
     */
    public static function except($array, $keys)
    {
        static::forget($array, $keys);

        return $array;
    }

    /**
     * Get the first element in an array passing a given truth test.
     *
     * @param array $array The source array.
     * @param callable|null $callback A callback to evaluate.
     * @param mixed $default The default value if no match is found.
     * @return mixed The first matching element or the default value.
     */
    public static function first($array, callable $callback = null, $default = null)
    {
        if (is_null($callback)) {
            if (empty($array)) {
                return value($default);
            }

            foreach ($array as $item) {
                return $item;
            }
        }

        foreach ($array as $key => $value) {
            if ($callback($value, $key)) {
                return call_user_func($callback, $value, $key);
            }
        }

        return value($default);
    }

    /**
     * Check if an array has a specified set of keys.
     *
     * @param array $array The array to check.
     * @param array|string $keys The keys to check for.
     * @return bool True if all keys exist, false otherwise.
     */
    public static function has($array, $keys)
    {
        if (is_null($keys)) {
            return false;
        }

        $keys = (array)$keys;

        foreach ($keys as $key) {
            $subKeyArray = $array;

            if (!static::exists($array, $key)) {
                foreach (explode('.', $key) as $segment) {
                    if (static::accessible($subKeyArray) && static::exists($subKeyArray, $segment)) {
                        $subKeyArray = $subKeyArray[$segment];
                    } else {
                        return false;
                    }
                }
            }
        }

        return true;
    }

    /**
     * Get the last element in an array passing a given truth test.
     *
     * @param array $array The source array.
     * @param callable|null $callback A callback to evaluate.
     * @param mixed $default The default value if no match is found.
     * @return mixed The last matching element or the default value.
     */
    public static function last($array, callable $callback = null, $default = null)
    {
        if (is_null($callback)) {
            return empty($array) ? value($default) : end($array);
        }

        return static::first(array_reverse($array, true), $callback, $default);
    }

    /**
     * Flatten a multi-dimensional array into a single level.
     *
     * @param array $array The source array.
     * @param int $depth The maximum depth to flatten.
     * @return array The flattened array.
     */
    public static function flatten($array, $depth = INF)
    {
        $result = [];

        foreach ($array as $item) {
            if (!is_array($item)) {
                $result[] = $item;
            } elseif ($depth === 1) {
                $result = array_merge($result, array_values($item));
            } else {
                $result = array_merge($result, static::flatten($item, $depth - 1));
            }
        }

        return $result;
    }

    /**
     * Remove a set of keys from an array using dot notation.
     *
     * @param array $array The array to modify.
     * @param array|string $keys The keys to forget.
     */
    public static function forget(&$array, $keys)
    {
        $original = &$array;
        $keys = (array)$keys;

        foreach ($keys as $key) {
            if (static::exists($array, $key)) {
                unset($array[$key]);
                continue;
            }

            $parts = explode('.', $key);
            $array = &$original;

            while (count($parts) > 1) {
                $part = array_shift($parts);

                if (isset($array[$part]) && is_array($array[$part])) {
                    $array = &$array[$part];
                } else {
                    continue 2;
                }
            }

            unset($array[array_shift($parts)]);
        }
    }

    /**
     * Get an item from an array using dot notation.
     *
     * @param array $array The source array.
     * @param string|int|null $key The key to retrieve.
     * @param mixed $default The default value if the key does not exist.
     * @return mixed The value from the array or the default.
     */
    public static function get($array, $key, $default = null)
    {
        if (!static::accessible($array)) {
            return value($default);
        }

        if (is_null($key)) {
            return $array;
        }

        if (static::exists($array, $key)) {
            return $array[$key];
        }

        if (strpos($key, '.') === false) {
            return $array[$key] ?? value($default);
        }

        foreach (explode('.', $key) as $segment) {
            if (static::accessible($array) && static::exists($array, $segment)) {
                $array = $array[$segment];
            } else {
                return value($default);
            }
        }

        return $array;
    }
}
