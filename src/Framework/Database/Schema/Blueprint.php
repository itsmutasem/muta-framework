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
}