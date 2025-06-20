<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string|null $role
     * @return Response
     */
    public function handle(Request $request, Closure $next, string $role = null): Response
    {
        if (!$request->user()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        if ($role && !$request->user()->hasRole($role)) {
            return response()->json(['message' => 'Unauthorized. Requires role: ' . $role], 403);
        }

        return $next($request);
    }
}