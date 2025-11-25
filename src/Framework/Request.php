<?php

declare(strict_types=1);

namespace Framework;

use Framework\Security\Sanitizer;

class Request
{
    public function __construct(public string $uri,
                                public string $method,
                                public array $get,
                                public array $post,
                                public array $files,
                                public array $cookie,
                                public array $server,
                                )
    {
    }

    public static function createFromGlobals()
    {
        return new static(
            $_SERVER['REQUEST_URI'],
            $_SERVER['REQUEST_METHOD'],
            Sanitizer::clean($_GET),
            Sanitizer::clean($_POST),
            Sanitizer::clean($_FILES),
            Sanitizer::clean($_COOKIE),
            $_SERVER
        );
    }
}