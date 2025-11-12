<?php

namespace Framework;

use ReflectionMethod;
use Framework\Exceptions\PageNotFoundException;

class Dispatcher
{
    public function __construct(private Router $router, private Container $container)
    {

    }

    public function handle(string $path)
    {
        $params = $this->router->match($path);

        if ($params === false) {
            http_response_code(404);
            throw new PageNotFoundException("404 | Not Found for '$path'");
        }

        $action = $this->getActionName($params);
        $controller = $this->getControllerName($params);
        $controller_object = $this->container->get($controller);
        $args = $this->getActionArguments($controller, $action, $params);
        $controller_object->$action(...$args);
    }

    public function getActionArguments(string $controller, string $action, array $params): array
    {
        $args = [];
        $method = new ReflectionMethod($controller, $action);
        foreach ($method->getParameters() as $parameter) {
            $name = $parameter->getName();
            $args[$name] = $params[$name];
        }
        return $args;
    }

    public function getControllerName(array $params): string
    {
        $controller = $params['controller'];
        $controller = str_replace("-", "", ucwords(strtolower($controller), "-"));
        $namespace = 'App\Controllers';
        if (array_key_exists("namespace", $params)) {
            $namespace .= "\\" . $params['namespace'];
        }
        return $namespace . "\\" . $controller;
    }

    public function getActionName(array $params): string
    {
        $action = $params['action'];
        $action = lcfirst(str_replace("-", "", ucwords(strtolower($action), "-")));
        return $action;
    }
}
