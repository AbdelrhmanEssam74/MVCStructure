<?php

namespace PROJECT\Validation;

class Massage
{
    public static function generator($rule, $field): array|string
    {
        return str_replace("%s", $field, $rule);
    }
}