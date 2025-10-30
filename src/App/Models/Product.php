<?php

namespace App\Models;

use App\Database;
use PDO;

class Product
{
    public function getData(): array
    {
        $database = new Database();
        $pdo = $database->getConnection();

        $stmt = $pdo->prepare("SELECT * FROM products");
        $stmt->execute();

        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $products;
    }
}
