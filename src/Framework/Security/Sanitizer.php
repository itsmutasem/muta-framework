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

        $data = preg_replace('/[\x00-\x1F\x7f]/u', '', $data);
        $data = preg_replace('#<(secript|style)[^>]*>.*?</\1>#is', '', $data);
        $data = strip_tags($data);
        $data = htmlspecialchars($data, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $data = trim($data);
        return $data;
    }

    public static function cleanArray(array $array): array
    {
        foreach ($array as $key => $value) {
            $array[$key] = self::clean($value);
        }
        return $array;
    }
}