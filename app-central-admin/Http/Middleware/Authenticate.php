<?php

namespace AppCentralAdmin\Http\Middleware;

use AppCentralAdmin\Services\CA;
use Closure;
use Illuminate\Http\Request;

class Authenticate
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
        if (CA::profile()) {
            return $next($request);
        }
        
        return redirect(CA::route('auth.login'));
    }
}
