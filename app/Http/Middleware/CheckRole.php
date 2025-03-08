<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        // Jika pengguna adalah admin, izinkan akses
        if ($request->user()->isAdmin()) {
            return $next($request);
        }

        // Jika tidak ada peran yang ditentukan, izinkan akses
        if (empty($roles)) {
            return $next($request);
        }

        // Periksa apakah pengguna memiliki salah satu peran yang diperlukan
        foreach ($roles as $role) {
            if ($request->user()->hasRole($role)) {
                return $next($request);
            }
        }

        // Jika tidak memiliki peran yang diperlukan, redirect ke dashboard
        return redirect()->route('dashboard')
            ->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
    }
}
