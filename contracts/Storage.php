<?php

namespace mimilun\contracts;

interface Storage
{
    function get(string $name): mixed;
    function set(string $name, mixed $value): bool;
    function slice(string $name): mixed; // Типа get, но еще и удаляет данный ключ
}