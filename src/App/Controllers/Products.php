<?php

namespace App\Controllers;

use App\Models\Product;
use Framework\Viewer;

class Products
{
    public function __construct(private Viewer $viewer)
    {

    }

    public function index()
    {
        $model = new Product;
        $products = $model->getData();

        echo $this->viewer->render("shared/header.php");
        echo $this->viewer->render("Products/index.php", ['products' => $products, 'title' => 'Products']);
    }

    public function show(string $id)
    {
        $viewer = new Viewer();
        echo $this->viewer->render("shared/header.php");
        echo $this->viewer->render("Products/show.php", ['id' => $id,  'title' => 'Product']);
    }

    public function showPage(string $title, string $id, string $page)
    {
        echo $title . " - " . $id . " - " . $page;
    }
}
