<?php

namespace AppCentralAdmin\Services;

use Illuminate\Support\Facades\Auth;

/**
 * Central Admin application helper
 */
class CA
{
    /**
     * Central Admin app guard
     * @return \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    public static function guard()
    {
        return Auth::guard('central.admin');
    }

    /**
     * Logged in admin profile
     * @return null|AppCentralAdmin\Models\AdminProfile
     */
    public static function profile()
    {
        return static::guard()->user();
    }

    /**
     * Central Admin app prefixed route
     * @param string $name
     * @param mixed $params
     * @param bool $absolute
     * @return mixed
     */
    public static function route($name, $params = [], $absolute = true)
    {
        return route("central.admin.$name", $params, $absolute);
    }

    /**
     * Central Admin app prefixed view
     * @param string $name
     * @param \Illuminate\Contracts\Support\Arrayable|array $data
     * @param array $merge_data
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public static function view($name, $data = [], $merge_data = [])
    {
        return view("central.admin.$name", $data, $merge_data);
    }
}