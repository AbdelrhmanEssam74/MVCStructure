<?php

namespace PROJECT\support;

class Hash
{
    public static function hash($password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public static function verify($password, $hashedPassword): bool
    {
        return password_verify($password, $hashedPassword);
    }

    public static function makeToken($value): string
    {
        return sha1($value . time());
    }
}