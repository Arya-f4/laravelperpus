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
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Get the first role of the authenticated user
        $userRole = Auth::user()->getRoleNames()->first();

        // Check if the user's role matches the required role
        if ($userRole !== $role) {
            // If the user does not have the required role, abort with 403
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
