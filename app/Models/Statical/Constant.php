<?php

namespace App\Models\Statical;

class Constant
{
    /** @var string Path for support image */
    const IMG_PATH_PUBLIC_SUPPORT = '/assets/images/svg/help-support.svg';

    /** @var string Just 'me' */
    const ME = 'me';


    /** @var string Action type store */
    const ACTION_STORE = 'store';
    
    /** @var string Action type update */
    const ACTION_UPDATE = 'update';


    /** @var string Type completion date */
    const DATE_TYPE_COMPLETION_DATE = 'completion_date';

    /** @var string Name of Completion date type */
    const DATE_TYPE_COMPLETION_DATE_NAME = 'Completion Date';

    /** @var string Type key date 1 */
    const DATE_TYPE_KEY_DATE_1 = 'key_date_1';

    /** @var string Name of Key Date 1 type */
    const DATE_TYPE_KEY_DATE_1_NAME = 'Key Date 1';

    /** @var string Type key date 2 */
    const DATE_TYPE_KEY_DATE_2 = 'key_date_2';

    /** @var string Name of Key Date 2 type */
    const DATE_TYPE_KEY_DATE_2_NAME = 'Key Date 2';

    /** @var string Type key date 3 */
    const DATE_TYPE_KEY_DATE_3 = 'key_date_3';

    /** @var string Name of Key Date 3 type */
    const DATE_TYPE_KEY_DATE_3_NAME = 'Key Date 3';


    /** @var float Default map marker position (latitude) */
    const DEFAULTS_MAP_MARKER_LAT = 50.67577881920257;

    /** @var float Default map marker position (longitude) */
    const DEFAULTS_MAP_MARKER_LNG = -1.2834913927579148;


    /** @var string Infinity */
    const INFINITY = 'Infinity';
    

    /** @var string No EW option for select */
    const OPTION_NO_EARLY_WARNING = 'No Early Warning';
    
    /** @var string No EW option id for select */
    const OPTION_NO_EARLY_WARNING_ID = 0;


    /** @var string subscription demo */
    const SUBSCRIPTION_DEMO = 'Demo';

    /**
     * Return array of key date types [key => name]
     * @return array
     */
    public static function getDateTypes()
    {
        return [
            static::DATE_TYPE_COMPLETION_DATE   => static::DATE_TYPE_COMPLETION_DATE_NAME,
            static::DATE_TYPE_KEY_DATE_1        => static::DATE_TYPE_KEY_DATE_1_NAME,
            static::DATE_TYPE_KEY_DATE_2        => static::DATE_TYPE_KEY_DATE_2_NAME,
            static::DATE_TYPE_KEY_DATE_3        => static::DATE_TYPE_KEY_DATE_3_NAME,
        ];
    }

    /**
     * Return array of active subscriptions
     * @return array
     */
    public static function activeSubscriptions()
    {
        return [
            static::SUBSCRIPTION_DEMO   => 'Demo',
        ];
    }
}
