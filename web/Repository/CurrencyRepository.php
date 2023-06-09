<?php

namespace Repository;

use PDO;

class CurrencyRepository
{
    public function getAll(): array
    {
        global $conn;
        $sql = "SELECT *
                FROM currency
                ORDER BY currency_code";

        $stmt = $conn->query($sql);
        return $stmt->fetch_all(PDO::FETCH_ASSOC);
    }

    public function getAllConversions(): array
    {
        global $conn;
        $sql = "SELECT *
                FROM conversions
                ORDER BY created_at DESC";

        $stmt = $conn->query($sql);
        return $stmt->fetch_all(PDO::FETCH_ASSOC);
    }
}