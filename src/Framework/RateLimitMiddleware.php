<?php

declare(strict_types=1);

namespace Framework;

class RateLimitMiddleware implements MiddlewareInterface
{
    private int $limit;
    private int $windowSeconds;
    private string $keyPrefix;

    public function __construct(int $limit = 60, int $windowSeconds = 60, string $keyPrefix = 'rl')
    {
        $this->limit = $limit;
        $this->windowSeconds = $windowSeconds;
        $this->keyPrefix = $keyPrefix;
    }

    public function process(Request $request, RequestHandlerInterface $next): Response
    {
        $ip = $this->getClientIp($request);
        $method = strtoupper((string) ($request->method ?? 'GET'));
        $path = (string) ($request->server['REQUEST_URI'] ?? '/');
        $bucket = (int) floor(time() / $this->windowSeconds);
        $key = $this->keyPrefix . ':' . sha1($method . '|' . $path . '|' . $ip) . ':' . $bucket;
        $count = $this->increment($key, $this->windowSeconds + 1);
        if ($count > $this->limit) {
            $retryAfter = $this->windowSeconds - (time() % $this->windowSeconds);
            return new Response(
                429,
                'Too Many Requests',
                [
                    'Content-Type' => 'text/plain',
                    'Retry-After' => (string) $retryAfter,
                ]
            );
        }
        return $next->handle($request);
    }

    private function increment(string $key, int $ttlSeconds): int
    {
        if (!function_exists('apcu_fetch')) {
            throw new \RuntimeException('APCu is required for RateLimitMiddleware (or replace with Redis/file store).');
        }
        $value = apcu_fetch($key);
        if ($value === false) {
            apcu_add($key, 1, $ttlSeconds);
            return 1;
        }
        return (int) apcu_inc($key);
    }

    private function getClientIp(Request $request): string
    {
        $ip = $request->server['REMOTE_ADDR'] ?? null;
        return is_string($ip) && $ip !== '' ? $ip : '0.0.0.0';
    }
}