<?php

namespace mimilun\services;

// class is SingleTon

use mimilun\contracts\DataBase;

class Db implements DataBase
{
    protected \PDO $pdo;
    private static ?Db $instance = null;

    private function __construct()
    {
        $dbOption = (include __DIR__ . '/../settings/db.php');
        $dns = "mysql:host={$dbOption['host']}; dbname={$dbOption['dbname']}";
        $this->pdo = new \PDO($dns, $dbOption['user'], $dbOption['password']);
        $this->pdo->exec('SET NAMES UTF8');
    }

    public function getLastId(): int
    {
        return $this->pdo->lastInsertId();
    }

    public static function getInstance(): self
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function query(string $query, array $params = [], string $className = 'stdClass'): ?array
    {
        $sth = $this->pdo->prepare($query);
        $res = $sth->execute($params);

        if ($res === false) {
            return null;
        }

        return $sth->fetchAll(\PDO::FETCH_CLASS, $className);
    }
}