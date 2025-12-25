<?php

namespace Framework\Database\Schema\Grammars;

use Framework\Database\Schema\Blueprint;

class MySqlGrammar
{
    public function compileCreate(Blueprint $blueprint): string
    {
        $columns = [];
        foreach ($blueprint->columns as $column) {
            $columns[] = $this->compileCreate($column);
        }
        return sprintf(
            "CREATE TABLE %s (%s)",
            $blueprint->table,
            implode(', ', $columns)
        );
    }
}