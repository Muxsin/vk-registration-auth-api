<?php

use Muhsin\VK\Core\Auth;
use Muhsin\VK\Core\Database;
use Muhsin\VK\Core\JWTManager;
use Muhsin\VK\Core\Router;
use Muhsin\VK\Models\User;

require __DIR__ . '/../vendor/autoload.php';

header('Content-Type: application/json');

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_SERVER['REQUEST_METHOD'];

$config = require __DIR__ . '/../config.php';
$secret = $config['secret_key'];

Database::init($config['database'], 'root', 'secret');
Auth::init(new JWTManager('HS256', $secret), new User(Database::getInstance()));

$router = new Router(require __DIR__ . '/../routes.php');
$router->dispatch($uri, $method);
