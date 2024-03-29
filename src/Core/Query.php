<?php

declare(strict_types=1);

namespace Muhsin\VK\Core;

use PDO;
use PDOStatement;

class Query
{
    private PDO $connection;
    private PDOStatement $statement;
    private bool $executed = false;

    public function __construct(PDO $connection, PDOStatement $statement)
    {
        $this->connection = $connection;
        $this->statement = $statement;
    }

    public function execute(): void
    {
        if ($this->executed) {
            return;
        }

        $this->statement->execute();
        $this->executed = true;
    }

    public function insert(): false|int
    {
        if (!$this->executed) {
            $this->execute();
        }

        $id = $this->connection->lastInsertId();

        if ($id === false) {
            return false;
        }

        return (int)$id;
    }

    public function find(): false|array
    {
        if (!$this->executed) {
            $this->execute();
        }

        return $this->statement->fetch();
    }

    public function findAll(): array
    {
        if (!$this->executed) {
            $this->execute();
        }

        return $this->statement->fetchAll();
    }

    public function findOrFail(): false|array
    {
        $result = $this->find();

        if (!$result) {
            return false;
        }

        return $result;
    }
}
