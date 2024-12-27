<?php

namespace PROJECT\Validation\Rules;

use PROJECT\Validation\Rules\Contract\Rules;

class UniqueRule implements Rules
{

  protected string $table;

  protected string $column;

  public function __construct($table, $column)
  {
    $this->table = $table;
    $this->column = $column;
  }

  public function apply($field, $value, $data = []): bool
  {
    return !(app()->db->row("SELECT * FROM {$this->table} WHERE {$this->column} = ?", [$value]));
  }

  public function __toString()
  {
    $message = app()->lang->get(getLanguage())['validation']['exists'];
    if (getLanguage() === 'ar')
      return "{$message}";
    else
      return "{$message}";
  }
}
