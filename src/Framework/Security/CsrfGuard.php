<?php

declare(strict_types=1);

namespace Framework\Security;

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
                $response = new Response();
                $response->setBody('CSRF Token in invalid');
                $response->setStatusCode(403);
                return $response;
            }
        }
        return $next->handle($request);
    }
}