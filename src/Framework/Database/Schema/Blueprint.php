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
    public function addColumn(string $type, string $name, mixed ...$params): ColumnDefinition
    {
        $column = new ColumnDefinition($type, $name, $params);
        $this->columns[$name] = $column;
        return $column;
    }
}