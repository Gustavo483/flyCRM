<?php

namespace App\Http\Middleware;

use Closure;
use App\Constant\LoginConstant;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->user()->int_permisionAccess === LoginConstant::AdminRoot){
            return $next($request);
        }
        return back()->with('error', 'Seu perfil não tem acesso a essa página');
    }
}
