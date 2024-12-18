<?php

namespace App\Models;

use PROJECT\support\str;

abstract class Model
{
  protected static $instance;

    /**
     * Create a new row in the database table.
     * @param array $data Key-value pairs representing column names and their respective values.
     * Example: ['column_name' => 'value']
     */
  public static function create($data)
  {
    self::$instance = static::class;
    return app()->db->create($data);
  }
    /**
     * Update existing records in the database.
     * @param string $whereColumn Column name for the WHERE clause.
     * @param mixed $value Value to filter the records by.
     * @param array $data Key-value pairs for columns to be updated.
     * Example: ['column_to_update' => 'new_value']
     */
  public static function update($column, $value, array $attributes)
  {
    self::$instance = static::class;
    return app()->db->update($column, $value, $attributes);
  }

    /**
     * Delete records from the database.
     * @param string $whereColumn Column name for the WHERE clause.
     * @param mixed $value Value to filter the records by.
     */
  public static function delete($column, $value)
  {
    self::$instance = static::class;

    return app()->db->delete($column, $value);
  }

    /**
     * Fetch all records from the database.
     * @return  List of all records.
     */
  public static function all()
  {
    self::$instance = static::class;
    return app()->db->read();
  }

    /**
     * Fetch specific records based on filter conditions.
     * @param array|string $columns Columns to retrieve (e.g., ["column1", "column2"]) or '*' for all columns.
     * @param array $filter Filter conditions as ["column", "operator", "value"].
     * Example: ["age", ">", "18"]
     * @return  List of filtered records.
     */
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
