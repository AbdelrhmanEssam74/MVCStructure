<?php

namespace PROJECT\Validation\Rules;

use PROJECT\Validation\Rules\Contract\Rules;

class BetweenRule implements Contract\Rules
{
  protected int $min;
  protected int $max;

  public function __construct($min, $max)
  {
    $this->min = $min;
    $this->max = $max;
  }
  public function apply($field, $value, $data): bool
  {
    if (strlen($value) < $this->min || strlen($value) > $this->max) {
      return false;
    }
    return true;
  }

  public function __toString()
  {
    $message = app()->lang->get(getLanguage())['validation']['between'];
    return str_replace([':max', ':min'], [$this->min, $this->max], $message);
  }
}
