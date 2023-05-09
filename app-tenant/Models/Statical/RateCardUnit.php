<?php

namespace AppTenant\Models\Statical;

use AppTenant\Models\Status\BaseStatus;

class RateCardUnit extends BaseStatus
{
    /** @var string item */
    const ITEM = 'item';

    /** @var int item id */
    const ITEM_ID = 1;

    /** @var string line */
    const LINE = 'line';

    /** @var int line id */
    const LINE_ID = 2;

    /** @var string polygon */
    const POLYGON = 'polygon';

    /** @var int polygon id */
    const POLYGON_ID = 3;

    public static function get($name_or_id, $translate = true)
    {
        return parent::get($name_or_id, false);
    }

    public static function getAll()
    {
        return [
            static::ITEM_ID => static::ITEM,
            static::LINE_ID => static::LINE,
            static::POLYGON_ID => static::POLYGON,
        ];
    }

    public static function lineTypesArr()
    {
        return [
            'solid'     => 'Solid',
            'dotted'    => 'Dotted',
            'dashed'    => 'Dashed',
        ];
    }
}
