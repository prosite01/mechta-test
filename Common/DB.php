<?php

namespace Common;

use PDO;
use PDOException;

class DB
{
    private PDO $pdo;

    public function __construct()
    {
        $dbName = getenv('DB_NAME');
        $dbUser = getenv('DB_USER');
        $dbPassword = getenv('DB_PASSWORD');
        $dbHost = getenv('DB_HOST');

        try {
            $this->pdo = new PDO("mysql:dbname=$dbName;host=$dbHost", $dbUser, $dbPassword);
        } catch (PDOException $e) {
            die('Ошибка подключения к базе данных: ' . $e->getMessage());
        }
    }

    /**
     * @param string $sql
     * @param array $params
     * @return array
     */
    public function query(string $sql, array $params = []): array
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}