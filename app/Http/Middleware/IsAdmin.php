<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // MASUKKIN MIDDLEWARE INI KE kernel.php
        // kalo pake gate, gaperlu pake auth()->check() karna udah login
        if(!auth()->check() || !auth()->user()->is_admin) { // guest artinya belum login, kalau user bukan admin
            abort(403); // 403 itu forbidden
        }
        return $next($request);
    }
}
