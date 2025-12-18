<?php

namespace Framework\Console;

use Framework\Console\Commands\MakeController;
use Framework\Console\Commands\MakeModel;

class Application
{
    protected array $commands = [];

    public function __construct()
    {
        $this->register(new MakeController());
        $this->register(new MakeModel());
    }

    public function register(Command $command): void
    {
        $this->commands[$command->signature()] = $command;
    }

    public function run(array $argv): void
    {
        $command = $argv[1] ?? null;
        if (!$command || !isset($this->commands[$command])) {
            $this->list();
            return;
        }
        $this->commands[$command]->handle(array_slice($argv, 2));
    }

    protected function list(): void
    {
        echo "Muta CLI available commands:\n\n";
        foreach ($this->commands as $cmd) {
            echo " - {$cmd->signature()} → {$cmd->description()}\n";
        }
    }
}