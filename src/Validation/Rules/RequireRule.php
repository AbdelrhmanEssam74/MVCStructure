<?php

namespace PROJECT\Validation\Rules;

use PROJECT\Validation\Rules\Contract\Rules;

class RequireRule implements Rules
{
    public function apply($field, $value, $data): bool
    {
        return !empty($value);
    }
    public function __toString()
    {
        return "%s is required and cannot be empty";
    }

}