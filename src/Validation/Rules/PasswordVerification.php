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
        return (password_verify($value, app()->db->row("SELECT `password` FROM `users` WHERE email = ?", [request()->get('email')])[0]->password));
    }

    public function __toString()
    {
        return "Wrong password";
    }
}