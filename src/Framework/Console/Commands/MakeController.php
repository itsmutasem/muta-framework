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
        $name = $args[0] ?? '';

        if (!$name) {
            $this->error('Please provide a controller name');
            return;
        }

        $parts = explode('/', $name);
        $class = array_pop($parts);
        $subPath = implode('/', $parts);

        $basePath = 'src/App/Controllers';
        $path = $basePath . ($subPath ? "/{$subPath}" : '');
        $file = "{$path}/{$class}.php";

        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        if (file_exists($file)) {
            $this->error("Controller '{$class}' already exists");
            return;
        }

        $namespace = 'App\Controllers' . ($subPath ? '\\' . str_replace('/', '\\', $subPath) : '');
        $stubPath = dirname(__DIR__, 4) . '/stubs/controller.stub';
        if (!file_exists($stubPath)) {
            $this->error("Stub file '{$stubPath}' not found");
        }
        $stub = file_get_contents($stubPath);
        $content = str_replace(['{{namespace}}', '{{class}}'], [$namespace, $class], $stub);
        file_put_contents($file, $content);
        $this->info("Controller '{$class}' created successfully");
    }
}