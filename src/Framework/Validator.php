<?php

namespace Framework;

use Framework\Security\Sanitizer;

class Validator
{
    protected  array $data;
    protected array $rules;
    protected array $errors = [];
    protected array $validated = [];

    public function __construct(array $data, array $rules)
    {
        $this->data = $data;
        $this->rules = $rules;
    }

    public function passes(): bool
    {
        $this->errors = [];
        $this->validated = [];
        foreach ($this->rules as $field => $rules) {
            $value = $this->data[$field] ?? null;
            $rules = is_array($rules) ? $rules : explode("|", $rules);
            foreach ($rules as $rule) {
                [$name, $param] = array_pad(explode(":", $rule, 2), 2, null);
                $method = 'validate' . str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $name)));
                if (!method_exists($this, $method)) {
                    throw new \Exception("Validation rule {$name} is not supported.");
                }
                $ok = $this->{$method}($field, $value, $param);
                if (!$ok) break;
            }
            if (!isset($this->errors[$field])) {
                $this->validated[$field] = $this->sanitize($value);
            }
        }
        return empty($this->errors);
    }

    public function fails(): bool
    {
        return !$this->passes();
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function validated(): array
    {
        return $this->validated;
    }

    public function sanitize($value)
    {
        return Sanitizer::clean($value);
    }

    protected function validateRequired($field, $value, $param): bool
    {
        if ($value === null || $value === '') {
            $this->errors[$field][] = "The {$field} field is required.";
            return false;
        }
        return true;
    }
}