<?php

namespace Framework\Console\Commands;

use Framework\Console\Command;

class InstallAuth extends Command
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
            $this->warning("File '{$to}' already exists, skipped");
            return;
        }
        copy($from, $to);
    }

    public function copyController(): void
    {
        $this->publish(
            BASE_PATH . '/src/Framework/Packages/Auth/stubs/controller.stub',
            BASE_PATH . '/src/App/Controllers/Auth/AuthController.php'
        );
    }

    public function copyModel(): void
    {
        $this->publish(
            BASE_PATH . '/src/Framework/Packages/Auth/stubs/model.stub',
            BASE_PATH . '/src/App/Models/User.php'
        );
    }

    public function copyMiddleware(): void
    {
        $this->publish(
            BASE_PATH . '/src/Framework/Packages/Auth/stubs/middleware.stub',
            BASE_PATH . '/src/App/Middleware/AuthenticateMiddleware.php'
        );
    }

    public function copyView(): void
    {
        $this->publish(
            BASE_PATH . '/src/Framework/Packages/Auth/stubs/view.stub',
            BASE_PATH . '/views/auth/login.mvc.php'
        );
    }
}