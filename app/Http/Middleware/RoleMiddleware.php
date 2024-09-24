<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        // Pastikan user sudah login dan periksa role-nya
        if (!Auth::check() || Auth::user()->role !== $role) {
            // Redirect jika user tidak memiliki akses
            return redirect('/')->with('error', 'You do not have access to this page.');
        }

        return $next($request);
    }
}
