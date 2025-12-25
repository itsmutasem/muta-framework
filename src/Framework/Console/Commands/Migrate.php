<?php

namespace Framework\Console\Commands;

use Framework\Console\Command;
use PDO;

class Migrate extends Command
{

    public function signature(): string
    {
        return 'migrate';
    }

    public function description(): string
    {
        return 'Run the database migrations';
    }

    public function handle(array $args): void
    {
        // TODO: Implement handle() method.
    protected function ensureMigrationsTable(PDO $db): void
    {
        $db->exec("
        CREATE TABLE IF NOT EXISTS migrations (
                id INT AUTO_INCREMENT PRIMARY KEY,
                migration VARCHAR(255) UNIQUE,
                batch INT,
                executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ");
    }
}