<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\MiddlewareInterface;
use Framework\Request;
use Framework\Response;
use Framework\RequestHandlerInterface;

class ChangeResponseExample implements MiddlewareInterface
{
    public function process(Request $request, RequestHandlerInterface $next): Response
    {
        $response = $next->handle($request);
        $response->setBody($response->getBody() . " - Middleware");
        return $response;
    }
}