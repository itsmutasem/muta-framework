<?php

namespace App\Controllers;

class Products
{
    public function index()
    {
        require 'src/Models/Product.php';
        $model = new Model();
        $products = $model->getData();

        require 'views/products_index.php';
    }

    public function show()
    {
        require 'views/products_show.php';
    }
}
