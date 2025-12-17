<?php

namespace Framework\Console;

class Application
{
    protected array $commands = [];

    public function __construct()
    {

    }

    public function register(Command $command): void
    {
        $this->commands[$command->signature()] = $command;
    }
}