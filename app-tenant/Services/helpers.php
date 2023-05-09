<?php

use AppTenant\Constants\CacheKey;
use AppTenant\Models\Profile;
use AppTenant\Models\Setting;
use AppTenant\Models\Statical\Role;
use AppTenant\Services\T;
use Illuminate\Support\Facades\Cache;

if (!function_exists('admin_profile')) {
    /**
     * Return the very first admin profile which initially was subscribed
     * @return Profile
     */
    function admin_profile()
    {
        $cached = Cache::get(CacheKey::ADMIN_PROFILE);

        if (!$cached) {
            $cached = Profile::where('role', Role::ADMIN_ID)->first();
            Cache::put(CacheKey::ADMIN_PROFILE, $cached, config('cache.ttl'));
        }
        
        return $cached;
    }
}

if (!function_exists('isPaidSubscription')) {
    /**
     * Check if the subscription is Paid
     * @return Profile
     */
    function isPaidSubscription()
    {
        return admin_profile() ? admin_profile()->hasPaidSubscription() : false;
    }
}

if (!function_exists('isDemoSubscription')) {
    /**
     * Check if the subscription is Demo
     * @return Profile
     */
    function isDemoSubscription()
    {
        return admin_profile() ? admin_profile()->hasDemoSubscription() : false;
    }
}

if (!function_exists('setting')) {
    /**
     * Get/set setting value
     * 
     * @param string $key
     * @param mixed $value (optional) - if set then setting value will be overriten
     * @return mixed
     */
    function setting($key, $value = null)
    {
        return $value ? Setting::set($key, $value) : Setting::get($key);
    }
}

if (!function_exists('settingGetLink')) {
    /**
     * Get/set setting value
     * 
     * @param string $key
     * @param mixed $value (optional) - if set then setting value will be overriten
     * @return mixed
     */
    function settingGetLink($key)
    {
        return Setting::getLink($key);
    }
}

if (!function_exists('t_guard')) {
    /**
     * Tenant app guard
     * @return \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    function t_guard()
    {
        return T::guard();
    }
}

if (!function_exists('t_profile')) {
    /**
     * Logged in user profile
     * @return null|AppTenant\Models\Profile
     */
    function t_profile()
    {
        return T::profile();
    }
}

if (!function_exists('t_route')) {
    /**
     * Tenant app prefixed route
     * @param string $name
     * @param mixed $params
     * @param bool $absolute
     * @return mixed
     */
    function t_route($name, $params = [], $absolute = true)
    {
        return T::route($name, $params, $absolute);
    }
}

if (!function_exists('t_view')) {
    /**
     * Tenant app prefixed t_view
     * @param \Illuminate\Contracts\Support\Arrayable|array $data
     * @param array $merge_data
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    function t_view($name, $data = [], $merge_data = [])
    {
        return T::view($name, $data, $merge_data);
    }
}