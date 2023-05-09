<?php

namespace AppTenant\Services;

use AppTenant\Constants\CacheKey;
use AppTenant\Models\Profile;
use AppTenant\Models\Statical\Role;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class Helper
{
    /**
     * @param Spatie\MediaLibrary\MediaCollections\Models\Media $file
     * @return string
     */
    public static function getUploadsClassForFile($file)
    {
        return "\AppTenant\Models\\" . $file->collection_name;
    }

    /**
     * Check if model has attributes
     * @param string $model
     * @param string|array $attrs
     */
    public static function modelHasAttributes(string $model, string|array $attrs): bool
    {
        $attrs = is_array($attrs) ? $attrs : [$attrs];

        $modelAttrs = Schema::getColumnListing(
            app($model)->getTable()
        );

        return count(array_intersect($attrs, $modelAttrs)) === count($attrs);
    }

    /**
     * Get current tenant profiles
     * @return Collection
     */
    public static function teamProfiles()
    {
        $profiles = Cache::get(CacheKey::TEAM_PROFILES);

        if (empty($profiles)) {
            $profiles = Profile::where('role', '!=', Role::SUPER_ADMIN_ID)->get();
            Cache::put(CacheKey::TEAM_PROFILES, $profiles, config('cache.ttl'));
        }

        return $profiles;
    }

    /**
     * Get current tenant profiles including support team profile
     * @return Collection
     */
    public static function teamProfilesWithSupport()
    {
        $profiles = Cache::get(CacheKey::TEAM_PROFILES_WITH_SUPPORT);

        if (empty($profiles)) {
            $profiles = Profile::all();
            Cache::put(CacheKey::TEAM_PROFILES_WITH_SUPPORT, $profiles, config('cache.ttl'));
        }

        return $profiles;
    }
}