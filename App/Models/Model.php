<?php

namespace App\Models;

use PROJECT\support\str;

abstract class Model
{
    protected static $instance;

    public static function create($data)
    {
        self::$instance = static::class;
        return app()->db->create($data);
    }
    public static function login($data)
    {
        self::$instance = static::class;
        return app()->db->create($data);
    }
    public static function update($id, array $attributes)
    {
        self::$instance = static::class;
        return app()->db->update($id, $attributes);
    }

    public static function delete($id)
    {
        self::$instance = static::class;

        return app()->db->delete($id);
    }

    public static function all()
    {
        self::$instance = static::class;
        return app()->db->read();
    }

    public static function where($filter, $columns = "*")
    {
        self::$instance = static::class;
        return app()->db->read($columns, $filter);
    }

    public static function getModel()
    {
        return self::$instance;
    }

    public static function getTableName(): string
    {
        return str::lower(str::plural(class_basename(self::$instance)));
    }
}