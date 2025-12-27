<?php

namespace Framework\Console\Commands;

use Framework\Console\Command;

class MakeRateLimit extends Command
{

    public function signature(): string
    {
        return 'make:ratelimit';
    }

    public function description(): string
    {
        return 'Create a new rate limit';
    }

    public function handle(array $args): void
    {
        // TODO: Implement handle() method.
    }
}