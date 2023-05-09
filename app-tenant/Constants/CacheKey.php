<?php

namespace AppTenant\Constants;

/**
 * Cache keys described here.
 * Do not forget 'tenant.' prefix for key value
 */
class CacheKey
{
    /** @var string */
    const ADMIN_PROFILE = 'tenant.admin_profile';

    /** @var string */
    const TEAM_PROFILES = 'tenant.team_profiles';
}