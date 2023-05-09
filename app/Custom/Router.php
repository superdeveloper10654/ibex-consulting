<?php

namespace App\Custom;

use Illuminate\Routing\Router as BaseRouter;
use Illuminate\Support\Str;

class Router extends BaseRouter
{
    /**
     * Check is current route name starts with string
     * 
     * @param string|array If any of array values fits - return true
     * @return boolean
     */
    public function currentRouteNameStartsWith($name)
    {
        $current_route_name = static::currentRouteName();

        if (is_string($name)) {
            return $current_route_name == $name 
                    || Str::startsWith($current_route_name, "$name.") 
                    || Str::startsWith($current_route_name, "$name-");
        } else {
            foreach ($name as $single_name) {
                if (
                    $current_route_name == $single_name 
                    || Str::startsWith($current_route_name, "$single_name.")
                    || Str::startsWith($current_route_name, "$single_name-")
                ) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Check is current route name is the same from param
     * 
     * @param string|array If any of array values fits - return true
     * @return boolean
     */
    public function currentRouteNameIs($name)
    {
        $current_route_name = static::currentRouteName();

        if (is_string($name)) {
            return $current_route_name == $name;
        } else {
            foreach ($name as $single_name) {
                if ($single_name == $name) {
                    return true;
                }
            }
        }

        return false;
    }
}