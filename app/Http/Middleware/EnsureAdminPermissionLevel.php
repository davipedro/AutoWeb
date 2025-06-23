<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminPermissionLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userIsAdmin = auth()->check() && auth()->user()->role === 'admin';

        if (auth()->check() && $userIsAdmin) {
            return $next($request);
        }

        return redirect()->back()->with('error', 'Acesso negado');
    }
}
