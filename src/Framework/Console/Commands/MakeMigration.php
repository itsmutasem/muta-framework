<?php

namespace Framework\Console\Commands;

use Framework\Console\Command;

class MakeMigration extends Command
{

    public function signature(): string
    {
        return 'make:migration';
    }

    public function description(): string
    {
        return 'Create a new migration file';
    }

    public function handle(array $args): void
    {
        // TODO: Implement handle() method.
    }
}