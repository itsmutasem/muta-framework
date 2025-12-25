<?php

namespace Framework\Database\Schema\Grammars;

use Framework\Database\Schema\Blueprint;
use Framework\Database\Schema\ColumnDefinition;

class MySqlGrammar
{
    public function compileCreate(Blueprint $blueprint): string
    {
        $columns = [];
        foreach ($blueprint->columns as $column) {
            $columns[] = $this->compileColumn($column);
        }
        return sprintf(
            "CREATE TABLE %s (%s)",
            $blueprint->table,
            implode(', ', $columns)
        );
    }

    public function compileColumn(ColumnDefinition $column): string
    {
        $sql = "`{$column->name}` ";
        match ($column->type) {
            'uuid' => $sql .= 'BINARY(16)',
            'string' => $sql .= 'VARCHAR(' . ($column->params[0] ?? 255) . ')',
            'timestamp' => $sql .= 'TIMESTAMP'
        };

        if ($column->nullable) {
            $sql .= ' NULL';
        } else {
            $sql .= ' NOT NULL';
        }

        if ($column->unique) {
            $sql .= ' UNIQUE';
        }

        if ($column->primary) {
            $sql .= ' PRIMARY KEY';
        }

        return $sql;
    }
}