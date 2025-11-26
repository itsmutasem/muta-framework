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

    protected function validateMax($field, $value, $param): bool
    {
        if ($value === null) return true;
        $max = (int) $param;
        if (is_string($value) && mb_strlen($value) > $max) {
            $this->errors[$field][] = "The {$field} field may not be greater than {$max} characters.";
            return false;
        }
        if (is_numeric($value) || is_int($value) && $value > $max) {
            $this->errors[$field][] = "The {$field} field may not be greater than {$max}.";
            return false;
        }
        return true;
    }

    protected function validateMin($field, $value, $param): bool
    {
        if ($value === null) return true;
        $min = (int) $param;
        if (is_string($value) && mb_strlen($value) < $min) {
            $this->errors[$field][] = "The {$field} field must be at least {$min} characters.";
            return false;
        }
        if (is_numeric($value) || is_int($value) && $value < $min) {
            $this->errors[$field][] = "The {$field} field must be at least {$min}.";
            return false;
        }
        return true;
    }

    protected function validateUrl($field, $value, $param): bool
    {
        if ($value !== null && !filter_var($value, FILTER_VALIDATE_URL)) {
            $this->errors[$field][] = "The {$field} field must be a valid URL.";
            return false;
        }
        return true;
    }

    protected function validateBool($field, $value, $param): bool
    {
        if ($value !== null && !is_bool($value)) {
            $this->errors[$field][] = "The {$field} field must be a boolean.";
            return false;
        }
        return true;
    }
}