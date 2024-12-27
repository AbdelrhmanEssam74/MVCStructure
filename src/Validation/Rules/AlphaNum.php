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
    $message = app()->lang->get(getLanguage())['validation']['alpha-num'];
    if (getLanguage() === 'ar')
      return $message;
    else
      return $message;
  }
}
