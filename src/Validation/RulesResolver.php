<?php

namespace PROJECT\Validation;

trait RulesResolver
{
    /**
     * Resolves the validation rules provided for a field.
     *
     * @param array $rules The rules to resolve.
     * @return array The resolved rules.
     */
    protected function RulesResolverMake(array|string $rules): array
    {
        $rules = str_contains($rules, '|') ? explode('|', $rules) : array($rules);
        return array_map(function ($rule) {
            if (is_string($rule)) {
                return $this->getRuleFromString($rule);
            }
        }, $rules);
    }

    /**
     * Retrieves the rule object based on the rule name provided.
     *
     * @param string $rule The rule name.
     * @return mixed The rule object.
     */
    protected function getRuleFromString(string $rule): mixed
    {
        $exploded = explode(':', $rule);
        $rule = $exploded[0];
        $options = explode(",", end($exploded));
        return self::resolve($rule, $options);
    }
}