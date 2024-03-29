<?php

use Muhsin\VK\Core\Database;
use Muhsin\VK\Core\Router;

require __DIR__ . '/../vendor/autoload.php';

header('Content-Type: application/json');

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_SERVER['REQUEST_METHOD'];

$config = require __DIR__ . '/../config.php';

Database::init($config['database'], 'root', 'secret');

$router = new Router(require __DIR__ . '/../routes.php');
$router->dispatch($uri, $method);
