<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            Cache::flush();
            //alert()->error('Error', 'Session telah berakhir, silahkan anda login!');
            flash('error', 'Session telah berakhir, silahkan anda login!');
            return redirect(route('auth.login'));
        }

        if (!auth()->user()->is_active) {
            Cache::flush();
            Auth::logout();
            flash('error', 'Akun anda sedang dinonaktifkan!!');
            return redirect(route('auth.login'));
        }

        return $next($request);
    }
}
