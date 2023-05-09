<?php

namespace AppTenant\Services;

use Illuminate\Support\Facades\Auth;

/**
 * Tenant application helper
 */
class T
{
    /**
     * Tenant app guard
     * @return \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    public static function guard()
    {
        return Auth::guard('tenant');
    }

    /**
     * Logged in user profile
     * @return null|AppTenant\Models\Profile
     */
    public static function profile()
    {
        return static::guard()->user();
    }

    /**
     * Tenant app prefixed route
     * @param string $name
     * @param mixed $params
     * @param bool $absolute
     * @return mixed
     * 
     * @todo add prefix
     */
    public static function route($name, $params = [], $absolute = true)
    {
        $link = route("$name", $params, $absolute);
        $current_domain = request()->getHttpHost();
        $tenant_domain = tenant()->domains()->first()->domain;

        return str_replace($current_domain, $tenant_domain, $link);
    }

    /**
     * Tenant app prefixed view
     * @param \Illuminate\Contracts\Support\Arrayable|array $data
     * @param array $merge_data
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public static function view($name, $data = [], $merge_data = [])
    {
        return view("tenant.$name", $data, $merge_data);
    }
}