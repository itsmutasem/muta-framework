<?php

declare(strict_types=1);

namespace Framework;

use ErrorException;

class ErrorHandler
{
    public static function ErrorHandler(
        int $errno,
        string $errstr,
        string $errfile,
        int $errline):bool
    {
        throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
    }
}
