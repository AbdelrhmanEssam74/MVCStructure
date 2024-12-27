<?php

namespace PROJECT\support;

class Languages
{
  protected array $lang = [];
  protected string $langCode = "";
  public function __construct($items = [])
  {
    foreach ($items as $key => $item) {
      $this->lang[$key] = $item;
    }
  }
  public function get($key, $default = null)
  {
    return Arr::get($this->lang, $key, $default);
  }
}
