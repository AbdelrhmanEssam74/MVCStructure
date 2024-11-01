<?php

namespace PROJECT\Validation\Rules;

use PROJECT\Validation\Rules\Contract\Rules;

class PasswordConfirmation implements Rules
{

    public function apply($field, $value, $data)
    {
        return ($data[$field] === $data[$field . '_confirmation']);
    }

    public function __toString()
    {
        return "%s is not matching %s confirmation";
    }
}