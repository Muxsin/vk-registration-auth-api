<?php

declare(strict_types=1);

use Muhsin\VK\Controllers\UserController;
use Muhsin\VK\Core\Database;
use Muhsin\VK\Core\Route;
use Muhsin\VK\Models\User;

$database = Database::getInstance();
$user_model = new User($database);

$user_controller = new UserController($user_model);

return [
    Route::post('/api/register', [$user_controller, 'register']),
    Route::post('/api/authorize', [$user_controller, 'login']),
];
