<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Product;
use Framework\Controller;
use Framework\Exceptions\PageNotFoundException;
use Framework\Response;

class Products extends Controller
{
    public function __construct(private Product $model)
    {

    }

    public function index(): Response
    {
        $products = $this->model->all();
        return $this->view("Products/index", ['products' => $products]);
    }

    public function getProduct(string $id): array
    {
        $product = $this->model->find($id);
        if ($product === false){
            throw new PageNotFoundException("Product not found");
        }
        return $product;
    }


    public function show(string $id): Response
    {
        $product = $this->getProduct($id);
        return $this->view("Products/show", ['product' => $product]);
    }

    public function showPage(string $title, string $id, string $page)
    {
        echo $title . " - " . $id . " - " . $page;
    }

    public function create(): Response
    {
        return $this->view("Products/create");
    }

    public function store(): Response
    {
        $data = [
            'name' => $this->request->post['name'],
            'description' => $this->request->post['description'],
        ];
        if ($this->model->create($data)) {
            return $this->redirect("/products/{$this->model->getInsertID()}/show");
        } else {
            return $this->view("Products/create", ['errors' => $this->model->getErrors(),
                'product' => $data]);
        }

    }

    public function edit(string $id): Response
    {
        $product = $this->getProduct($id);
        return $this->view("Products/edit", ['product' => $product]);
    }

    public function update(string $id): Response
    {
        $product = $this->getProduct($id);
        $product['name'] = $this->request->post['name'];
        $product['description'] = $this->request->post['description'];
        if ($this->model->update($id, $product)) {
            return $this->redirect("/products/{$id}/show");
        } else {
            return $this->view("Products/edit", ['errors' => $this->model->getErrors(),
                'product' => $product]);
        }
    }

    public function delete(string $id): Response
    {
        $product = $this->getProduct($id);
        return $this->view("Products/delete", ['product' => $product]);
    }

    public function destroy(string $id)
    {
        $product = $this->getProduct($id);
            $this->model->delete($id);
            return $this->redirect("/products");
    }
}
