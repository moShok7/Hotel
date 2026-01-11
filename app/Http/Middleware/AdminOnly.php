<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
       public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user || $user->email !== 'admin@example.com') {
            abort(403); // доступ запрещен
        }

        return $next($request);
    }
}
