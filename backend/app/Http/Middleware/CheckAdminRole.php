<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdminRole
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        
        if (!$user || !$user instanceof \App\Models\Admin) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized: Admin access required'
            ], 403);
        }

        return $next($request);
    }
}