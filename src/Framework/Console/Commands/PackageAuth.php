<?php

namespace Framework\Console\Commands;

use Framework\Console\Command;

class PackageAuth extends Command
{

    public function signature(): string
    {
        return 'package:auth';
    }

    public function description(): string
    {
        return 'Install authentication scaffolding';
    }

    public function handle(array $args): void
    {
        // TODO: Implement handle() method.
    }
}