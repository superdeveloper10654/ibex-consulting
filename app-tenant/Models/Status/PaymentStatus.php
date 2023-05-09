<?php

namespace AppTenant\Models\Status;

class PaymentStatus extends BaseStatus
{
    /** @var string Pending status string */
    const PENDING = 'Pending';

    /** @var int Pending status id */
    const PENDING_ID = 1;

    /** @var string Primed status string */
    const PRIMED = 'Primed';

    /** @var int Primed status id */
    const PRIMED_ID = 2;

    /** @var string Certified status string */
    const CERTIFIED = 'Certified';

    /** @var int Certified status id */
    const CERTIFIED_ID = 3;

    public static function get($name_or_id, $translate = false)
    {
        $status = parent::get($name_or_id, $translate);
        $color = 'bg-dark';

        if ($status->id == self::PRIMED_ID) {
            $color = 'bg-warning';
        } else if ($status->id == self::CERTIFIED_ID) {
            $color = 'bg-success';
        }

        // add html badge
        $status->badge = "<span class='badge $color p-2 w-md'>$status->name</span>";

        return $status;
    }
}
