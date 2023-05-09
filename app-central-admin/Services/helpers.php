<?php

use AppCentralAdmin\Services\CA;

if (!function_exists('ca_guard')) {
    /**
     * Central Admin app guard
     * @return \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    function ca_guard()
    {
        return CA::guard();
    }
}

if (!function_exists('ca_profile')) {
    /**
     * Logged in user profile
     * @return null|AppAdmin\Models\Profile
     */
    function ca_profile()
    {
        return CA::profile();
    }
}

if (!function_exists('ca_route')) {
    /**
     * Central Admin app prefixed route
     * @param string $name
     * @param mixed $params
     * @param bool $absolute
     * @return mixed
     */
    function ca_route($name, $params = [], $absolute = true)
    {
        return CA::route($name, $params, $absolute);
    }
}

if (!function_exists('ca_view')) {
    /**
     * Central Admin app prefixed view
     * @param \Illuminate\Contracts\Support\Arrayable|array $data
     * @param array $merge_data
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    function ca_view($name, $data = [], $merge_data = [])
    {
        return CA::view($name, $data, $merge_data);
    }
}