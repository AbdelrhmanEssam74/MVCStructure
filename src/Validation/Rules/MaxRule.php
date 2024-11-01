<?php

namespace PROJECT\Validation\Rules;

use PROJECT\Validation\Rules\Contract\Rules;

class MaxRule implements Contract\Rules
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
        return "%s length must be more than {$this->max} characters";
    }
}