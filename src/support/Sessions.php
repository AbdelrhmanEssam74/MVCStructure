<?php

namespace PROJECT\support;
session_start();

/**
 * Class Sessions
 * Handles session management, including flash messages and standard session variables.
 */
class Sessions
{
    /**
     * Key used to store flash messages in the session.
     */
    protected const FLASH_KEY = 'flash_messages';

    /**
     * Constructor
     * Initializes the session and marks existing flash messages for removal.
     */
    public function __construct()
    {
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flashMessages as $key => &$flashMessage) {
            $flashMessage['remove'] = true;
        }
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }

    /**
     * Sets a flash message.
     * Flash messages persist for one request and are automatically removed afterwards.
     *
     * @param string $key The key to identify the flash message.
     * @param string $message The message to store.
     */
    public function setFlash($key, $message): void
    {
        $_SESSION[self::FLASH_KEY][$key] = [
            'remove' => false,
            'value' => $message
        ];
    }

    /**
     * Retrieves a flash message.
     *
     * @param string $key The key identifying the flash message.
     * @return string|false The flash message value, or false if not set.
     */
    public function getFlash($key)
    {
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
    }

    /**
     * Stores a value in the session.
     *
     * @param string $key The key to identify the value.
     * @param mixed $value The value to store.
     */
    public function set($key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Checks if a flash message exists.
     *
     * @param string $key The key identifying the flash message.
     * @return bool True if the flash message exists, false otherwise.
     */
    public function hasFlash($key): bool
    {
        return (isset($_SESSION[self::FLASH_KEY][$key]));
    }

    /**
     * Checks if a session variable exists.
     *
     * @param string $key The key identifying the session variable.
     * @return bool True if the variable exists, false otherwise.
     */
    public function exists($key): bool
    {
        return (isset($_SESSION[$key]));
    }

    /**
     * Retrieves a value from the session.
     *
     * @param string $key The key identifying the value.
     * @return mixed The value, or false if not set.
     */
    public function get($key)
    {
        return $_SESSION[$key] ?? false;
    }

    /**
     * Removes a value from the session.
     *
     * @param string $key The key identifying the value to remove.
     */
    public function remove($key): void
    {
        unset($_SESSION[$key]);
    }

    /**
     * Destructor
     * Cleans up flash messages marked for removal.
     */
    public function __destruct()
    {
        $this->removeFlashMessages();
    }

    /**
     * Removes flash messages marked for removal.
     */
    private function removeFlashMessages(): void
    {
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flashMessages as $key => $flashMessage) {
            if ($flashMessage['remove']) {
                unset($flashMessages[$key]);
            }
        }
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }
}
