<?php

declare(strict_types=1);

namespace Muhsin\VK\Core;

use PDO;

class Database
{
    private static ?self $instance = null;

    public PDO $connection;

    private function __construct(array $config, string $username = 'root', string $password = '')
    {
        $dsn = 'mysql:' . http_build_query($config, '', ';');

        $this->connection = new PDO($dsn, $username, $password, [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }

    public static function init(array $config, string $username = 'root', string $password = ''): void
    {
        self::$instance = new self($config, $username, $password);
    }

    public static function getInstance(): false|self
    {
        if (self::$instance === null) {
            return false;
        }

        return self::$instance;
    }

    public function query(string $query, array $params = []): Query
    {
        $statement = $this->connection->prepare($query);

        foreach ($params as $key => $value) {
            $statement->bindValue($key, $value);
        }

        return new Query($this->connection, $statement);
    }
}
