<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    
    public function handle(Request $request, Closure $next, $role): Response
    {
        if ($role == 'admin') {
            if (Auth::user()->role == 'admin' ) {
                return $next($request);
            }
        } elseif ($role == 'user') {
            if (Auth::user()->role == 'user') {
                return $next($request);
            }
        }

        return response()->json(['error' => 'Unauthorized'], 403);
    }
}
