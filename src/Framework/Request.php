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
        $cleanGet = Sanitizer::clean($_GET);
        $cleanPost = Sanitizer::clean($_POST);
        $cleanCookie = Sanitizer::clean($_COOKIE);

        return new static(
            $_SERVER['REQUEST_URI'],
            $_SERVER['REQUEST_METHOD'],
            $_GET,
            $_POST,
            $_FILES,
            $_COOKIE,
            $_SERVER
        );
    }
}