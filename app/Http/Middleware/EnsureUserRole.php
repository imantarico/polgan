<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        $user = auth()->user();
        if (! $user){
            return redirect()->to('/login');
        }
        if ($user->role === $role) {
            return $next($request);
        }
        if ($user->role === 'admin') {
            return redirect()->to('/admin');
        }
        if ($user->role === 'marketing') {
            return redirect()->to('/marketing');
        }
        return $next($request);
    }
}
