<?php

namespace Framework\Database\Schema;

use Framework\Database\Schema\Grammars\MySqlGrammar;
use PDO;

class Schema
{
    public static function create(string $table, callable $callback): void
    {
        $blueprint = new Blueprint($table);
        $callback($blueprint);
        $grammar = new MySqlGrammar();
        $sql = $grammar->compileCreate($blueprint);
        app(PDO::class)->exec($sql);
    }
}