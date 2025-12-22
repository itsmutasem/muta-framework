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
        $this->info('Installing Auth package...');
    }

    public function publish(string $from, string $to): void
    {
        if (!is_dir(dirname($to))) {
            mkdir(dirname($to), 0777, true);
        }
        if (file_exists($to)) {
            $this->error("File '{$to}' already exists, skipped");
            return;
        }
        copy($from, $to);
    }
}