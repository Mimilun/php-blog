<?php

namespace mimilun\contracts;

interface DataBase
{
    function query(string $query): ?array;
}