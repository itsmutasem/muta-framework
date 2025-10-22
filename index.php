<?php

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

require "src/router.php";
$router = new Router();

$router->add("/", ['controller' => 'Home', 'action' => 'index']);
$router->add("/home/index", ['controller' => 'Home', 'action' => 'index']);
$router->add("/products", ['controller' => 'Products', 'action' => 'index']);

$params = $router->match($path);

$action = $params['action'];
$controller = $params['controller'];

require "src/controllers/$controller.php";
$controller_object = new $controller;
$controller_object->$action();