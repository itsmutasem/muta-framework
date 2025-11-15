<?php

namespace Framework;

use App\Database;
use PDO;

abstract class Model
{
    protected $table;

    public function __construct(private Database $database)
    {

    }

    public function all(): array
    {
        $pdo = $this->database->getConnection();
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(string $id): array|bool
    {
        $conn = $this->database->getConnection();
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}