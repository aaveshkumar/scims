<?php

class Database
{
    private static $instance = null;
    private $pdo;
    private $config;

    private function __construct()
    {
        $this->config = Config::all('database');
        $this->connect();
    }

    private function connect()
    {
        $host = $this->config['host'];
        $port = $this->config['port'];
        $database = $this->config['database'];
        $username = $this->config['username'];
        $password = $this->config['password'];
        $charset = $this->config['charset'];

        $dsn = "mysql:host={$host};port={$port};dbname={$database};charset={$charset}";

        try {
            $this->pdo = new PDO($dsn, $username, $password, $this->config['options']);
        } catch (PDOException $e) {
            throw new Exception("Database connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getPdo()
    {
        return $this->pdo;
    }

    public function query($sql, $params = [])
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            throw new Exception("Query failed: " . $e->getMessage() . " | SQL: " . $sql);
        }
    }

    public function fetchAll($sql, $params = [])
    {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }

    public function fetchOne($sql, $params = [])
    {
        $stmt = $this->query($sql, $params);
        return $stmt->fetch();
    }

    public function execute($sql, $params = [])
    {
        $stmt = $this->query($sql, $params);
        return $stmt->rowCount();
    }

    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

    public function beginTransaction()
    {
        return $this->pdo->beginTransaction();
    }

    public function commit()
    {
        return $this->pdo->commit();
    }

    public function rollback()
    {
        return $this->pdo->rollBack();
    }

    public function inTransaction()
    {
        return $this->pdo->inTransaction();
    }
}
