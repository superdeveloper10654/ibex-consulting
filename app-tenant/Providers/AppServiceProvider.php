<?php

namespace AppTenant\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->addBladeDirectives();
        $this->addComponents();
    }

    protected function addBladeDirectives()
    {
        // tenant has paid subscription
        Blade::directive('subscription_paid', function () {
            $subscription_paid = tenant('id') ? isPaidSubscription() : '';

            return "<?php if (" . intval($subscription_paid) . ") { ?>";
        });

        Blade::directive('endsubscription_paid', function () {
            return "<?php } ?>";
        });

        // Tenant profile has permission
        Blade::directive('t_can', function ($permission) {
            return "<?php if (t_profile()->can($permission)) { ?>";
        });

        Blade::directive('endt_can', function () {
            return "<?php } ?>";
        });

        // Tenant profile has permission
        Blade::directive('t_canany', function ($permissions) {
            return "<?php if (t_profile()->canany($permissions)) { ?>";
        });

        Blade::directive('endt_canany', function () {
            return "<?php } ?>";
        });
    }

    protected function addComponents()
    {
        Blade::componentNamespace('AppTenant\\View\\Components', 'tenant');
        Blade::anonymousComponentPath(resource_path('views/tenant/components'), 'tenant');
    }
}
