<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSellerPermissionLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userIsAdmin = $request->user() && $request->user()->role === 'admin';
        $userIsSeller = $request->user() && $request->user()->role === 'seller';

        if (auth()->check() && ($userIsAdmin || $userIsSeller)) {
            return $next($request);
        }

        return redirect()->back()->with('error', 'Acesso negado');
    }
}
