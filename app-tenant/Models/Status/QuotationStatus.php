<?php

namespace AppTenant\Models\Status;

class QuotationStatus extends BaseStatus
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

   /** @var string Accepted status string */
   const ACCEPTED = 'Implemented';
   /** @var int Accepted status id */
   const ACCEPTED_ID = 3;
   /** @var string Accepted status icon */
   const ACCEPTED_ICON = '<i class="font-size-18 align-middle mdi mdi-file-check-outline"></i>';

   /** @var string Rejected status string */
   const REJECTED = 'Rejected';
   /** @var int Rejected status id */
   const REJECTED_ID = 4;
   /** @var string Rejected status icon */
   const REJECTED_ICON = '<i class="font-size-18 align-middle mdi mdi-file-cancel-outline"></i>';

   /** @var string Closed status string */
   const CLOSED = 'Closed';
   /** @var int Closed status id */
   const CLOSED_ID = 5;
   /** @var string Closed status icon */
   const CLOSED_ICON = '<i class="font-size-18 align-middle mdi mdi-file-send-outline"></i>';
}
