<?php

declare(strict_types=1);

namespace Framework\Security;

use Framework\Exceptions\CsrfException;
use Framework\MiddlewareInterface;
use Framework\Request;
use Framework\RequestHandlerInterface;
use Framework\Response;

class CsrfGuard implements MiddlewareInterface
{
    public function __construct(private CsrfToken $csrfToken)
    {
    }

    public function process(Request $request, RequestHandlerInterface $next): Response
    {
        $method = $request->method;
        if (in_array($method, ['POST', 'PUT', 'DELETE', 'PATCH'])) {
            $token = $request->post['csrf_token'] ?? $request->server['HTTP_X_CSRF_TOKEN'] ?? null;
            if (!$this->csrfToken->verify($token)) {
                throw new CsrfException("CSRF token mismatch");
            }
        }

        $origin = $request->server['HTTP_ORIGIN'] ?? null;
        $host = $request->server['HTTP_HOST'] ?? null;
        if ($origin && !str_contains($origin, $host)) {
            throw new CsrfException("Invalid CSRF origin");
        }

        return $next->handle($request);
    }
}