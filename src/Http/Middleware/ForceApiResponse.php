<?php

/**
 * @author Gabriel Ruelas
 * @license MIT
 * @version 0.6.5
 *
 */

namespace Equidna\Toolkit\Http\Middleware;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Closure;

//This middleware forces the response to be an API response
// DEPRECATED: Use ForceJsonResponse instead
class ForceApiResponse
{
    /**
     * Handle an incoming request and force the Accept header to application/json.
     *
     * @param Request $request The incoming HTTP request.
     * @param Closure $next The next middleware in the pipeline.
     * @return Response The response from the next middleware.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $request->headers->set('Accept', 'application/json');

        return $next($request);
    }
}
