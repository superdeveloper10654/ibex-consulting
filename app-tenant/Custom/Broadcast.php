<?php

namespace AppTenant\Custom;

use Illuminate\Support\Facades\Broadcast as FacadesBroadcast;

class Broadcast
{
    /** @var array default options for ::channel() */
    protected static $default_channel_options = [
        'guards' => [
            'tenant',
        ],
    ];

    /**
     * Create channel for each profile in tenant instance
     * @param string $name of the channel
     * @return void
     */
    public static function channel($name)
    {
        $channel_name = static::generateChannelName($name, 'tenantUuid', 'profileUuid', true);

        FacadesBroadcast::channel($channel_name, function ($user_profile, $tenantUuid, $profileUuid) {
            return $user_profile->uuid == $profileUuid && $tenantUuid == tenant('uuid');
        }, static::$default_channel_options);
    }

    /**
     * Generate unique channel name for profile in tenant instance
     * @param string $channel_name
     * @param string $param1
     * @param string $param2
     * @param bool $wrap_params in parentheses
     * @return string
     */
    public static function generateChannelName($channel_name, $param1, $param2, $wrap_params = false)
    {
        $param1 = !$wrap_params ? $param1 : ('{' . $param1 . '}');
        $param2 = !$wrap_params ? $param2 : ('{' . $param2 . '}');

        return "$channel_name.$param1.$param2";
    }
}