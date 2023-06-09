<?php

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '../..');
$dotenv->load();


$conn = mysqli_connect($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME']);
define("CONNECTION", $conn);
if (!$conn) {
    exit('Connection failed: ' . mysqli_connect_error() . PHP_EOL);
}

echo 'Successful database connection!' . PHP_EOL;