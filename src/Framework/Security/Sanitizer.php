<?php

declare(strict_types=1);

namespace Framework\Security;

class Sanitizer
{
    public static function clean(mixed $data): mixed
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = self::clean($value);
            }
            return $data;
        }

        if (!is_string($data)) {
            return $data;
        }
    }
}