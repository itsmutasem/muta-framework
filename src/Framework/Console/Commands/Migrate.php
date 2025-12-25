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
        $db = $this->container->get(PDO::class);
        $this->info('Migrating...');
        $this->ensureMigrationsTable($db);
        $run = $this->getRunMigrations($db);
        $files = glob(BASE_PATH . '/database/migrations/*.php');
        $batch = $this->nextBatch($db);
        foreach ($files as $file) {
            $name = basename($file);
            if (in_array($name, $run)) {
                continue;
            }

            $this->info("Running migration: {$name}");

            $migration = require $file;
            $migration->up($db);
            $stmt = $db->prepare("INSERT INTO migrations (migration, batch) VALUES (?, ?)");
            $stmt->execute([$name, $batch]);
            $this->success("Migration {$name} executed successfully");
        }
        $this->success('All migrations completed successfully.');
    }

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

    protected function getRunMigrations(PDO $db): array
    {
        return $db
            ->query("SELECT migration FROM migrations")
            ->fetchAll(PDO::FETCH_COLUMN);
    }

    protected function nextBatch(PDO $db): int
    {
        return (int) $db->query("SELECT MAX(batch) FROM migrations")->fetchColumn() + 1;
    }
}