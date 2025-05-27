<?php
require __DIR__ . '/../vendor/autoload.php';
use Slim\Factory\AppFactory;
$app = AppFactory::create();
require __DIR__ . '/../src/loader.php';
$app->run();
?>