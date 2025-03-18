<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Closure;

class Authenticate extends Middleware
{
    /**
     * Handle an unauthenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     */
    protected function unauthenticated($request, array $guards)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthenticated'
            ], 401);
        }
        // return parent::unauthenticated($request, $guards);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     * Not needed for API-only application, but kept for compatibility
     */
    protected function redirectTo(Request $request): ?string
    {
        return null; 
    }
}