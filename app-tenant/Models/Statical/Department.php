<?php

namespace AppTenant\Models\Statical;

use AppTenant\Models\Status\BaseStatus;

class Department extends BaseStatus
{
    /** @var string No department status string */
    const NO_DEPARTMENT = '';

    /** @var int No department status id */
    const NO_DEPARTMENT_ID = 0;

    /** @var string Commercial status string */
    const COMMERCIAL = 'Commercial';

    /** @var int Commercial status id */
    const COMMERCIAL_ID = 1;

    /** @var string Non Commercial status string */
    const OPERATIONAL = 'Operational';

    /** @var int Non Commercial status id */
    const OPERATIONAL_ID = 2;
}
