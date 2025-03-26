<?php

/**
 * @author Gabriel Ruelas
 * @license MIT
 * @version 1.0.0
 *
 */

namespace Equidna\Toolkit\Http\Middleware;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Closure;

//This middleware forces the response to be an API response
class ForceApiResponse
{
    public function handle(Request $request, Closure $next): Response
    {
        $request->attributes->add(
            [
                'api_response' => true
            ]
        );

        return $next($request);
    }
}
