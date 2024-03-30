<?php

declare(strict_types=1);

namespace Muhsin\VK\Core;

use Muhsin\VK\Models\User;

class Auth
{
    private static self $instance;

    private JWTManager $jwt;
    private User $user_model;

    private function __construct(JWTManager $jwt, User $user_model)
    {
        $this->jwt = $jwt;
        $this->user_model = $user_model;
    }

    public static function init(JWTManager $jwt, User $user_model): void
    {
        self::$instance = new self($jwt, $user_model);
    }

    public static function getInstance(): self
    {
        return self::$instance;
    }

    public function attempt(string $email, string $password): string
    {
        $user = $this->user_model->getByEmail($email);

        if ($user === false) {
            echo json_encode(['error' => 'User not found.']);

            exit;
        }

        if (!password_verify($password, $user['password'])) {
            echo json_encode(['error' => 'Invalid password.']);

            exit;
        }

        return $this->jwt->encode([
            'user_id' => $user['id'],
        ]);
    }

    public function check(string $token): bool
    {
        $decoded = $this->jwt->decode($token);

        $user = $this->user_model->get($decoded->user_id);

        return !($user === false);
    }
}
