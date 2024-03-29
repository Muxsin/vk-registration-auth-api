<?php

declare(strict_types=1);

namespace Muhsin\VK\Controllers;

use Muhsin\VK\Models\User;

class UserController
{
    private User $user_model;

    public function __construct(User $user_model)
    {
        $this->user_model = $user_model;
    }

    public function login()
    {
        //
    }

    public function register()
    {
        //
    }
}
