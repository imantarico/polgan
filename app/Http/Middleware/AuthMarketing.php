<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthMarketing
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // return $next($request);
        if ($request->is('marketing/login')) {
            return $next($request);
        }

        if (auth()->users()?->role !== 'marketing') {
            abort(403, 'Hanya marketing yang dapat mengakses halaman ini.');
        }
        return $next($request);
    }
}
