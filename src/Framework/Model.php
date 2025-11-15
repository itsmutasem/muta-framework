<?php

namespace Framework;

use App\Database;
use PDO;

abstract class Model
{
    protected $table;

    private function getTable(): string
    {
        if ($this->table){
            return $this->table;
        }
        $parts = explode("\\", $this::class);
        return strtolower(array_pop($parts));
    }

    public function __construct(private Database $database)
    {

    }

    public function all(): array
    {
        $pdo = $this->database->getConnection();
        $sql = "SELECT * FROM {$this->getTable()}";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(string $id): array|bool
    {
        $conn = $this->database->getConnection();
        $sql = "SELECT * FROM {$this->getTable()} WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}