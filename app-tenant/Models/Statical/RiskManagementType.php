<?php

namespace AppTenant\Models\Statical;

use AppTenant\Models\Status\BaseStatus;

class RiskManagementType extends BaseStatus
{
   /** @var int crunch-placeholder for files and comments functional */
   const PLACEHOLDER_FOR_FILES_AND_COMMENTS = 9999;

   /** @var string Probability type string */
   const PROBABILITY = 'Probability';
   /** @var int Probability type id */
   const PROBABILITY_ID = 0;

   /** @var string Impact type string */
   const IMPACT = 'Impact';
   /** @var int Impact type id */
   const IMPACT_ID = 1;

   /** @var string Severity type string */
   const SEVERITY = 'Severity';
   /** @var int Severity type id */
   const SEVERITY_ID = 2;
}
