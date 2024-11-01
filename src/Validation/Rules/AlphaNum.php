<?php

namespace PROJECT\Validation\Rules;

use PROJECT\Validation\Rules\Contract\Rules;

class AlphaNum implements Rules
{

    public function apply($field, $value, $data): false|int
    {
        return preg_match("/[a-zA-Z0-9]+/", $value);
    }

    public function __toString()
    {
        return "%s must be a characters and numbers only";
    }
}