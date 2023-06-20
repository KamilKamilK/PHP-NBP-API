<?php

namespace Service;

use Dotenv\Dotenv;

class Connection
{
    private static ?Connection $instance = null;

    private \mysqli|false $conn;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable('./../');
        $dotenv->load();

        $this->conn = mysqli_connect($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME']);

        if (!$this->conn) {
            exit('Connection failed: ' . mysqli_connect_error() . PHP_EOL);
        }
    }
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getConnection(): bool|\mysqli
    {
        return $this->conn;
    }
}