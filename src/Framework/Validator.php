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

    protected function validateString($field, $value, $param): bool
    {
        if ($value !== null && !is_string($value)) {
            $this->errors[$field][] = "The {$field} field must be a string.";
            return false;
        }
        return true;
    }

    protected function validateInt($field, $value, $param): bool
    {
        if ($value !== null && !filter_var($value, FILTER_VALIDATE_INT) && !is_int($value)) {
            $this->errors[$field][] = "The {$field} field must be an integer.";
            return false;
        }
        return true;
    }

    protected function validateNumeric($field, $value, $param): bool
    {
        if ($value !== null && !is_numeric($value)) {
            $this->errors[$field][] = "The {$field} field must be numeric.";
            return false;
        }
        return true;
    }

    protected function validateEmail($field, $value, $param): bool
    {
        if ($value !== null && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field][] = "The {$field} field must be a valid email address.";
            return false;
        }
        return true;
    }
}