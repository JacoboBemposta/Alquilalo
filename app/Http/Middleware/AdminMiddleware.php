<?php


// app/Http/Middleware/AdminMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Verifica si el usuario está autenticado y si tiene el campo 'is_admin' igual a 1
        if (Auth::check() && Auth::user()->is_admin == 1) {
            return $next($request);
        }

        // Si no es admin, redirige a la página principal
        return redirect('/');
    }
}
