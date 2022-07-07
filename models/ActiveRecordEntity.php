<?php
declare(strict_types=1);

namespace mimilun\models;

use mimilun\services\Db;

abstract class ActiveRecordEntity
{
    protected int $id;

    public static function findAll(): array
    {
        $db = Db::getInstance();

        return $db->query('SELECT * FROM' . ' ' . static::getTableName(), [], static::class);
    }

    public static function getById(int $id): ?static
    {
        $db = Db::getInstance();

        try {
            $entities = $db->query('SELECT * FROM' . ' ' . static::getTableName() . ' WHERE id = :id', [':id' => $id],
                static::class);
        } catch (\Exception $exception) {
            $_SESSION['error'][] = 'Не удалось получить элемент id = ' . $id . ', code: ' . $exception->getCode();
        }

        return $entities[0] ?? null;
    }

    public function __set(string $propertyName, $value): void
    {
        $thisProperty = $this->propertyToCamelCaseName($propertyName);
        $this->$thisProperty = $value;
    }

    protected function propertyToCamelCaseName(string $property): string
    {
        $camelCaseName = lcfirst(ucwords($property, '_'));

        return str_replace('_', '', $camelCaseName);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public static function getOneByColumn($column, $find): ?static
    {
        $db = Db::getInstance();

        $query = 'SELECT * FROM' . ' ' . static::getTableName() . ' WHERE ' . $column . ' = ' . ':find';
        return ($db->query($query, [':find' => $find], static::class)[0]) ?? null;
    }

    public function save(): void
    {
        $arrPropertyDb = $this->mapPropertyToDbFormat();

        if ($arrPropertyDb['id'] === null) {
            $this->insert($arrPropertyDb);
        } else {
            $this->update($arrPropertyDb);
        }
    }

    protected function update(array $arrPropertyDb): void
    {
        $db = Db::getInstance();
        $setParam = [];
        $setValue = [];

        foreach ($arrPropertyDb as $column => $value) {
            if ($value !== null) {
                $setParam[] = $column . ' = :' . $column;
                $setValue[':' . $column] = $value;
            }
        }

        $query = 'UPDATE ' . static::getTableName() . ' SET ' . implode(', ', $setParam) . ' WHERE id = :id';
        $db->query($query, $setValue, static::class);
    }

    protected function insert(array $arrPropertyDb): void
    {
        $db = Db::getInstance();
        $setParam = [];
        $setValue = [];

        foreach ($arrPropertyDb as $column => $value) {
            if ($value !== null) {
                $setParam[] = $column . ' = :' . $column;
                $setValue[':' . $column] = $value;
            }
        }

        $query = 'INSERT INTO' . ' ' . static::getTableName() . ' SET ' . implode(', ', $setParam);
        $db->query($query, $setValue, static::class);
    }

    public function delete(int $id): bool
    {
        $query = 'DELETE FROM' . ' ' . static::getTableName() . ' WHERE id = :id';
        $db = Db::getInstance();

        try {
            $db->query($query, [':id' => $id]);
        } catch (\Exception $exception) {
            $_SESSION['error'][] = 'Не удалось удалить элемент id = ' . $id . ', code: ' . $exception->getCode();

            return false;
        }

        return true;
    }

    protected function mapPropertyToDbFormat(): array
    {
        $reflection = new \ReflectionObject($this);
        $arrProperties = $reflection->getProperties();

        $mappedProperties = [];

        foreach ($arrProperties as $property) {
            $propertyName = $property->getName();
            $propertyUnderScope = $this->camelCaseToUnderScore($propertyName);
            $mappedProperties[$propertyUnderScope] = $this->$propertyName ?? null;
        }

        return $mappedProperties;
    }

    protected function camelCaseToUnderScore(string $str): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $str));
    }

    abstract protected static function getTableName();
}