<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class isAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // if (!Auth::check()){
        //     return redirect()->route('login')->with('error', 'anda buat login!');
        // }
       if(Auth::user()->role !='admin'){
            return redirect()->route('home')->with('error', 'halaman hanya boleh di akses oleh admin!');

        } else {
        return $next($request);
        }
    }
}
