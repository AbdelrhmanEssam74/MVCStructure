<?php

namespace PROJECT\Validation;

use PROJECT\Validation\Rules\RequireRule;

trait RuleMap
{
  protected static array $map = [
    'required' => RequireRule::class,
  ];

  public static function resolve(string $rule, $options)
  {
    return new static::$map[$rule](...$options);
  }
}
