<?php

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = array_values(array_filter(explode('/', $path)));

if ($segments[0] === 'muta') {
    array_shift($segments);
}

$action = $segments[1];
$controller = $segments[0];

require "src/controllers/$controller.php";
$controller_object = new $controller;
$controller_object->$action();
