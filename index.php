<?php

declare(strict_types=1);

set_exception_handler(function (Throwable $exception) {
    $show_errors = true;
    if ($show_errors) {
        ini_set("display_errors", "1");
    } else {
        ini_set("display_errors", "0");
        ini_set("log_errors", "1");
        require "views/500.php";
    }
    throw $exception;
});

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($path === false) {
    throw new UnexpectedValueException("Invalid URL format");
}

spl_autoload_register(function ($class_name) {
    require "src/" . str_replace("\\", "/", $class_name) . ".php";
});
$router = new Framework\Router;

$router->add("/admin/{controller}/{action}", ['namespace' => "Admin"]);
$router->add("/{title}/{id:\d+}/{page:\d+}", ['controller' => 'products', 'action' => 'showPage']);
$router->add("/product/{slug:[\w-]+}", ['controller' => 'Products', 'action' => 'show']);
$router->add("/{controller}/{id:\d+}/{action}");
$router->add("/", ['controller' => 'Home', 'action' => 'index']);
$router->add("/home/index", ['controller' => 'home', 'action' => 'index']);
$router->add("/products", ['controller' => 'Products', 'action' => 'index']);
$router->add("/{controller}/{action}");

$container = new Framework\Container;
$container->set(App\Database::class, function () {
    return new App\Database("localhost", "product_db", "root", "");
});

$dispatcher = new Framework\Dispatcher($router, $container);
$dispatcher->handle($path);