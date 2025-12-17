<?php

namespace Framework\Console\Commands;

use Framework\Console\Command;

class MakeController extends Command
{

    public function signature(): string
    {
        return 'make:controller';
    }

    public function description(): string
    {
        return 'Create a new controller';
    }

    public function handle(array $args): void
    {

    }
}