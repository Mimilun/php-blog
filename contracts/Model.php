<?php

namespace mimilun\contracts;

interface Model
{
    static function findAll(): array;

    static function getById(int $id): ?static;

    public function getId(): int;
}