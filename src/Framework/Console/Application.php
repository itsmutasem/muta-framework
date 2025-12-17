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

    protected function list(): void
    {
        echo "Muta CLI available commands:\n\n";
        foreach ($this->commands as $cmd) {
            echo " - {$cmd->signature()} → {$cmd->description()}\n";
        }
    }
}