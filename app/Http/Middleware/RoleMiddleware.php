<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        $roles = array_map('trim', $roles);

        if (Auth::check()) {
            if (in_array(Auth::user()->role, $roles)) {
                return $next($request);
            }
        }

        return abort(403); 
    }
}
