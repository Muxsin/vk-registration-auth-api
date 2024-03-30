<?php

declare(strict_types=1);

namespace Muhsin\VK\Controllers;

use Muhsin\VK\Core\Auth;
use Muhsin\VK\Core\PasswordStrength;
use Muhsin\VK\Models\User;

class UserController
{
    private User $user_model;
    private Auth $auth;

    public function __construct(User $user_model, Auth $auth)
    {
        $this->user_model = $user_model;
        $this->auth = $auth;
    }

    public function authorize(): void
    {
        if (
            !isset($_POST['email']) ||
            !isset($_POST['password']) ||
            empty(trim($_POST['email'])) ||
            empty(trim($_POST['password']))
        ) {
            http_response_code(422);

            echo json_encode(['error' => 'Please fill all the required fields & None of the fields should be empty.']);

            exit;
        }

        echo json_encode($this->auth->attempt($_POST['email'], $_POST['password']));
    }

    public function register(): void
    {
        if (
            !isset($_POST['email']) ||
            !isset($_POST['password']) ||
            empty(trim($_POST['email'])) ||
            empty(trim($_POST['password']))
        ) {
            http_response_code(422);

            echo json_encode(['error' => 'Please fill all the required fields & None of the fields should be empty.']);

            exit;
        }

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['error' => 'Invalid email address.']);

            exit;
        }

        $strength = $this->strongPassword($_POST['password']);

        if ($strength->isWeak()) {
            echo json_encode(['error' => 'weak_password']);

            exit;
        }

        $result = $this->user_model->create($_POST['email'], $_POST['password']);

        if (is_string($result)) {
            echo json_encode(['error' => $result]);

            return;
        }

        echo json_encode([
            'user_id' => $result['id'],
            'password_check_status' => $strength->toString(),
        ]);
    }

    public function feed(): void
    {
        $header = apache_request_headers();

        if (isset($header['Authorization'])) {
            $token = $header['Authorization'];
            $decode = $this->auth->check($token);

            if ($decode) {
                http_response_code(200);
                exit;
            }
        }

        http_response_code(401);
    }

    private function strongPassword(string $password): PasswordStrength
    {
        $points = 0;
        $patterns = [
            "#[A-Z]+#",
            "#[a-z]+#",
            "#[0-9]+#",
            '#[^\w]#',
            '#.{8,}#',
            '#.{12,}#',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $password)) {
                $points++;
            }
        }

        if ($points > 4) {
            return PasswordStrength::PERFECT;
        } elseif ($points > 2) {
            return PasswordStrength::GOOD;
        }

        return PasswordStrength::WEAK;
    }
}
