<?php

namespace Framework;

use App\Database;
use PDO;

abstract class Model
{
    public function __construct(private Database $database)
    {

    }

    public function all(): array
    {
        $pdo = $this->database->getConnection();

        $stmt = $pdo->query("SELECT * FROM products");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(string $id): array|bool
    {
        $conn = $this->database->getConnection();
        $sql = "SELECT * FROM products WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}