<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class FotograferMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->role !== 'fotografer') {
            return redirect()->route('fotografer.login')
                ->withErrors('Silakan login sebagai fotografer!');
        }

        return $next($request);
    }
}
