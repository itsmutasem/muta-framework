<?php

namespace Framework\Database\Schema;

class ColumnDefinition
{
    public string $type;
    public string $name;
    public array $params;
    public bool $nullable = false;
    public bool $unique = false;
    public bool $primary = false;

    public function __construct(string $type, string $name, array $params = [])
    {
        $this->type = $type;
        $this->name = $name;
        $this->params = $params;
    }

    public function nullable(): self
    {
        $this->nullable = true;
        return $this;
    }

    public function unique(): self
    {
        $this->unique = true;
        return $this;
    }

    public function primary(): self
    {
        $this->primary = true;
        return $this;
    }
}