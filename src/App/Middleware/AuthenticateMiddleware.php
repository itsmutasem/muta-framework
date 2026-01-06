<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\MiddlewareInterface;
use Framework\Request;
use Framework\Response;
use Framework\RequestHandlerInterface;

class AuthenticateMiddleware implements MiddlewareInterface
{
    public function process(Request $request, RequestHandlerInterface $next): Response
    {
        if (!isset($_SESSION['user_id'])) {
            return new Response(302, '', ['Location' => '/auth/login']);
        }
        return $next->handle($request);
    }
}