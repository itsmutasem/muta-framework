<?php

require 'src/controllers/products.php';
$controller = new Controller();

$action = $_GET['action'];
if ($action === 'index') {
    $controller->index();
} elseif ($action === 'show') {
    $controller->show();
} else {
    // Default action
    $controller->index();
}
