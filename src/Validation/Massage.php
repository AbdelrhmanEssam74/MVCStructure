<?php

namespace PROJECT\Validation;

class Massage
{
  public static function generator($rule, $field): array|string
  {
    $field = ucwords(str_replace('_', " ", $field));
    return str_replace("%s", $field, $rule);
  }
}
