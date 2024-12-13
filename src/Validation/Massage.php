<?php

namespace PROJECT\Validation;

class Massage
{
    public static function generator($rule, $field): array|string
    {
        $field = ucwords(trim($field ,'_'));
        return str_replace("%s", $field, $rule);
    }
}