<?php

namespace AppTenant\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Check if user profile with role Admin has subscription and it is paid (not trial)
 */
class SubscriptionDemoOrPaid
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
        if (!isPaidSubscription() && !isDemoSubscription()) {
            return redirect('billing');
        }

        return $next($request);
    }
}