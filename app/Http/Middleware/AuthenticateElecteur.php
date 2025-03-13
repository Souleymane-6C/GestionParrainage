<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateElecteur
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('electeur')->check()) {
            return redirect()->route('electeur.login');
        }
        return $next($request);
    }
}
