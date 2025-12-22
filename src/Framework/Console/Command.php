<?php

namespace Framework\Console;

abstract class Command
{
    abstract public function signature(): string;
    abstract public function description(): string;
    abstract public function handle(array $args): void;

    protected function info(string $message): void
    {
        echo "\033[32m✔ {$message}\033[0m\n";
    }

    protected function error(string $message): void
    {
        echo "\033[31m✖ {$message}\033[0m\n";
    }

    protected function success(string $message): void
    {
        echo "\033[32m✔ {$message}\033[0m\n";
    }

    protected function warning(string $message): void
    {
        echo "\033[33m⚠ {$message}\033[0m\n";
    }
}