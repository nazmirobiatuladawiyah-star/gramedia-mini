<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsGuest
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check()){
            //kalau udah login, gaboleh akses halaman ini, jadi arahkan kembali ke home
            return redirect()->route('home')->with('error', 'halaman hanya boleh di akses sebelum login!');
        } else {
            //jika belum login, maka di perbolehkan akses halaman tsb
        return $next($request);
        }
    }
}
