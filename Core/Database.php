<?php

namespace Core;

use PDO;
use PDOException;

class Database
{
    private static $instance = null;
    private $pdo;

    private function __construct()
    {
        $config = include(BASE_PATH . '/config/config.php'); // Load the configuration file
        $dbConfig = $config['db'];

        try {
            // $this->pdo = new PDO(
            //     "mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']}",
            //     $dbConfig['username'],
            //     $dbConfig['password']
            // );
            $this->pdo = new PDO(
                "mysql:host={$dbConfig['host']};port={$dbConfig['port']};dbname={$dbConfig['dbname']}",
                $dbConfig['username'],
                $dbConfig['password']
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance->pdo;
    }

    public static function query($sql, $params = [])
    {
        try {
            $pdo = self::getInstance();
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);

            // Return the result set for SELECT queries, or true/false for others
            if (preg_match('/^\s*(SELECT|SHOW|DESCRIBE|EXPLAIN)\s/i', $sql)) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return $stmt->rowCount(); // Number of affected rows for INSERT, UPDATE, DELETE
            }
        } catch (PDOException $e) {
            die("Query execution failed: " . $e->getMessage());
        }
    }
}
