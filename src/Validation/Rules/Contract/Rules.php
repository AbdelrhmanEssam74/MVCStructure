<?php

namespace PROJECT\Validation\Rules\Contract;

interface Rules
{
    public function apply($field, $value , $data);
    public function __toString();
}