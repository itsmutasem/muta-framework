<?php

namespace Framework;

use App\Database;
use PDO;

abstract class Model
{
    protected $table;

    protected array $errors = [];
    protected function validate(array $data): void{}
    protected function addError(string $field, string $message): void
    {
        $this->errors[$field] = $message;
    }
    public function getErrors(): array
    {
        return $this->errors;
    }

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

    public function create(array $data): bool
    {
        $this->validate($data);
        if (!empty($this->errors)){
            return false;
        }
        $columns = implode(", ", array_keys($data));
        $values = implode(", ", array_fill(0, count($data), "?"));
        $sql = "INSERT INTO {$this->getTable()} ($columns)
                VALUES ($values)";
        $conn = $this->database->getConnection();
        $stmt = $conn->prepare($sql);
        $i = 1;
        foreach ($data as $value){
            $type = match (gettype($value)){
                "integer" => PDO::PARAM_INT,
                "boolean" => PDO::PARAM_BOOL,
                "NULL" => PDO::PARAM_NULL,
                default => PDO::PARAM_STR
            };
            $stmt->bindValue($i++, $value, $type);
        }
        return $stmt->execute();
    }
}