<?php

/**
 * @author Gabriel Ruelas
 * @license MIT
 * @version 1.2.0
 *
 */

namespace Equidna\Toolkit\Http\Middleware;

use Illuminate\Http\Request;
use Closure;

//This middleware excludes the current request from being stored in the session
class ExcludeFromHistory
{
    /**
     * Removes the '_previous' session key to exclude the current request
     * from being stored in the session history.
     *
     * @param Request $request The incoming HTTP request.
     * @param Closure $next The next middleware in the pipeline.
     * @return mixed The response from the next middleware.
     */
    public function handle(Request $request, Closure $next): mixed
    {
        try {
            $request->session()->forget('_previous');
        } catch (\Exception $e) {
            //
        }

        return $next($request);
    }
}
