<?php

use Illuminate\Support\Facades\DB;

if (!function_exists('folderSize')) {
    /**
     * Calculates folder size
     * 
     * @return int|float (bytes)
     */
    function folderSize($dir)
    {
        $size = 0;

        foreach (glob(rtrim($dir, '/').'/*', GLOB_NOSORT) as $each) {
            $size += is_file($each) ? filesize($each) : folderSize($each);
        }

        return $size;
    }
}

if (!function_exists('isProduction')) {
    /**
     * Check if the environment is in production
     * @return boolean
     */
    function isProduction()
    {
        return in_array(config('app.env'), ['production']);
    }
}

if (!function_exists('isProductionOrStaging')) {
    /**
     * Check if the environment is in production or staging
     * @return boolean
     */
    function isProductionOrStaging()
    {
        return isProduction() || in_array(config('app.env'), ['staging']);
    }
}

if (!function_exists('debounceJobInQueue')) {
    /**
     * Get job id from session, remove if it exists and replace with new key
     * @return boolean
     */
    function debounceJobInQueue($session_key, $new_key)
    {
        $previous_queue_id = session($session_key);

        if ($previous_queue_id) {
            $db_name = env('DB_DATABASE');
            DB::delete("DELETE FROM {$db_name}.jobs WHERE id = ?", [$previous_queue_id]);
        }

        session([$session_key => $new_key]);
    }
}

if (!function_exists('sizeFormatter')) {
    /**
     * Format size from kb to human readable
     * 
     * @return string
     */
    function sizeFormatter($bytes)
    {
        $label = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');

        for ($i = 0; $bytes >= 1024 && $i < (count($label) - 1); $bytes /= 1024, $i++) ;

        return (round($bytes, 2) . " " . $label[$i]);
    }
}