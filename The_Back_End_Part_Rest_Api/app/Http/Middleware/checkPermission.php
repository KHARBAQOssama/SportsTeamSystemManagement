<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;

class checkPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

        public function handle($request, Closure $next, $permission)
        {
            $user = JWTAuth::user();

            if (!$user->permissions()->where('name', $permission)->exists()) {
                return response()->json(['message' => 'You do not have permission to perform this action.'], 403);
            }

            return $next($request);
        }
    
}
