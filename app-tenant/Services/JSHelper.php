<?php

namespace AppTenant\Services;

use AppTenant\Constants\CacheKey;
use AppTenant\Models\Profile;
use AppTenant\Models\Statical\Role;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Js;

class JSHelper
{
    /**
     * Generate conf data
     * @return Illuminate\Support\Js
     */
    public static function generateConf()
    {
        $conf = [
            'app'   => [
                'env'   => config('app.env')
            ],
            'routes'    => [
                'activities.load-previous'  => t_route("activities.load-previous"),
                'notifications.dismiss'     => t_route('notifications.dismiss'),
                'uploads.file-rename'       => t_route('uploads.file-rename'),
                'uploads.download'          => t_route('uploads.download', '_id_'),
                'uploads.remove'            => t_route('uploads.remove'),
                'uploads.store'             => t_route('uploads.store'),
            ],
        ];

        if (tenant() && t_profile()) {
            $conf['channels']  = [
                'prefix'        => tenant('uuid'),
                'second_prefix' => t_profile()->uuid,
            ];
        }

        return Js::from($conf);
    }

    /**
     * Generate data related for profile of current user
     * @return Illuminate\Support\Js
     */
    public static function generateUserProfileData()
    {
        $data = [
            'logged_in'     => (bool) t_profile(),
        ];

        if (t_profile()) {
            $data['id'] = t_profile()->id;
            $data['can'] = [
                'uploads.remove'    => t_profile()->can('uploads.remove'),
            ];
        }

        return Js::from($data);
    }
}