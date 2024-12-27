<?php

namespace PROJECT\Validation\Rules;

use PROJECT\Validation\Rules\Contract\Rules;

class EmailActiveRule implements Rules
{

  protected $table;
  protected $column;
  public function __construct($table, $column)
  {
    $this->table = $table;
    $this->column = $column;
  }
  public function apply($field, $value, $data): false|int
  {
    return (app()->db->row("SELECT {$this->column} FROM {$this->table} WHERE email = ?", [request('email')])[0]->active) ?? false;
  }

  public function __toString()
  {
    $message = app()->lang->get(getLanguage())['validation']['email-not-active'];
    return "{$message} .  <strong><a data-bs-toggle='modal' data-bs-target='#exampleModal' data-whatever='@mdo'  href='#'>Active</a></strong>";
  }
}
