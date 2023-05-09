<?php

namespace AppTenant\Models\Status;

use Illuminate\Support\Str;

/*
 * Parent for statuses system. Can be used for autogenerating status id, name, icon.
 * Example of usage for "Completed" status:
 *
 * 
 * In child status class you should specify:
 * const COMPLETED = 'Completed';
 * const COMPLETED_ID = 1;
 * const COMPLETED_ICON = '';
 * 
 * Then it can be called this way (BaseStatus will be replaced with child class): 
 * BaseStatus::get(BaseStatus::COMPLETED)->name/id/icon
 */
class BaseStatus
{
    /**
     * Get status object with translated value
     * 
     * @param int|string $name_or_id
     * @param bool $translate
     * 
     * @return object<id,value>
     */
    public static function get($name_or_id, $translate = true)
    {
        $consts = static::getArray(true);

        if (is_int($name_or_id)) {
            $status = $consts[$name_or_id];
            if ($translate) {
                $status->name = __($status->name);
            }
            return $status;
            
        } else {
            foreach ($consts as $status) {
                if ($name_or_id == $status->name) {
                    if ($translate) {
                        $status->name = __($status->name);
                    }
                    return $status;
                }
            }
        }
    }

    /**
     * Return key => value array of constants by base const name (COMPLETED_ID - where COMPLETED is base)
     * 
     * @param bool $show_nullable_index - show the element when index is null (false)
     * @param int|string|array $exclude statuses
     * 
     * @return array
     */
    public static function getArray($show_nullable_index = false, $exclude = [])
    {
        $ref_class = new \ReflectionClass(static::class);
        $consts = $ref_class->getConstants();
        $exclude = is_array($exclude) ? $exclude : [$exclude];
        $res = [];

        foreach ($consts as $key => $value) {
            if (Str::endsWith($key, '_ID')) {
                $string_key = explode('_ID', $key)[0];

                if (($value !== 0 || ($value === 0 && $show_nullable_index)) && !in_array($value, $exclude)) {
                    $res[$value] = (object) [
                        'id'    => $value,
                        'name'  => $consts[$string_key],
                        'icon'  => $consts["{$string_key}_ICON"] ?? '',
                    ];
                }
            }
        }

        return $res;
    }

    /**
     * If model status
     * @param string $const_name
     * @return bool
     */
    public static function hasConst($const_name)
    {
        $class = static::class;

        return defined("$class::$const_name");
    }
}
