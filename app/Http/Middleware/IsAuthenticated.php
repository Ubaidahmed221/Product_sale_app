<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->check() && auth()->user()->is_admin  == 1){
            return  redirect()->route('admin.dashboard');

        }
       else if(auth()->check() && auth()->user()->is_admin  == 0){
            return  redirect()->route('user.dashboard');

        }
        return $next($request);
    }
}