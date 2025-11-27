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

        $data = self::removeControlChars($data);
        $data = html_entity_decode($data, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $data = preg_replace('#<\s*(script|style)[^>]*>.*?<\s*/\s*/\1\s*>#is','', $data);
        $data = preg_replace('#<\?xml[^>]*\?>#i', '', $data);
        $data = preg_replace('#<!DOCTYPE[^>]*>#is', '', $data);
        $data = preg_replace('#<!\[CDATA\[.*?\]\]>#is', '', $data);
    }

    protected static function removeControlChars(string $space): string
    {
        $space = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F\x{00A0}]/u', '', $space);
        return $space;
    }

    public static function cleanArray(array $array): array
    {
        foreach ($array as $key => $value) {
            $array[$key] = self::clean($value);
        }
        return $array;
    }
}