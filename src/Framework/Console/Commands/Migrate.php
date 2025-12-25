<?php

namespace Framework\Console\Commands;

use Framework\Console\Command;

class Migrate extends Command
{

    public function signature(): string
    {
        return 'migrate';
    }

    public function description(): string
    {
        return 'Run the database migrations';
    }

    public function handle(array $args): void
    {
        // TODO: Implement handle() method.
    }
}