<?php

class Model
{
    public function getData(): array
    {
        $dsn = 'mysql:host=localhost;dbname=project_db;charset=utf8,port=3306';

        $pdo = new PDO($dsn, 'mutasem', 'muta', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        $stmt = $pdo->prepare("SELECT * FROM products");

        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $products;
    }
}
