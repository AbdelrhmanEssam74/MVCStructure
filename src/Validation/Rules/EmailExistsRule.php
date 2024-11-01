<?php

namespace PROJECT\Validation\Rules;

use PROJECT\Validation\Rules\Contract\Rules;

class EmailExistsRule implements Contract\Rules
{
    protected string $table;

    protected string $column;

    public function __construct($table, $column)
    {
        $this->table = $table;
        $this->column = $column;
    }

    public function apply($field, $value, $data)
    {
        return (app()->db->row("SELECT {$this->column} FROM {$this->table} WHERE email = ?", [request()->all()['email']]));
    }

    public function __toString()
    {
        return "Email Not Exists";
    }
}