<?php

namespace AppTenant\Models\Status;

class MeasureStatus extends BaseStatus
{
    /** @var string Saved status string */
    const SAVED = 'Saved';

    /** @var int Saved status id */
    const SAVED_ID = 1;

    /** @var string Queried status string */
    const QUERIED = 'Queried';

    /** @var int Queried status id */
    const QUERIED_ID = 2;

    /** @var string Agreed status string */
    const AGREED = 'Agreed';

    /** @var int Agreed status id */
    const AGREED_ID = 3;

    /** @var string Draft status string */
    const DRAFT = 'Draft';

    /** @var int Draft status id */
    const DRAFT_ID = 4;

    /** @var string Submitted status string */
    const SUBMITTED = 'Submitted';

    /** @var int Submitted status id */
    const SUBMITTED_ID = 5;


    public static function get($name_or_id, $translate = false)
    {
        $status = parent::get($name_or_id, $translate);
        $color = 'bg-dark';

        if ($status->id == self::QUERIED_ID) {
            $color = 'bg-warning';
        } else if ($status->id == self::AGREED_ID) {
            $color = 'bg-success';
        }

        // add html badge
        $status->badge = "<span class='badge $color p-2 w-md'>$status->name</span>";

        return $status;
    }
}
