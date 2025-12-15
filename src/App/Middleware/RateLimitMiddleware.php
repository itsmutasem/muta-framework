<?php

declare(strict_types=1);

namespace App\Middleware;

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
}