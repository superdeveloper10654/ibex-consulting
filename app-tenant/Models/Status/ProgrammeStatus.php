<?php

namespace AppTenant\Models\Status;

class ProgrammeStatus extends BaseStatus
{
   /** @var string Accepted status string */
   const ACCEPTED = 'Accepted';
   /** @var int Accepted status id */
   const ACCEPTED_ID = 1;
   /** @var string Accepted status icon */
   const ACCEPTED_ICON = '<i class="font-size-18 align-middle mdi mdi-file-check-outline"></i>';

   /** @var string Draft status string */
   const DRAFT = 'Drafted';
   /** @var int Draft status id */
   const DRAFT_ID = 2;
   /** @var int Draft status icon */
   const DRAFT_ICON = '<i class="font-size-18 align-middle mdi mdi-file-edit-outline"></i>';

   /** @var string Rejected status string */
   const REJECTED = 'Rejected';
   /** @var int Rejected status id */
   const REJECTED_ID = 3;
   /** @var string Rejected status icon */
   const REJECTED_ICON = '<i class="font-size-18 align-middle mdi mdi-file-cancel-outline"></i>';

   /** @var string Submitted status string */
   const SUBMITTED = 'Submitted';
   /** @var int Submitted status id */
   const SUBMITTED_ID = 4;
   /** @var string Submitted status icon */
   const SUBMITTED_ICON = '<i class="font-size-18 align-middle mdi mdi-file-clock-outline"></i>';
}
