<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleIdMiddleware
{
    public function handle(Request $request, Closure $next, $roleId)
    {
        $user = Auth::user();

        if ($user->role_id != $roleId) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
