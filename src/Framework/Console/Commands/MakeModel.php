<?php

namespace Framework\Console\Commands;

use Framework\Console\Command;

class MakeModel extends Command
{

    public function signature(): string
    {
        return 'make:model';
    }

    public function description(): string
    {
        return 'Create a new model';
    }

    public function handle(array $args): void
    {
        // TODO: Implement handle() method.
    }
}