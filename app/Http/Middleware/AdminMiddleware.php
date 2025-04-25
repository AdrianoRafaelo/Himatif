<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = session('user');

        if (!$user || ($user['role'] ?? 'mahasiswa') !== 'admin') {
            return redirect('/')->withErrors('Anda tidak punya akses sebagai admin.');
        }

        return $next($request);
    }
}
