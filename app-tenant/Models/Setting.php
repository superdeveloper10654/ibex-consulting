<?php

namespace AppTenant\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Setting extends BaseModel
{
    const KEY_ORGANISATION_LOGO = 'organisation_logo';
    const KEY_LANDING_IMAGE = 'landing_image';

    protected $fillable = [
        'key',
        'value',
    ];

    /** @var array used for caching values */
    protected static $cached = [];

    /**
     * Get value by key
     * 
     * @param string $key
     * @return mixed
     */
    public static function get($key)
    {
        if (empty(static::$cached[$key])) {
            $row = DB::selectOne("SELECT * FROM settings WHERE `key` = ?", [$key]);
            static::$cached[$key] = $row->value ?? null;
        }
        return static::$cached[$key];
    }

    /**
     * Update/create value by key
     * 
     * @param string $key
     * @param string|int|float $value
     * @return bool
     */
    public static function set($key, $value)
    {
        $row = static::get($key);

        if (!empty($row)) {
            return DB::update("UPDATE settings SET `value` = ?, `updated_at` = NOW() WHERE `key` = ?", [$value, $key]);
        } else {
            return DB::insert("INSERT INTO settings (`key`, `value`, `created_at`, `updated_at`) VALUES (?,?, NOW(), NOW())", [$key, $value]);
        }
    }

    /**
     * Get path for the file by it's key
     * 
     * @param string $key
     * @return string|null
     */
    public static function getPath($key)
    {
        $value = static::get($key);
        return !empty($value) ? (config('path.files.settings') . "/$value") : null;
    }

    /**
     * Get link for the file by it's key
     * 
     * @param string $key
     * @return string|null
     */
    public static function getLink($key)
    {
        $value = static::get($key);
        return !empty($value) ? (tenant_asset(config('path.files.settings') . "/$value")) : null;
    }
}
