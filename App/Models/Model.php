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
  public static function update($column, $value, array $attributes)
  {
    self::$instance = static::class;
    return app()->db->update($column, $value, $attributes);
  }

  public static function delete($column, $value)
  {
    self::$instance = static::class;

    return app()->db->delete($column, $value);
  }

  public static function all()
  {
    self::$instance = static::class;
    return app()->db->read();
  }

  public static function where($columns = "*",$filter)
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
