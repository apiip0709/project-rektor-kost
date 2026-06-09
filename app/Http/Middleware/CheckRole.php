<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan masuk terlebih dahulu.');
        }

        $user = Auth::user();

        // 2. Cek apakah role user ada di dalam daftar role yang diizinkan (...$roles)
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // 3. Jika tidak punya akses, arahkan ke halaman yang sesuai role-nya (mencegah bug/kesasar)
        return match ($user->role) {
            'superadmin' => redirect()->route('superadmin.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.'),
            'admin'      => redirect()->route('admin.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.'),
            'pemilik'    => redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.'),
            default      => redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.'),
        };
    }
}