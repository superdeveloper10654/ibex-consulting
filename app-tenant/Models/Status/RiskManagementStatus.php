<?php

namespace AppTenant\Models\Status;

class RiskManagementStatus extends BaseStatus
{
   /** @var string Submitted status string */
   const SUBMITTED = 'Notified';
   /** @var int Submitted status id */
   const SUBMITTED_ID = 1;
   /** @var string Submitted status icon */
   const SUBMITTED_ICON = '<i class="font-size-18 align-middle mdi mdi-file-send-outline"></i>';

   /** @var string Draft status string */
   const DRAFT = 'Drafted';
   /** @var int Draft status id */
   const DRAFT_ID = 2;
   /** @var int Draft status icon */
   const DRAFT_ICON = '<i class="font-size-18 align-middle mdi mdi-file-edit-outline"></i>';
}
