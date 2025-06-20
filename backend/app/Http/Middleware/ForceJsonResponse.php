<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceJsonResponse
{
    /**
     * Force all responses to be JSON
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Force Accept header to application/json
        $request->headers->set('Accept', 'application/json');
        
        // Get the response
        $response = $next($request);
        
        // Force Content-Type header to application/json
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }
}