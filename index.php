<?php

declare(strict_types=1);

spl_autoload_register(function ($class_name) {
    require "src/" . str_replace("\\", "/", $class_name) . ".php";
});

set_error_handler("Framework\ErrorHandler::ErrorHandler");
set_exception_handler(function (Throwable $exception) {
    if ($exception instanceof \Framework\Exceptions\PageNotFoundException) {
        http_response_code(404);
        $template = "404";
    } else {
        http_response_code(500);
        $error_file = $exception->getFile();
        $error_line = $exception->getLine();

        // Get code snippet (5 lines before and after)
        $lines = file($error_file);
        $start = max($error_line - 11, 0);
        $length = 21;
        $snippet = array_slice($lines, $start, $length, true);

        // Format snippet with line numbers and highlighting
        $formatted_snippet = '';
        foreach ($snippet as $i => $line) {
            $line_num = $i + 1;
            $is_error_line = $line_num === $error_line;
            $formatted_snippet .= sprintf(
                '<div class="flex %s">
                    <span class="w-12 text-right pr-4 %s">%d</span>
                    <pre class="flex-1 whitespace-pre-wrap %s">%s</pre>
                 </div>',
                $is_error_line ? 'bg-red-900/40' : 'bg-transparent',
                $is_error_line ? 'text-red-400 font-bold' : 'text-gray-500',
                $line_num,
                $is_error_line ? 'text-red-200 font-semibold' : 'text-gray-300',
                htmlspecialchars($line)
            );
        }

        $error_data = [
            'error_name' => get_class($exception),
            'error_message' => $exception->getMessage(),
            'error_file' => $error_file,
            'error_line' => $error_line,
            'error_trace' => $exception->getTraceAsString(),
            'error_snippet' => $formatted_snippet,
        ];
        $template = "500";
    }
    $show_errors = false;
    if ($show_errors) {
        ini_set("display_errors", "1");
    } else {
        ini_set("display_errors", "0");
        ini_set("log_errors", "1");
        require "views/Errors/$template.php";
    }
    throw $exception;
});

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($path === false) {
    throw new UnexpectedValueException("Invalid URL format");
}


$router = new Framework\Roouter;

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