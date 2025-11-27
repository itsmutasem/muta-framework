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
        $data = preg_replace_callback(
            '#<([a-z0-9]+)([^>]*)>#is',
            function ($matches) {
                $tag = $matches[1];
                $attrs = $matches[2];
                $attrs = preg_replace('/\s+on[a-z\-]+\s*=\s*(["\']).*?\1/is', '', $attrs);
                $attrs = preg_replace('/\s+on[a-z\-]+\s*=\s*[^>\s]*/is', '', $attrs);
                $attrs = preg_replace('/\s+[a-z\-]+:\s*[^>\s]*/is', '', $attrs);
                $attrs = preg_replace('/\s+(href|src)\s*=\s*(["\']?)\s*(javascript:|data:)[^"\'>\s]*\2/iu', '', $attrs);
                return "<{$tag}{$attrs}>";
            },
            $data
        );
        $data = preg_replace('#<\s*(svg|math|iframe|object|embed)[^>]*>.*?<\s*/\s*\1\s*>#is', '', $data);
        $data = strip_tags($data);
        $data = preg_replace('/\b(javascript|data|vbscript)\s*:/i', '', $data);
        $data = htmlspecialchars($data, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'UTF-8');
        $data = trim(preg_replace('/\s+/u', ' ', $data));
        return $data;
    }

    public static function cleanArray(array $array): array
    {
        foreach ($array as $key => $value) {
            $array[$key] = self::clean($value);
        }
        return $array;
    }

    protected static function removeControlChars(string $space): string
    {
        $space = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F\x{00A0}]/u', '', $space);
        return $space;
    }

    public static function safeFile(string $filename): string
    {
        $basename = basename($filename);
        $safe = preg_replace('/[^A-Za-z0-9\.\-\_]/', '_', $basename);
        if (strpos($safe, '.') === 0) {
            $safe = 'file' . $safe;
        }
        return $safe;
    }
}
