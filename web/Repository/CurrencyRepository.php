<?php

namespace Repository;

use PDO;
use Service\Connection;

class CurrencyRepository
{
    public function getAll(): array
    {
        $conn = Connection::getInstance()->getConnection();

        $sql = "SELECT *
                FROM currency
                ORDER BY currency_code";

        $stmt = $conn->query($sql);
        return $stmt->fetch_all(PDO::FETCH_ASSOC);
    }

    public function getAllConversions(): array
    {
        $conn = Connection::getInstance()->getConnection();

        $sql = "SELECT *
                FROM conversions
                ORDER BY created_at DESC";

        $stmt = $conn->query($sql);
        return $stmt->fetch_all(PDO::FETCH_ASSOC);
    }
}