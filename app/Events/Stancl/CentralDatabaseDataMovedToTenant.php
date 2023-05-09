<?php

declare(strict_types=1);

namespace App\Events\Stancl;

use Stancl\Tenancy\Events\Contracts\TenantEvent;

class CentralDatabaseDataMovedToTenant extends TenantEvent
{
}
