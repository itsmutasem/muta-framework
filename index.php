<?php

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

spl_autoload_register(function ($class_name) {
    require "src/" . str_replace("\\", "/", $class_name) . ".php";
});
$router = new Framework\Router;

$router->add("/product/{slug:[\w-]+}", ['controller' => 'Products', 'action' => 'show']);
$router->add("/{controller}/{id:\d+}/{action}");
$router->add("/", ['controller' => 'Home', 'action' => 'index']);
$router->add("/home/index", ['controller' => 'home', 'action' => 'index']);
$router->add("/products", ['controller' => 'Products', 'action' => 'index']);
$router->add("/{controller}/{action}");

$params = $router->match($path);

if ($params === false) {
    http_response_code(404);
    echo "404 | Not Found";
    exit;
}

$action = $params['action'];
$controller = "App\Controllers\\" . ucwords($params['controller']);

$controller_object = new $controller;
$controller_object->$action();

$dispatcher = new Framework\Dispatcher($router);