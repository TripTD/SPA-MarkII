<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class HasLogged
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Session::get('logged')) {
            redirect()->route('Clients.login');
        }
        return $next($request);
    }
}
