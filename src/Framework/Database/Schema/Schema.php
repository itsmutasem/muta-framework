<?php

namespace Framework\Database\Schema;

use Framework\Database\Schema\Grammars\MySqlGrammar;
use PDO;

class Schema
{
    public static function create(string $table, callable $callback, PDO $db): void
    {
        $blueprint = new Blueprint($table);
        $callback($blueprint);
        $grammar = new MySqlGrammar();
        $sql = $grammar->compileCreate($blueprint);
        $db->exec($sql);
    }
}