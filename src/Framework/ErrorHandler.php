<?php

declare(strict_types=1);

namespace Framework;

use ErrorException;
use Throwable;
use Framework\Exceptions\PageNotFoundException;

class ErrorHandler
{
    public static function handleError(
        int $errno,
        string $errstr,
        string $errfile,
        int $errline): bool
    {
        throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
    }

    public static function handleException(Throwable $exception): void
    {
        if ($exception instanceof PageNotFoundException) {
            http_response_code(404);
            $template = "404";
        } else {
            http_response_code(500);
            $error_file = $exception->getFile();
            $error_line = $exception->getLine();

            // Get code snippet (5 lines before and after)
            $lines = file($error_file);
            $start = max($error_line - 11, 0);
            $length = 21;
            $snippet = array_slice($lines, $start, $length, true);

            // Format snippet with line numbers and highlighting
            $formatted_snippet = '';
            foreach ($snippet as $i => $line) {
                $line_num = $i + 1;
                $is_error_line = $line_num === $error_line;
                $formatted_snippet .= sprintf(
                    '<div class="flex %s">
                    <span class="w-12 text-right pr-4 %s">%d</span>
                    <pre class="flex-1 whitespace-pre-wrap %s">%s</pre>
                 </div>',
                    $is_error_line ? 'bg-red-900/40' : 'bg-transparent',
                    $is_error_line ? 'text-red-400 font-bold' : 'text-gray-500',
                    $line_num,
                    $is_error_line ? 'text-red-200 font-semibold' : 'text-gray-300',
                    htmlspecialchars($line)
                );
            }

            $error_data = [
                'error_name' => get_class($exception),
                'error_message' => $exception->getMessage(),
                'error_file' => $error_file,
                'error_line' => $error_line,
                'error_trace' => $exception->getTraceAsString(),
                'error_snippet' => $formatted_snippet,
            ];
            $template = "500";
        }
        $show_errors = false;
        if ($show_errors) {
            ini_set("display_errors", "1");
        } else {
            ini_set("display_errors", "0");
            ini_set("log_errors", "1");
            require "views/Errors/$template.php";
        }
        throw $exception;
    }
}
