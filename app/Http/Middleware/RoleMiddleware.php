<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  mixed  ...$roles
     */
    public function handle($request, Closure $next, ...$roles)
    {
        // Cek apakah user terautentikasi dan role-nya ada di dalam parameter
        if (auth()->check() && in_array(auth()->user()->role, $roles)) {
            return $next($request);
        }

        // Redirect jika role tidak sesuai
        return redirect('/');
    }
}
