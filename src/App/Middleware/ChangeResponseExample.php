<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Request;
use Framework\Response;

class ChangeResponseExample
{
    public function process(Request $request, $next): Response
    {
        $response = $next->hadle($request);
        $response->setBody($response->getBody() . " - Middleware");
        return $response;
    }
}