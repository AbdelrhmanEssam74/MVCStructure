<?php

namespace PROJECT\HTTP;

class Response
{
    public function setStatusCode(int $code): void
    {
        http_response_code($code);
    }

    public function back(): void
    {
        header("Location:" . $_SERVER['HTTP_REFERER']);
    }
}