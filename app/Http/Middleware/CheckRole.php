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
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        // Cek apakah status akun aktif
        if ($user->status_akun !== 'aktif') {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Akun Anda tidak aktif.');
        }

        // Cek apakah role user sesuai dengan yang diizinkan
        if (!in_array($user->role, $roles)) {
            // Redirect ke dashboard sesuai role
            return $this->redirectToRoleDashboard($user->role);
        }

        return $next($request);
    }

    /**
     * Redirect ke dashboard sesuai role
     */
    private function redirectToRoleDashboard($role)
    {
        switch ($role) {
            case 'admin':
                return redirect()->route('admin.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
            case 'fotografer':
                return redirect()->route('fotografer.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
            case 'pelanggan':
                return redirect()->route('pelanggan.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
            default:
                return redirect()->route('login')->with('error', 'Role tidak valid.');
        }
    }
}
