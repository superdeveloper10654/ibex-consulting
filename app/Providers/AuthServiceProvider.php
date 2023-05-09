<?php

namespace App\Providers;

use AppTenant\Services\Permission;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        // @todo: remove if no issues
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            if ($user instanceof \AppTenant\Models\Profile) {
                if (Permission::granted($ability, $user)) {
                    return true;
                } else {
                    return false;
                }
            }


            return true;
        });
    }
}
