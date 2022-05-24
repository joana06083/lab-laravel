<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckLogout
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

        if (empty(session()->has('LoggedUser')) && empty(session()->has('session_id'))) {
            //已登出狀態導回登入頁
            return redirect('Login')->with('logout', 'Currently not logged in! Please login first!');
        }
        return $next($request);
    }
}
