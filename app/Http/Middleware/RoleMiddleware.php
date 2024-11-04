<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login'); // Redirect to login if not authenticated
        }

        $user = Auth::user();

        if (!in_array($user->role, $roles)) {
            return redirect()->route('login')->with('error', 'Unauthorized access');
        }

        return $next($request);
    }
}
