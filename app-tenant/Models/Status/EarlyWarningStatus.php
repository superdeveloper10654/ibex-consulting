<?php

namespace AppTenant\Models\Status;

class EarlyWarningStatus extends BaseStatus
{
   /** @var string Notified status string */
   const NOTIFIED = 'Notified';
   /** @var int Notified status id */
   const NOTIFIED_ID = 1;
   /** @var string Notified status icon */
   const NOTIFIED_ICON = '<i class="font-size-18 align-middle mdi mdi-file-send-outline"></i>';

   /** @var string Draft status string */
   const DRAFT = 'Drafted';
   /** @var int Draft status id */
   const DRAFT_ID = 2;
   /** @var int Draft status icon */
   const DRAFT_ICON = '<i class="font-size-18 align-middle mdi mdi-file-edit-outline"></i>';

   /** @var string Closed status string */
   const CLOSED = 'Closed';
   /** @var int Closed status id */
   const CLOSED_ID = 3;
   /** @var string Closed status icon */
   const CLOSED_ICON = '<i class="font-size-18 align-middle mdi mdi-file-remove-outline"></i>';

   /** @var string Escalated status string */
   const ESCALATED = ' Escalated';
   /** @var int Escalated status id */
   const ESCALATED_ID = 4;
   /** @var string Escalated status string */
   const ESCALATED_ICON = '<i class="font-size-18 align-middle mdi mdi-scale-balance"></i>';
}
