<?php

namespace PROJECT\support;

class Hash
{
    /**
     * Hashes a password using the BCRYPT algorithm.
     *
     * This method provides a secure way to hash passwords for storage in the database.
     * It uses PHP's built-in password_hash function with the BCRYPT algorithm.
     *
     * @param string $password The plain-text password to be hashed.
     *
     * @return string The hashed password as a string.
     */
    public static function hash(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * Verifies a plain-text password against a hashed password.
     *
     * This method uses PHP's built-in password_verify function to securely
     * compare a plain-text password with a hashed password.
     *
     * @param string $password      The plain-text password to verify.
     * @param string $hashedPassword The hashed password to compare against.
     *
     * @return bool Returns true if the password matches the hash, false otherwise.
     */
    public static function verify(string $password, string $hashedPassword): bool
    {
        return password_verify($password, $hashedPassword);
    }

    /**
     * Generates a hashed token based on a given value and a timestamp.
     *
     * This method creates a unique token by hashing a combination of the provided value and the current timestamp.
     * It's useful for generating tokens for various purposes like password reset, email verification, or session tokens.
     *
     * **Note:** While SHA-1 is still usable, it's recommended to consider more secure hashing algorithms like SHA-256 or Argon2 for enhanced security, especially for sensitive data.
     *
     * @param string $value The base value to be hashed.
     *
     * @return string The generated hashed token.
     */
    public static function makeToken(string $value): string
    {
        return sha1($value . time());
    }
}