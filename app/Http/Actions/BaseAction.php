<?php

namespace App\Http\Actions;

use App\Common\ActionResponse;

abstract class BaseAction
{
    /**
     * Main function
     * @return App\Common\ActionResponse
     */
    abstract public function handle();

    /**
     * Generates error response
     * @param string $msg
     * @param array $data
     * @return ActionResponse
     */
    protected static function error($msg, $data = [])
    {
        return ActionResponse::error($msg, $data);
    }

    /**
     * Generates success response
     * @param array|string $data_or_message
     * @param string $msg
     * @return ActionResponse
     */
    protected static function success($data_or_message = [], $msg = 'Success')
    {
        if (is_string($data_or_message)) {
            $msg = $data_or_message;
            $data = [];
        } else {
            $data = $data_or_message;
        }
        
        return ActionResponse::success($data, $msg);
    }
}
