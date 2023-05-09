<?php

namespace AppTenant\Models\Statical;

use AppTenant\Models\Status\BaseStatus;

class WorkflowCategory extends BaseStatus
{
    /** @var string operations */
    const OPERATIONS = 'Operations';

    /** @var int operations id */
    const OPERATIONS_ID = 1;

    /** @var string Risk Management */
    const RISK_MANAGEMENT = 'Risk Management';

    /** @var int Risk Management id */
    const RISK_MANAGEMENT_ID = 2;

    /** @var string Compensation Events */
    const COMPENSATION_EVENTS = 'Compensation Events';

    /** @var int Compensation Events id */
    const COMPENSATION_EVENTS_ID = 3;

    /** @var string Quanlity Control */
    const QUALITY_CONTROL = 'Quanlity Control';

    /** @var int Quanlity Control id */
    const QUALITY_CONTROL_ID = 4;

    /** @var string Payments */
    const PAYMENTS = 'Payments';

    /** @var int Payments id */
    const PAYMENTS_ID = 5;
}
