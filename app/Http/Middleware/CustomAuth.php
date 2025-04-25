<?php

namespace App\Http\Middleware;

use Closure;

class CustomAuth
{
    public function handle($request, Closure $next)
    {
        if (!session()->has('user')) {
            return redirect()->route('login')->withErrors(['login' => 'Silakan login terlebih dahulu.']);
        }

        return $next($request);
    }
}
