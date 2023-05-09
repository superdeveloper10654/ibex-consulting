<?php

namespace AppTenant\Http\Controllers;

use AppTenant\Http\Controllers\BaseController\BaseController;
use AppTenant\Models\Calendar_override;
use AppTenant\Models\gantt_column;
use Illuminate\Http\Request;
use AppTenant\Models\Profile;
use AppTenant\Models\user_programme_link;
use AppTenant\Models\GanttTask;
use AppTenant\Models\Programme;
use App\Models\Statical\Constant;
use AppTenant\Models\Link;
use AppTenant\Models\Statical\GanttTaskType;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Validator;

class TaskController extends BaseController
{
    /** @var string */
    const ACTION_IMPORT_FROM_MICROSOFT_PROJECT = 'action-import-from-microsoft-project';

    public function generateGUID()
    {
        if (function_exists('com_create_guid')) {
            return com_create_guid();
        } else {
            mt_srand((float)microtime() * 10000);
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45); // "-"
            $uuid = substr($charid, 0, 8) . $hyphen
                . substr($charid, 8, 4) . $hyphen
                . substr($charid, 12, 4) . $hyphen
                . substr($charid, 16, 4) . $hyphen
                . substr($charid, 20, 12);
            return $uuid;
        }
    }

    public function addNewKanbanTask($prgId)
    {
        $id = Crypt::decryptString($prgId);
        $upcomingTasks = GanttTask::where('programme_id', $id)->where('parent', 0)->where('progress', 0)->get();
        $ongoingTasks = GanttTask::where('programme_id', $id)->where('parent', 0)->whereNotIn('progress', [0, 1])->get();
        $completedTasks = GanttTask::where('programme_id', $id)->where('parent', 0)->where('progress', 1)->get();
        $assignees = Profile::all();

        $program_data = DB::table('programmes')->where('id', $id)->first();
        $programme_name = 'ADD GANTT CHART';
        if ($program_data != '') {
            $programme_name = $program_data->name;
        }

        $response = user_programme_link::where('user_id', t_profile()->id)->where('programme_id', $id)->get();
        $gantt_column = gantt_column::where('user_id', t_profile()->id)->where('programme_id', $id)->get();
        $resources = DB::table('resources')->where('active', 1)->where('programme_id', $id)->where('parent_id', '!=', 0)->get();

        $groups = DB::table('resources')->where('active', 1)->where('programme_id', $id)->where('parent_id', '=', 0)->get();
        if ($response->isEmpty()) {
            $start = date('Y-m-d', strtotime('-30 days'));
            $end = date('Y-m-d', strtotime('+30 days'));
        } else {
            $start = date('Y-m-d', strtotime($response[0]->date_range_start));
            $end   = date('Y-m-d', strtotime($response[0]->date_range_end));
        }

        $calendar = DB::table('calendars')->where('programme_id', $id)->get();
        $calendar_override = Calendar_override::where('programme_id', $id)->get();


        $data = [
            'programId' => $id,
            'userId' => t_profile()->id,
            'upcomingTasks' => $upcomingTasks,
            'ongoingTasks' => $ongoingTasks,
            'completedTasks' => $completedTasks,
            'date_range_start' => $start,
            'date_range_end' => $end,
            'columns' => $gantt_column,
            'resources' => $resources,
            'calendar' => $calendar,
            'calendar_overrides' => $calendar_override,
            'groups' => $groups,
            'programme_data' => $programme_name,
            'assignees' => $assignees
        ];

        return t_view('kanban-tasks/tasks-kanban', $data);
    }

    public function store(Request $request)
    {
        $this->validateRequest($request);
        $maxId = DB::table('gantt_tasks')->max('id');
        $deadline_date = null;
        $start_date = null;
        $end_date = null;
        $planned_start = null;
        $planned_end = null;

        if (isset($request->deadline) && $request->deadline != null) {
            $deadline_date = date("Y-m-d H:i:s", strtotime($request->deadline));
        }
        if (isset($request->start_date) && $request->start_date != null) {
            $start_date = date("Y-m-d H:i:s", strtotime($request->start_date));
        }
        if (isset($request->planned_start) && $request->planned_start != null) {
            $planned_start = date("Y-m-d H:i:s", strtotime($request->planned_start));
        }
        if (isset($request->planned_end) && $request->planned_end != 'undefined') {
            $planned_end = date("Y-m-d H:i:s", strtotime($request->planned_end));
            // $planned_end = substr_replace($planned_end, '23:59:59', -8, 8);
        }
        if (isset($request->end_date) && $request->end_date != null) {
            $end_date = date("Y-m-d H:i:s", strtotime($request->picker_end_date));
            // $end_date = substr_replace($end_date, '23:59:59', -8, 8);
        }
        if ($request->type == 'project') {
            $is_summary = 1;
        } else {
            $is_summary = 0;
        }
        $insertData = array(
            "guid" => $this->generateGUID(),
            "programme_id" => $request->programme_id,
            "text" => $request->text,
            "start_date" => $start_date,
            "end_date" => $end_date,
            "duration" => $request->duration,
            "baseline_start" => $planned_start,
            "baseline_end" => $planned_end,
            "deadline" => $deadline_date,
            "progress" => $request->has("progress") ? $request->progress : 0,
            "parent" => $request->parent,
            "sortorder" => $maxId + 1,
            "type" => $request->type,
            "resource_id" => $request->resource_id,
            "resource_group_id" => $request->resource_group_id,
            "calendar_id" => $request->calendar_id,
            "comment" => $request->comment,
            "is_summary" => $is_summary,
            "color" => $request->has("color") ? $request->color : "#299cb4"
        );
        $request->duration_worked && $insertData["duration_worked"] = $request->duration_worked;
        $taskId = DB::table('gantt_tasks')->insertGetId(
            $insertData
        );
        $created = time();
        $aux_data = "Starts " . date("D d M H:i", strtotime($request->start_date));
        $guid = $this->generateGUID();
        $secondary_object_guid = '';
        $ui_string = "added" . " " . $request->type . " <span style='font-weight: bold;'>'" . $request->text . "'<span>";

        $values = array('programme_id' => $request->programme_id, 'gantt_data' => $request->data, 'user_id' => $request->user_id, 'created' => $created, 'action' => 'added', 'type' => $request->type, 'primary_object_guid' => $request->guid, 'secondary_object_guid' => $secondary_object_guid, 'aux_data' => $aux_data, 'guid' => $guid, 'ui_string' => $ui_string, 'to_finalise' => 1);
        $version_id = DB::table('gantt_versions')->insertGetId($values);

        $id = $request->parent != 0 ? $request->parent : $taskId;
        $task = GanttTask::where('id', $id)->with('assignees')->first();
        $subTasks = $task->subTasks()->withCount('subTasks')->get();
        return response()->json([
            "action" => "inserted",
            "tid" => $taskId,
            "processed" => true,
            "version_id" => $version_id,
            "save_time" => $created,
            "task" => $task,
            "subTasks" => $subTasks
        ]);
    }

    public function getTaskDetails($id)
    {
        $taskDetails = GanttTask::find($id);
        $assignees = $taskDetails->assignees()->allRelatedIds();
        $subTasks = $taskDetails->subTasks()->withCount('subTasks')->get();


        return response()->json([
            "success" => "success",
            "subTasks" => $subTasks,
            "taskDetails" => $taskDetails,
            "assignees" => $assignees
        ]);
    }

    public function destroy($id)
    {

        $task = GanttTask::findOrFail($id);

        if ($task) {

            if (count($task->subTasks) > 0) {
                return response()->json([
                    "error" => "Delete the sub tasks first!"
                ], 400);
            }

            $parent = $task->parent()->with('assignees')->first();

            $task->delete();

            return response()->json([
                "action" => "deleted",
                "task" => $parent
            ]);
        }

        return response()->json([
            "error" => "task not found"
        ], 404);
    }

    public function update($id, Request $request)
    {
        $this->validateRequest($request);

        $deadline_date = null;
        $start_date = null;
        $end_date = null;
        $planned_start = null;
        $planned_end = null;
        if ($request->deadline != null) {
            $deadline_date = date("Y-m-d H:i:s", strtotime($request->deadline));
        }
        if ($request->start_date != null) {
            $start_date = date("Y-m-d H:i:s", strtotime($request->start_date));
        }
        if ($request->planned_start != null) {
            if ($request->planned_start != 'undefined') {
                $planned_start = date("Y-m-d H:i:s", strtotime($request->planned_start));
            }
        }

        if ($request->planned_end != 'undefined') {
            $planned_end = date("Y-m-d H:i:s", strtotime($request->planned_end));
            // $planned_end = substr_replace($planned_end, '23:59:59', -8, 8);
        }
        if (isset($request->end_date) && $request->end_date != null) {
            $end_date = date("Y-m-d H:i:s", strtotime($request->end_date));
            // $end_date = substr_replace($end_date, '23:59:59', -8, 8);
        }
        if ($request->type == 'project') {
            $is_summary = 1;
        } else {
            $is_summary = 0;
        }

        $insertData = array(
            "text" => $request->text,
            "start_date" => $start_date,
            "end_date" => $end_date,
            "baseline_start" => $planned_start,
            "baseline_end" => $planned_end,
            "deadline" => $deadline_date,
            "duration" => $request->duration,
            "progress" => $request->has("progress") ? $request->progress : 0,
            "parent" => $request->parent,
            "type" => $request->type,
            "resource_id" => $request->resource_id,
            "resource_group_id" => $request->resource_group_id,
            "calendar_id" => $request->calendar_id,
            "comment" => $request->comment,
            "is_summary" => $is_summary,
            "color" => $request->has("color") ? $request->color : "#299cb4"
        );
        // return $insertData;
        // return false;
        $array_key = array('text', 'start_date', 'end_date', 'baseline_start', 'baseline_end', 'deadline', 'progress', 'calendar_id', 'type', 'group', 'resource_id', 'programme_id', 'resource_group_id');

        $tr = DB::table('gantt_tasks')->where('id', $id)->limit(1)->get();
        $tr = $tr->toArray();
        $testBefore = [];
        $previousTaskText = '';
        foreach ($tr as $key => $value) {
            foreach ($value as $key1 => $value1) {

                if ($key1 == 'start_date') {
                    $testBefore['start_date'] = $value->start_date != null ? date('Y-m-d', strtotime($value->start_date)) : '';
                } elseif ($key1 == 'end_date') {
                    $testBefore['end_date'] = $value->end_date != null ? date('Y-m-d', strtotime($value->end_date)) : '';
                } elseif ($key1 == 'baseline_start') {
                    $testBefore['baseline_start'] = $value->baseline_start != null ? date('Y-m-d', strtotime($value->baseline_start)) : '';
                } elseif ($key1 == 'baseline_end') {
                    $testBefore['baseline_end'] = $value->baseline_end != null ? date('Y-m-d', strtotime($value->baseline_end)) : '';
                } elseif ($key1 == 'deadline') {
                    $testBefore['deadline'] = $value->deadline != null ? date('Y-m-d', strtotime($value->deadline)) : '';
                } elseif ($key1 == 'resource_group_id') {
                    $testBefore['resource_group_id'] = $value->resource_group_id;
                } else {
                    $testBefore[$key1] = $value1;
                }

                if ($key1 == 'text') {
                    $previousTaskText = $value->text;
                }
            }
        }
        $afterForm = array(
            "text" => $request->text,
            "start_date" => $request->start_date != null ? date("Y-m-d", strtotime($request->start_date)) : '',
            "end_date" => $request->end_date != null ? date("Y-m-d", strtotime($request->end_date)) : '',
            "baseline_start" => $request->planned_start != null ? date("Y-m-d", strtotime($request->planned_start)) : '',
            "baseline_end" => $request->planned_end != 'undefined' ? date("Y-m-d", strtotime($request->planned_end)) : '',
            "deadline" => $request->deadline_date != null ? date("Y-m-d", strtotime($request->deadline_date)) : '',
            "duration" => $request->duration,
            "progress" => $request->has("progress") ? $request->progress : 0,
            "parent" => $request->parent,
            "type" => $request->type,
            "resource_id" => $request->resource_id,
            "resource_group_id" => $request->resource_group_id,
            "calendar_id" => $request->calendar_id,
            "comment" => $request->comment,
            "programme_id" => $request->programme_id,
        );
        $changeString = '';
        foreach ($afterForm as $key => $value) {

            $name = str_replace('_', ' ', $key);
            $value = $value;
            if ($value != $testBefore[$key]) {
                $mismatchValue = $value;
                $newMismatchValue = $testBefore[$key];
                if ($mismatchValue == '') {
                    $mismatchValue = 'not set';
                }
                $changeString .= $name . " was " . $newMismatchValue . " and is now " . $mismatchValue . "<br>";
            }
        }
        $finalChangeString = substr($changeString, 0, -4);

        $created = time();
        $guid = $request->guid;
        $secondary_object_guid = '';
        $ui_string = "edited" . " " . "task" . " <span style='font-weight: bold;'>'" . $previousTaskText . "'<span>";

        $values = array('programme_id' => $request->programme_id, 'gantt_data' => $request->data, 'user_id' => $request->user_id, 'created' => $created, 'action' => 'edited', 'type' => 'task', 'primary_object_guid' => $guid, 'secondary_object_guid' => $secondary_object_guid, 'aux_data' => $finalChangeString, 'guid' => $this->generateGUID(), 'ui_string' => $ui_string, 'to_finalise' => 0);
        $version_id = '';
        $version_id = DB::table('gantt_versions')->insertGetId($values);

        $update = DB::table('gantt_tasks')->where('id', $id)->limit(1)->update($insertData);
        if ($request->has("target")) {
            $this->updateOrder($id, $request->target);
        }


        $id = $request->parent != 0 ? $request->parent : $id;
        $task = GanttTask::where('id', $id)->with('assignees')->first();
        $subTasks = $task->subTasks()->withCount('subTasks')->get();
        return response()->json([
            "action" => "updated",
            "task" => $task,
            "subTasks" => $subTasks
        ]);
    }

    private function updateOrder($taskId, $target)
    {
        $nextTask = false;
        $targetId = $target;

        if (strpos($target, "next:") === 0) {
            $targetId = substr($target, strlen("next:"));
            $nextTask = true;
        }

        if ($targetId == "null")
            return;

        // $targetOrder = DB::find($targetId)->sortorder;
        $targetOrder = DB::table('gantt_tasks')->find($targetId)->sortorder;


        if ($nextTask)
            $targetOrder++;

        DB::table('gantt_tasks')->where("sortorder", ">=", $targetOrder)->increment("sortorder");

        $updatedTask = DB::table('gantt_tasks')->find($taskId);
        // $updatedTask->sortorder = $targetOrder;
        // $updatedTask->save();

        $insertData = array(
            "sortorder" => $targetOrder
        );
        $update = DB::table('gantt_tasks')->where('id', $taskId)->limit(1)->update($insertData);
    }

    public function updateTaskAttribute(Request $request, $id)
    {
        $this->validateRequest($request, Constant::ACTION_UPDATE);
        $task = GanttTask::with('assignees')->find($id);

        if ($task) {

            $update = DB::table('gantt_tasks')->where('id', $id)->limit(1)->update($request->all());

            $task = GanttTask::where('id', $id)->with('assignees')->first();
            $task->parent != 0 && $task = $task->parent()->with('assignees')->first();

            $subTasks = $task->subTasks()->withCount('subTasks')->get();


            return response()->json([
                "success" => "updated",
                "task" => $task,
                "subTasks" => $subTasks,
            ]);
        }

        return response()->json([
            "success" => false,
            "error" => 'Task not found',
        ], 404);
    }

    public function updateAssignees(Request $request, $id)
    {
        $request->validate([
            'assignees' => 'int|exists:profiles,id'
        ]);
        $task = GanttTask::where('id', $id)->with('assignees')->first();

        if ($task) {

            $update = GanttTask::find($id)->assignees()->sync($request->assignees);

            $task = GanttTask::where('id', $id)->with('assignees')->first();
            $task->parent != 0 && $task = $task->parent()->with('assignees')->first();

            $subTasks = $task->subTasks()->withCount('subTasks')->get();

            return response()->json([
                "success" => "updated",
                "task" => $task,
                "subTasks" => $subTasks,
            ]);
        }

        return response()->json([
            "success" => false,
            "error" => 'Task not found',
        ], 404);
    }

    public function save(Request $request)
    {
        $this->validateRequest($request);

        $data = [
            'guid' => $this->generateGUID(),
            'id' => $request->id,
            'type' => $request->type?$request->type:"task",
            'programme_id' => $request->programme_id,
            'parent' => $request->parent,
            'text' => $request->text,
            'resource_group_id' => $request->resource_group_id ? $request->resource_group_id : 0,
            'resource_id' => $request->resource_id ? $request->resource_id : '0',
            'progress' => $request->progress,
            'color' => $request->color?$request->color:"#299cb4",
            'calendar_id' => $request->calendar_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'baseline_start' => $request->planned_start,
            'baseline_end' => $request->planned_end,
            'comment' => $request->comment?$request->comment:"",
        ];
        $where = GanttTask::where('id', $request->id);
        if ($where->exists()) {
            $where->update($data);
            return $this->jsonSuccess('Updated');
        } else {
            if($data['color'] == null){
                $data['color'] = "#299cb4";
            }
            if($data['baseline_end'] == date("Y-m-d")){
                $data['baseline_end'] = $data['end_date'];
            }
            $last_db_id = (int) (is_null(DB::table('gantt_tasks')->get()->last()) ? 0 : (DB::table('gantt_tasks')->get()->last()->id));
            $data['id'] = $last_db_id + 1;
            $id = GanttTask::create($data)->id;
            return $this->jsonSuccess('Saved');
        }
    }

    /**
     * @param Request $request
     * @return object
     */
    public function importTasksFromMicrosoftProject(Request $request, $programme_id)
    {
//        $this->validateRequest($request, static::ACTION_IMPORT_FROM_MICROSOFT_PROJECT);
        $programme = Programme::findOrFail($programme_id);
        GanttTask::where('programme_id', $programme_id)->delete();
        $data = $request->all();
        $import_task_ids = array_map(function($task) { return $task['id']; }, $data['tasks']);
        $min_import_id = min($import_task_ids);
        $last_db_id = (int) (is_null(DB::table('gantt_tasks')->get()->last()) ? 0 : (DB::table('gantt_tasks')->get()->last()->id));
        $result_data = FacadesDB::transaction(function() use($data, $programme, $last_db_id) {
            usort($data['tasks'], function($a, $b) { return $a['parent'] - $b['parent']; });
            $tasks = [];
            $links = [];
            if (!empty($data['tasks'])) {
                foreach ($data['tasks'] as $task_raw) {
                    $task_has_subtasks = false;

                    for ($i = 0; $i < count($data['tasks']); $i++) {
                        if ($data['tasks'][$i]['parent'] == $task_raw['id']) {
                            $task_has_subtasks = true;
                            break;
                        }
                    }

                    $type = $task_has_subtasks ? GanttTaskType::PROJECT_ID : GanttTaskType::TASK_ID;
                    $color = $type == GanttTaskType::PROJECT ? GanttTaskType::PROJECT_COLOR : GanttTaskType::TASK_COLOR;

                    if($data['type'] =="baseline") {
                        $task = GanttTask::create([
                            'id' => $task_raw['id'] + $last_db_id,
                            'guid' => $task_raw['guid'] ?? $this->generateGUID(),
                            'type' => $task_raw['type'],
//                            'programme_id' => $task_raw['programme_id'],
                            'programme_id' => $programme->id,
                            'parent' => ($task_raw['parent'] == 0 ? $task_raw['parent'] : ($task_raw['parent'] + $last_db_id)),
                            'text' => $task_raw['text'],
                            'resource_group_id' => $task_raw['resource_group_id'] ?? 0,
                            'resource_id' => $task_raw['resource_id'] ?? 0,
                            'progress' => $task_raw['progress'] ?? 0,
                            'duration' => $task_raw['duration'] ?? 0,
                            'calendar_id' => $task_raw['calendar_id'] ?? 0,
                            'start_date' => $task_raw['start_date'] ?? new date(),
                            'baseline_start' => $task_raw['planned_start'] ?? new date(),
                            'end_date' => $task_raw['end_date'] ?? new date(),
                            'baseline_end' => $task_raw['planned_end'] ?? new date(),
                            'color' => $task_raw['color'],
                        ]);
                    } else {
                        $task = GanttTask::create([
                            'id' => $task_raw['id'] + $last_db_id,
                            'guid' => $task_raw['guid'] ?? $this->generateGUID(),
                            'type' => $type,
                            'programme_id' => $programme->id,
                            'parent' => ($task_raw['parent'] == 0 ? $task_raw['parent'] : ($task_raw['parent'] + $last_db_id)),
                            'text' => $task_raw['text'] ? $task_raw['text'] : '',
                            'resource_group_id' => $task_raw['resource_group_id'],
                            'resource_id' => $task_raw['resource_id'],
                            'progress' => $task_raw['progress'],
                            'duration' => $task_raw['duration'],
                            'calendar_id' => $task_raw['calendar_id'],
                            'start_date' => $task_raw['$raw']['Start'],
                            'baseline_start' => $task_raw['$raw']['Start'],
                            'end_date' => $task_raw['$raw']['Finish'],
                            'baseline_end' => $task_raw['$raw']['Finish'],
                            'color' => $color,
                        ]);
                    }

                    $tasks[] = [
                        'id'                => $task->id,
                        'guid'              => $task->guid,
                        'type'              => $task->type,
                        'programme_id'      => $task->programme_id,
                        'parent'            => $task->parent,
                        'text'              => $task->text,
                        'resource_group_id' => $task->resource_group_id,
                        'resource_id'       => $task->resource_id,
                        'progress'          => $task->progress,
                        'duration'          => $task->duration,
                        'calendar_id'       => $task->calendar_id,
                        'start_date'        => $task->start_date,
                        'planned_start'     => $task->baseline_start,
                        'end_date'          => $task->end_date,
                        'planned_end'       => $task->baseline_end,
                        'color'             => $task->color,
                    ];
                }
            }

            if (!empty($data['links'])) {
                foreach ($data['links'] as $link) {
                    $link = Link::create([
                        'type'      => $link['type'],
                        'source'    => $link['source'] - $last_db_id,
                        'target'    => $link['target'] - $last_db_id,
                        'lag'       => $link['lag'],
                    ]);

                    $links[] = $link->only(['id', 'type', 'source', 'target', 'lag']);
                }
            }

            return (object) [
                'data'  => $tasks,
                'links' => $links,
            ];
        });
        if($data['type'] == "baseline") {
//            if ($data['index'] == 0) {
//                return $this->jsonSuccess();
//            }
            return $this->jsonSuccess('Baseline changed successfully', $result_data);
        }
        return $this->jsonSuccess('Data imported successfully', $result_data);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'int|exists:gantt_tasks,id'
        ]);
        GanttTask::where('id', $request->id)->delete();

        return $this->jsonSuccess('Deleted');
    }

    public function validateRequest(Request $request, $action = Constant::ACTION_STORE)
    {
        if ($action == static::ACTION_IMPORT_FROM_MICROSOFT_PROJECT) {
            $rules = [
                'tasks.*.id'                => 'required|int|max:2147483646',
                'tasks.*.parent'            => 'required|int',
                'tasks.*.text'              => 'required|string|max:255',
                'tasks.*.resource_group_id' => 'required|int|max:2147483646',
                'tasks.*.resource_id'       => 'required|string|max:255',
                'tasks.*.progress'          => 'required|numeric|max:9999999',
                'tasks.*.calendar_id'       => 'required|int|exists:calendars,id',
                'tasks.*.$raw.Start'        => 'required|date',
                'tasks.*.$raw.Finish'       => 'required|date',
                'tasks.*.duration'          => 'required|numeric|max:999999',

                'links.*.type'      => 'int|in:0,1,2,3',
                'links.*.source'    => 'int|max:2147483646',
                'links.*.target'    => 'int|max:2147483646',
                'links.*.lag'       => 'int|max:2147483646'
            ];
        } else {
            $rules = [
                'id'                => 'int',
                'guid'              => 'string|max:255',
                'type'              => 'string|max:255',
                'programme_id'      => 'int|exists:programmes,id',
                'parent'            => 'int|max:2147483646',
                'text'              => 'string|max:255',
                'resource_group_id' => 'int|max:2147483646',
                'resource_id'       => 'string|max:255',
                'progress'          => 'numeric|max:9999999',
                'color'             => 'string|max:20',
                'calendar_id'       => 'int|exists:calendars,id',
                'start_date'        => 'date',
                'end_date'          => 'date',
                'baseline_start'    => 'string|max:255',
                'baseline_end'      => 'string|max:255',
                'deadline'          => 'date',
                'planned_start'     => 'date',
                'planned_end'       => 'date',
                'duration'          => 'string|max:11',
                'comment'           => 'string|max:10000',
            ];

            if ($action == Constant::ACTION_STORE) {
                $rules = array_merge($rules, [
                ]);
            } else if ($action == Constant::ACTION_UPDATE) {
                $rules = array_merge($rules, [
                ]);
            }
        }

        Validator::make($request->all(), $rules)->validate();
    }
}
