<?php

namespace AppTenant\Services;

use App\Models\Statical\Constant;

class Uploads
{
    /**
     * Total spaced used for tenant uploads
     * 
     * @return string
     */
    public static function totalSpaceUsed($show_in_bytes = false)
    {
        $x = storage_path();
        $size = folderSize($x);

        return $show_in_bytes ? $size : sizeFormatter($size);
    }

    /**
     * Maximum space available
     * 
     * @return string
     */
    public static function totalSpaceAvailable($show_in_bytes = false)
    {
        if (isPaidSubscription()) {
            return Constant::INFINITY;
        }

        $bytes_available = env('DEMO_MAX_SPACE_AVAILABLE_MB') * 1024 * 1024;

        return $show_in_bytes ? $bytes_available : sizeFormatter($bytes_available);
    }
}
