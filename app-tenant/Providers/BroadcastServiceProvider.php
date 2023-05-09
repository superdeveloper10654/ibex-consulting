<?php

namespace AppTenant\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;
use Stancl\Tenancy\Middleware as TenancyMiddleware;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Broadcast::routes([
            'middleware' => [
                TenancyMiddleware\PreventAccessFromCentralDomains::class,
                TenancyMiddleware\InitializeTenancyByDomain::class,
                'web', 
                'tenant.auth',
            ]
        ]);

        require base_path('routes/tenant/channels.php');
    }
}