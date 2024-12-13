<?php

namespace PROJECT\HTTP;

class Response
{
    /**
     * Set the HTTP status code for the response.
     *
     * @param int $code The HTTP status code to set.
     */
    public function setStatusCode(int $code): void
    {
        if ($code < 100 || $code > 599) {
            throw new \InvalidArgumentException("Invalid HTTP status code: $code");
        }

        http_response_code($code);
    }

    /**
     * Redirect to the referring page.
     */
    public function back(): void
    {
        $referer = $_SERVER['HTTP_REFERER'] ?? null;

        if (!$referer) {
            throw new \RuntimeException('HTTP_REFERER is not set, unable to redirect back.');
        }

        header("Location: $referer");
        exit;
    }

    /**
     * Redirect to a specified URL.
     *
     * @param string $url The URL to redirect to.
     * @param int $statusCode Optional HTTP status code for redirection. Defaults to 302.
     */
    public function redirect(string $url, int $statusCode = 302): void
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException("Invalid URL: $url");
        }

        $this->setStatusCode($statusCode);
        header("Location: $url");
        exit;
    }

    /**
     * Send a JSON response.
     *
     * @param mixed $data The data to encode as JSON.
     * @param int $statusCode Optional HTTP status code for the response. Defaults to 200.
     */
    public function json(mixed $data, int $statusCode = 200): void
    {
        $this->setStatusCode($statusCode);
        header('Content-Type: application/json');

        echo json_encode($data);
        exit;
    }

    /**
     * Send plain text response.
     *
     * @param string $text The text to send in the response.
     * @param int $statusCode Optional HTTP status code for the response. Defaults to 200.
     */
    public function text(string $text, int $statusCode = 200): void
    {
        $this->setStatusCode($statusCode);
        header('Content-Type: text/plain');

        echo $text;
        exit;
    }
}