<?php

use App\Middleware\LoginRateLimitMiddleware;
use App\Middleware\RateLimitMiddleware;
use Framework\Security\CsrfGuard;

return [
    'csrf' => CsrfGuard::class,
    'rate_limit_default' => RateLimitMiddleware::class,
    'rate_limit_login' => LoginRateLimitMiddleware::class,
];