<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle($request, Closure $next)
{
    if (Auth::check() && Auth::user()->role === 'admin') {
        return $next($request);
    }

    Auth::logout();

    if ($request->isMethod('GET')) {
        return redirect('/login')->with('error', 'Kamu bukan admin, akses ditolak!');
    }

    abort(403, 'Akses ditolak. Hanya admin yang diperbolehkan.');
}


}
