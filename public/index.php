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
$db_config = $config['database'];

Database::init(
    [
        'host' => $db_config['host'],
        'port' => $db_config['port'],
        'dbname' => $db_config['database'],
        'charset' => $db_config['charset'],
    ],
    $db_config['username'],
    $db_config['password']
);
Auth::init(new JWTManager('HS256', $secret), new User(Database::getInstance()));

$router = new Router(require __DIR__ . '/../routes.php');
$router->dispatch($uri, $method);
