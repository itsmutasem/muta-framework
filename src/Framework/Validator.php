<?php

namespace Framework;

class Validator
{
    protected  array $data = [];
    protected array $rules;
    protected array $errors = [];
    protected array $validated = [];

    public function __construct(array $data, array $rules)
    {
        $this->data = $data;
        $this->rules = $rules;
    }
}