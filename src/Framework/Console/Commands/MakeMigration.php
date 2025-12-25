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
        $name = $args[0] ?? '';
        if (!$name) {
            $this->error('Please provide a migration name');
            return;
        }

        $timestamp = date('Y_m_d_His');
        $filename = "{$timestamp}_{$name}.php";
        $className = str_replace(' ', '', ucwords(str_replace('_', ' ', $name)));

        $stubPath = dirname(__DIR__, 4) . '/stubs/migration.stub';
        if (!file_exists($stubPath)) {
            $this->error("Stub file not found: {$stubPath}");
        }

        $stub = file_get_contents($stubPath);
        $stub = str_replace('{{class}}', $className, $stub);

        $dir = BASE_PATH . '/database/migrations';
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $path = "{$dir}/{$filename}";
        file_put_contents($path, $stub);
        $this->success("Migration '{$filename}' created successfully");
    }
}