<?php

class Router
{
    private $routes = [];

    public function add(string $path, array $params): void
    {
        $this->routes[] = [
            'path' => $path,
            'params' => $params
        ];
    }
}