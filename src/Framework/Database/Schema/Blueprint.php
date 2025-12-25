<?php

namespace Framework\Database\Schema;
class Blueprint
{
    public string $table;
    public array $columns = [];
    public array $commands = [];

    public function __construct(string $table)
    {
        $this->table = $table;
    }

    public function uuid(string $name)
    {
        return $this->addColumn('uuid', $name);
    }

    public function string(string $name, int $length = 255): ColumnDefinition
    {
        return $this->addColumn('string', $name, $length);
    }

    public function addColumn(string $type, string $name, mixed ...$params): ColumnDefinition
    {
        $column = new ColumnDefinition($type, $name, $params);
        $this->columns[$name] = $column;
        return $column;
    }
}