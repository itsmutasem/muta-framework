<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Request;
use Framework\RequestHandlerInterface;
use Framework\Response;

final class RateLimitMiddleware
{
    private int $limit;
    private int $windowSeconds;
    private string $keyPrefix;

    public function __construct(int $limit = 60, int $windowSeconds = 60, string $keyPrefix = 'rate_limit_')
    {
        $this->limit = $limit;
        $this->windowSeconds = $windowSeconds;
        $this->keyPrefix = $keyPrefix;
    }

    public function process(Request $request, RequestHandlerInterface $handler): Response
    {
        $ip = $this->getClientIp($request);
        $method = strtoupper($request->method() ?? 'GET');
        $path = $request->path() ?? '/';
        $bucket = (int) floor(time() / $this->windowSeconds);
        $key = $this->keyPrefix . ':' . sha1($method . '|' . $path . '|' . $ip) . ':' . $bucket;
        $count = $this->increment($key, $this->windowSeconds + 1);
        if ($count > $this->limit) {
            $retryAfter = $this->windowSeconds - (time() % $this->windowSeconds);
            return new Response(
                429,
                [
                    'Content-Type' => 'text/plain',
                    'Retry-After' => (string) $retryAfter
                ],
                'Too Many Requests'
            );
        }
        return $handler->handle($request);
    }

    public function increment(string $key, int $ttlSeconds): int
    {
        if (!function_exists('apcu_fetch')) {
            throw new \RuntimeException('APCu extension is required for rate limiting');
        }
        $value = apcu_fetch($key);
        if ($value === false) {
            apcu_add($key, 1, $ttlSeconds);
            return 1;
        }
        return (int) apcu_inc($key);
    }

    public function getClientIp(Request $request): string
    {
        $ip = $request->server('REMOTE_ADDR');
        return is_string($ip) && $ip !== '' ? $ip : '0.0.0.0';
    }
}