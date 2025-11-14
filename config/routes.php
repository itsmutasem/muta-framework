<?php

$router = new Framework\Router;

$router->add("/admin/{controller}/{action}", ['namespace' => "Admin"]);
$router->add("/{title}/{id:\d+}/{page:\d+}", ['controller' => 'products', 'action' => 'showPage']);
$router->add("/product/{slug:[\w-]+}", ['controller' => 'Products', 'action' => 'show']);
$router->add("/{controller}/{id:\d+}/{action}");
$router->add("/", ['controller' => 'Home', 'action' => 'index']);
$router->add("/home/index", ['controller' => 'home', 'action' => 'index']);
$router->add("/products", ['controller' => 'Products', 'action' => 'index']);
$router->add("/{controller}/{action}");

return $router;
