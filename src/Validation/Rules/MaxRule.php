<?php

namespace PROJECT\Validation\Rules;

use PROJECT\Validation\Rules\Contract\Rules;

class MaxRule implements Rules
{
  protected int $max;

  public function __construct(int $max)
  {
    $this->max = $max;
  }

  public function apply($field, $value, $data): bool
  {
    return (strlen($value) > $this->max);
  }

  public function __toString()
  {
    $message = app()->lang->get(getLanguage())['validation']['max-length'];
    if (getLanguage() === 'ar')
      return "{$message}";
    else
      return str_replace(':max', $this->max, "{$message}");
  }
}
