<?php

namespace Framework\Console\Commands;

use Framework\Console\Command;

class MakeMiddleware extends Command
{

    public function signature(): string
    {
        return 'make:middleware';
    }

    public function description(): string
    {
        return 'Create a new middleware';
    }

    public function handle(array $args): void
    {
        $name = $args[0] ?? null;
        if (!$name) {
            $this->error('Please provide a middleware name');
            return;
        }

        $basePath = dirname(__DIR__, 4) . '/src/App/Middleware';
        $file = "{$basePath}/{$name}.php";
        if (!is_dir($basePath)) {
            mkdir($basePath, 0777, true);
        }
        if (file_exists($file)) {
            $this->error("Middleware '{$name}' already exists");
            return;
        }

        $stubPath = dirname(__DIR__, 4) . '/stubs/middleware.stub';
        if (!file_exists($stubPath)) {
            $this->error("Stub file not found: {$stubPath}");
            return;
        }

        $stub = file_get_contents($stubPath);
        $content = str_replace(
            ['{{namespace}}', '{{class}}'],
            ['App\\Middleware', $name],
            $stub
        );
        file_put_contents($file, $content);
        $this->info("Middleware '{$name}' created successfully");
    }
}