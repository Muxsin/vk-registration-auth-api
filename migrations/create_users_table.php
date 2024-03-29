<?php

use Muhsin\VK\Core\Database;

return Database::getInstance()->query(
    <<<SQL
CREATE TABLE Users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
)
SQL
);
