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
        $name = $args[0] ?? '';
        if (!$name) {
            $this->error('Please provide a rate limit name');
            return;
        }

        $class =  str_ends_with($name, 'RateLimiter') ? $name : "{$name}RateLimiter";
        $path = BASE_PATH . "/src/App/Middleware";
        $file = "{$path}/{$class}.php";
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        if (file_exists($file)) {
            $this->error("Rate limit '{$class}' already exists");
            return;
        }

        $stubPath = dirname(__DIR__, 4) . '/stubs/ratelimit.stub';
        if (!file_exists($stubPath)) {
            $this->error("Stub file not found: {$stubPath}");
            return;
        }

        $stub = file_get_contents($stubPath);
        $content = str_replace(
            ['{{class}}', '{{max}}', '{{decay}}', '{{key}}'],
            [$class, 60, 60, strtolower($class)],
            $stub,
        );

        file_put_contents($file, $content);
        $this->success("Rate limit '{$class}' created successfully");
    }
}