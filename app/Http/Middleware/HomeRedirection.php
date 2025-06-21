<?php

namespace App\Http\Middleware;

use Symfony\Component\HttpFoundation\Response;

class HomeRedirection
{
    /**
     * Handle an incoming request.
     *
     */
    public function handle(): Response
    {
        $user = auth()->user();

        if (!$user) return redirect('/login');

        return match ($user->role) {
            'admin' => redirect('/admin/dashboard'),
            'seller' => redirect('/seller/dashboard'),
            default => redirect('/login'),
        };
    }
}
