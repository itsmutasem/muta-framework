<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Product;
use Framework\Exceptions\PageNotFoundException;
use Framework\Viewer;

class Products
{
    public function __construct(private Viewer $viewer, private Product $model)
    {

    }

    public function index()
    {
        $products = $this->model->all();

        echo $this->viewer->render("shared/header", ['title' => 'Products']);
        echo $this->viewer->render("Products/index", ['products' => $products]);
    }

    public function getProduct(string $id): array
    {
        $product = $this->model->find($id);
        if ($product === false){
            throw new PageNotFoundException("Product not found");
        }
        return $product;
    }


    public function show(string $id)
    {
        $product = $this->getProduct($id);
        echo $this->viewer->render("shared/header", ['title' => 'Product']);
        echo $this->viewer->render("Products/show", ['product' => $product]);
    }

    public function showPage(string $title, string $id, string $page)
    {
        echo $title . " - " . $id . " - " . $page;
    }

    public function create()
    {
        echo $this->viewer->render("shared/header", ['title' => 'Create Product']);;
        echo $this->viewer->render("Products/create");
    }

    public function store()
    {
        $data = [
            'name' => $_POST['name'],
            'description' => $_POST['description'],
        ];
        if ($this->model->create($data)) {
            header("Location: /products/{$this->model->getInsertID()}/show");
            exit();
        } else {
            echo $this->viewer->render("shared/header", ['title' => 'Create Product']);;
            echo $this->viewer->render("Products/create", ['errors' => $this->model->getErrors(),
                'product' => $data]);
        }

    }

    public function edit(string $id)
    {
        $product = $this->getProduct($id);
        echo $this->viewer->render("shared/header", ['title' => 'Edit Product']);
        echo $this->viewer->render("Products/edit", ['product' => $product]);
    }

    public function update(string $id)
    {
        $product = $this->getProduct($id);
        $product['name'] = $_POST['name'];
        $product['description'] = $_POST['description'];
        if ($this->model->update($id, $product)) {
            header("Location: /products/{$id}/show");
            exit();
        } else {
            echo $this->viewer->render("shared/header", ['title' => 'Edit Product']);;
            echo $this->viewer->render("Products/edit", ['errors' => $this->model->getErrors(),
                'product' => $product]);
        }
    }

    public function delete(string $id)
    {
        $product = $this->getProduct($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->delete($id);
            header("Location: /products");
            exit();
        }
        echo $this->viewer->render("shared/header", ['title' => 'Delete Product']);
        echo $this->viewer->render("Products/delete", ['product' => $product]);;
    }
}
