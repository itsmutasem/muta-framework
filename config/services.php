<?php

$container = new Framework\Container;
$container->set(App\Database::class, function () {
    return new App\Database($_ENV["DB_HOST"], $_ENV["DB_NAME"], $_ENV["DB_USER"], $_ENV["DB_PASSWORD"]);
});
$container->set(Framework\Security\CsrfToken::class, function () {
    return new Framework\Security\CsrfToken();
});
$container->set(Framework\TemplateViewerInterface::class, function () use ($container) {
    return new Framework\MVCTemplateViewer($container->get(Framework\Security\CsrfToken::class));
});
return $container;
