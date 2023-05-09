<?php

namespace AppTenant\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\View\ViewServiceProvider;

class TenancyViewServiceProvider extends ViewServiceProvider
{
    /*
     * separate folders (framework/views) for tenants in storage/ folder
     * @todo I'm sure should be better approach to make this change
     * @toto artisan command for tenants (single/all) view clear
     */
    public function registerBladeCompiler()
    {
        $host = request()->getHost();
        $host_arr = explode('.', $host);

        if (count($host_arr) < 3) { // that mean we have no subdomain and request made to central part
            return ;
        }
        
        $tenant_id = current($host_arr);
        $path_tenant = storage_path(config('tenancy.filesystem.suffix_base') . $tenant_id);
        $path_tenant_views = $path_tenant . '/framework/views';

        if (!File::isDirectory($path_tenant_views)) {
            if (!File::isDirectory($path_tenant)) {
                File::makeDirectory($path_tenant);
            }
            $path2 = $path_tenant . '/framework';
            if (!File::isDirectory($path2)) {
                File::makeDirectory($path2);
            }

            File::makeDirectory($path_tenant_views);
        }

        Config::set('view.compiled', realpath($path_tenant_views));

        parent::registerBladeCompiler();
    }
}