<?php

declare(strict_types=1);

namespace Muhsin\VK\Models;

use Muhsin\VK\Core\Database;

class User
{
    private Database $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function get(int $id): false|array
    {
        return $this->db->query('SELECT * FROM Users WHERE id = :id', ['id' => $id])->findOrFail();
    }

    public function getByEmail(string $email): false|array
    {
        return $this->db->query('SELECT * FROM Users WHERE email = :email', ['email' => $email])->findOrFail();
    }

    public function create(string $email, string $password): string|array
    {
        $user = $this->db->query('SELECT * FROM Users WHERE email = :email', ['email' => $email])->find();

        if ($user) {
            return "User with this email already exists.";
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $id = $this->db->query(
            'INSERT INTO Users (email, password) VALUES (:email, :password)',
            ['email' => $email, 'password' => $hashed_password]
        )->insert();

        if ($id === false) {
            return "Failed to create user.";
        }

        return $this->get($id);
    }
}
