<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckEquipeRole
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        
        if (!$user || !$user instanceof \App\Models\Equipe) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized: Equipe access required'
            ], 403);
        }

        return $next($request);
    }
}