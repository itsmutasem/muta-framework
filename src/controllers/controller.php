<?php

class Controller
{
    public function index()
    {
        require 'src/models/model.php';
        $model = new Model();
        $products = $model->getData();

        require 'view.php';
    }
}
