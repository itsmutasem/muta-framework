<?php

define('BASE_PATH', __DIR__);

require  __DIR__ . '/vendor/autoload.php';

use Framework\Console\Application;

$app = new Application();
$app->run($argv);
