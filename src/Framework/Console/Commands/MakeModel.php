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
        $name = $args[0] ?? null;
        if (!$name) {
            $this->error('Please provide a model name');
            return;
        }

        $file = "src/App/Models/{$name}.php";
        if (file_exists($file)) {
            $this->error("Model '{$name}' already exists");
            return;
        }

        $stubPath = dirname(__DIR__, 4) . '/stubs/model.stub';
        if (!file_exists($stubPath)) {
            $this->error("Stub file '{$stubPath}' not found");
        }
        $stub = file_get_contents($stubPath);
        $content = str_replace(
            ['{{namespace}}', '{{class}}', '{{table}}'],
            ['App\Models', $name, strtolower($name) . 's'],
            $stub
        );
        file_put_contents($file, $content);
        $this->info("Model '{$name}' created successfully");
    }
}