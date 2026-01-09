<?php

class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        $dbPath = realpath(__DIR__ . '/../../database/tienda_online.db');

        $this->pdo = new PDO("sqlite:" . $dbPath);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance->pdo;
    }
}
