<?php

namespace AppTenant\Models\Status;

class ApplicationStatus extends BaseStatus
{
    /** @var string Submitted status string */
    const SUBMITTED = 'Submitted';

    /** @var int Submitted status id */
    const SUBMITTED_ID = 1;

    /** @var string Not submitted status string */
    const NOT_SUBMITTED = 'Not Submitted';

    /** @var int Not submitted status id */
    const NOT_SUBMITTED_ID = 2;

    /** @var string Draft status string */
    const DRAFT = 'Draft';

    /** @var int Draft status id */
    const DRAFT_ID = 4;

    /** @var string Certified status string */
    const CERTIFIED = 'Certified';

    /** @var int Certified status id */
    const CERTIFIED_ID = 5;

    public static function get($name_or_id, $translate = false)
    {
        $status = parent::get($name_or_id, $translate);
        $color = 'bg-dark';

        if ($status->id == self::SUBMITTED_ID) {
            $color = 'bg-primary';
        } else if ($status->id == self::DRAFT_ID) {
            $color = 'bg-warning';
        }

        // add html badge
        $status->badge = "<span class='badge $color p-2 w-md'>$status->name</span>";

        return $status;
    }
}
