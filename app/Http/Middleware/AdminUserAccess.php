<?php

namespace App\Http\Middleware;

use App\Constant\LoginConstant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminUserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->user()->int_permisionAccess === LoginConstant::AdminUser){
            return $next($request);
        }
        return back()->with('error', 'Seu perfil não tem acesso a essa página');
    }
}
