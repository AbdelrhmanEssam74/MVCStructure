<?php

namespace PROJECT\Validation\Rules;

use PROJECT\Validation\Rules\Contract\Rules;

class EmailRule implements Rules
{

    public function apply($field, $value, $data)
    {
    return (filter_var($value , FILTER_VALIDATE_EMAIL));
    }

    public function __toString()
    {
        return "Your %s is not a valid email address";
    }
}