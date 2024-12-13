<?php

namespace PROJECT\Validation\Rules;

use PROJECT\Validation\Rules\Contract\Rules;

class PasswordVerification implements Rules
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
        $query_result = (object)app()->db->row("SELECT password FROM `users` WHERE email = ?", [request()->get('email')])[0];
        return (password_verify($value, $query_result->password));
    }

    public function __toString()
    {
        return "Wrong password";
    }
}