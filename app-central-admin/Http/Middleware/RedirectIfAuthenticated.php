<?php

namespace AppCentralAdmin\Http\Middleware;

use AppCentralAdmin\Services\CA;
use Closure;
use Illuminate\Http\Request;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (CA::guard()->check()) {
            return redirect(CA::route('home'));
        }

        return $next($request);
    }
}
