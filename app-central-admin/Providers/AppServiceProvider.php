<?php

namespace AppCentralAdmin\Providers;

use Illuminate\Pagination\Paginator;
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
     * @return void
     */
    public function boot()
    {
        $this->addBladeDirectives();
    }

    /**
     * Boostrap blade directives
     */
    protected function addBladeDirectives()
    {
        // @todo
        // Blade::directive('@ca_section', function () {
        //     return "<?php }";
        // });
    }
}
