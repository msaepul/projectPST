<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            // Redirect to login if the user is not authenticated
            return redirect('/login');
        }

        $user = Auth::user();

        // Check if the user has one of the required roles
        if (!in_array($user->role, $roles)) {
            // Redirect if the user's role is not authorized
            return redirect('/dashboard');
        }

        return $next($request);
    }
}
