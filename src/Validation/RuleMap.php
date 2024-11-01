<?php

namespace PROJECT\Validation;

use PROJECT\Validation\Rules\AlphaNum;
use PROJECT\Validation\Rules\BetweenRule;
use PROJECT\Validation\Rules\EmailExistsRule;
use PROJECT\Validation\Rules\PasswordVerification;
use PROJECT\Validation\Rules\EmailRule;
use PROJECT\Validation\Rules\MaxRule;
use PROJECT\Validation\Rules\PasswordConfirmation;
use PROJECT\Validation\Rules\RequireRule;
use PROJECT\Validation\Rules\UniqueRule;

trait RuleMap
{
    protected static array $map = [
        'required' => RequireRule::class,
        'alphaNum' => AlphaNum::class,
        'max' => MaxRule::class,
        'between' => BetweenRule::class,
        'email' => EmailRule::class,
        'password_confirmation' => PasswordConfirmation::class,
        'unique' => UniqueRule::class,
        'password_verification' => PasswordVerification::class,
        'email_exists' => EmailExistsRule::class,
    ];

    public static function resolve(string $rule, $options)
    {
        return new static::$map[$rule](...$options);
    }
}
