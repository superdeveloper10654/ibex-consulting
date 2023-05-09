<?php

namespace AppTenant\Http\Controllers\BaseController;

use Exception;

class BaseControllerHelper
{
    /**
     * Automatically determine resource model name by controller name
     * @param string $controller_name
     * @return string
     */
    public static function determineResourceModel($controller_name_raw)
    {
        // @todo: implement caching
        $model_prefix = 'AppTenant\Models\\';
        $controller_name_arr = explode('\\', $controller_name_raw);
        $controller_name = end($controller_name_arr);
        $possible_model_name = str_replace('iesController', 'y', $controller_name);

        if ($possible_model_name != $controller_name ) {
            $model_name = $possible_model_name;
        } else {
            $possible_model_name = str_replace('sController', '', $controller_name);
            $model_name = $possible_model_name != $controller_name ? $possible_model_name : str_replace('Controller', '', $controller_name);
        }

        $model_name = $model_prefix . $model_name;

        if (!class_exists($model_name)) {
            $model_name = '';
        }

        return $model_name;
    }
}