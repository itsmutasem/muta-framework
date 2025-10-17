<?php

class Model
{
    public function getData(): array
    {
        $dsn = 'mysql:host=localhost;dbname=product_db;charset=utf8;port=3306';

        $pdo = new PDO($dsn, 'root', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        $stmt = $pdo->prepare("SELECT * FROM products");
        $stmt->execute();

        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $products;
    }
}
