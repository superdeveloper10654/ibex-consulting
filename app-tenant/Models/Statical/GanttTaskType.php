<?php

namespace AppTenant\Models\Statical;

use AppTenant\Models\Status\BaseStatus;

class GanttTaskType extends BaseStatus
{
   /** @var string Project type string */
   const PROJECT = 'Project';
   /** @var string Project type id */
   const PROJECT_ID = 'project';
   /** @var string Project type color */
   const PROJECT_COLOR = '#65c16f';

   /** @var string Task type string */
   const TASK = 'Task';
   /** @var string Task type id */
   const TASK_ID = 'task';
   /** @var string Task type color */
   const TASK_COLOR = '#299cb4';
}
