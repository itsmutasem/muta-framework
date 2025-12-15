<?php

use App\Middleware\RateLimitMiddleware;
use Framework\Security\CsrfGuard;

return [
    'csrf' => CsrfGuard::class,
    'rate_limit' => RateLimitMiddleware::class
];