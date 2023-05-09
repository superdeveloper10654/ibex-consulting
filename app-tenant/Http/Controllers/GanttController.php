<?php

namespace AppTenant\Http\Controllers;

use AppTenant\Http\Controllers\BaseController\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use AppTenant\Models\user_programme_link;
use AppTenant\Models\gantt_column;
use AppTenant\Models\Calendar_override;
use AppTenant\Models\Programme;
use AppTenant\Models\GanttTask;
use AppTenant\Models\ContractWorkCondition;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class GanttController extends BaseController
{
    public $programme_id;

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

    public function show($id)
    {
        $this->programme_id = Crypt::decryptString($id);
        $programId  = Crypt::decryptString($id);

        if (t_profile()->isContractor()) {
            $programme = Programme::whereСontractor(t_profile()->id)->where('id', $programId)->first();
        } else if (t_profile()->isSubcontractor()) {
            $programme = Programme::whereSubcontractor(t_profile()->id)->where('id', $programId)->first();
        } else {
            $programme = Programme::where('id', $programId)->first();
        }

        if (empty($programme)) {
            abort(404);
        }

        $response = user_programme_link::where('programme_id', $programId)->get();
        $gantt_column = gantt_column::where('programme_id', $programId)->where('user_id', t_profile()->id)->get();
        $resources = DB::table('resources')->where('active', 1)->where('programme_id', $programId)->where('parent_id', '!=', 0)->get();

        $groups = DB::table('resources')->where('active', 1)->where('programme_id', $programId)->where('parent_id', '=', 0)->get();
        if ($response->isEmpty()) {
            $start = date('Y-m-d', strtotime('-30 days'));
            $end = date('Y-m-d', strtotime('+30 days'));
        } else {
            $start = date('Y-m-d', strtotime($response[0]->date_range_start));
            $end   = date('Y-m-d', strtotime($response[0]->date_range_end));
        }
        $calendars = DB::table('calendars')->where('programme_id', $programId)->get();
        $calendar_override = Calendar_override::where('programme_id', $programId)->get();
        $contract_id = $programme['contract_id'];
        $contract_work_condition = ContractWorkCondition::where('contract_id', $contract_id)->get();
        $contract_key_date_name = array();
        $contract_key_date = array();
        if($contract_work_condition){
            foreach ($contract_work_condition as $key) {
                array_push($contract_key_date_name, $key->condition);
                array_push($contract_key_date, $key->key_date);
            }
        }
        $data = [
            'date_range_start' => $start,
            'date_range_end' => $end,
            'columns' => $gantt_column,
            'resources' => $resources,
            'calendars' => $calendars,
            'calendar_overrides' => $calendar_override,
            'group' => $groups,
            'programme' => $programme,
            'contract_key_date_name' => isset($contract_key_date_name)?$contract_key_date_name:null,
            'contract_key_date' => isset($contract_key_date)?$contract_key_date:null
        ];

        // return $data;
        return t_view('gantt.show', compact('data'));
    }

    public function getresources(Request $request)
    {
        $request->validate(['programme_id' => 'required|int|exists:programmes,id']);
        $programme_id = $request->programme_id;

        $resources = DB::table('resources')->where('active', 1)->where('programme_id', $programme_id)->get();
        $parent = [];
        $child_parent = [];
        foreach ($resources as $key) {
            if ($key->parent_id == 0) {
                $parent[] = array("id" => $key->id, "name" => $key->name);
            }
        }
        foreach ($resources as $key) {
            if ($key->parent_id != 0) {
                foreach ($parent as $key1) {

                    if ($key->parent_id == $key1['id']) {
                        $child_parent[] = array("id" => $key->id, "name" => $key->name, 'parent_name' => $key1['name'], 'unit_cost' => $key->unit_cost);
                    }
                }
            }
        }
        $payload = array("resources" => $resources, "parent" => $parent, "child_parent" => $child_parent);
        error_log(json_encode($payload));
        return $payload;
        echo json_encode($payload);
    }

    public function SaveGroup(Request $request)
    {
        $dataarray = $request->data;
        $groupId = 0;
        if($request->type) {
            DB::table('resources')->where('programme_id', $request->programme_id)->update(['active' => 0]);
            if($dataarray) {
                $values = array('name' => 'New Resource Group', 'parent_id' => 0, 'active' => 1, 'calendar_id' => '0', 'programme_id' => $request->programme_id);
                $groupId = DB::table('resources')->insertGetId($values);
                for ($i = 0; $i < count($dataarray); $i += 5) {
                    $values = array('name' => $dataarray[$i + 1]['value'], 'parent_id' => $groupId, 'active' => 1, 'calendar_id' => $dataarray[$i + 3]['value'], 'programme_id' => $request->programme_id, 'unit_cost' => "0");
                    DB::table('resources')->insert($values);
                }
            }
            return response()->json(['success' => $groupId]);
        }
        for ($i = 0; $i < count($dataarray); $i += 3) {
            if ($dataarray[$i + 1]['value'] != '') {
                DB::table('resources')->where('id', $dataarray[$i + 1]['value'])->update(['name' => $dataarray[$i]['value'], 'calendar_id' => $dataarray[$i + 2]['value']]);
            } else {
                $values = array('name' => $dataarray[$i]['value'], 'parent_id' => 0, 'active' => 1, 'calendar_id' => $dataarray[$i + 2]['value'], 'programme_id' => $request->programme_id);
                DB::table('resources')->insert($values);
            }
        }
        return response()->json(['success' => 'Group Updated Successfully']);
    }

    public function EditGroup(Request $request)
    {
        $request->validate(['id' => 'required|int|exists:resources,id']);
        $resources = DB::table('resources')->where('id', $request->id)->get();
        $payload = array("resources" => $resources);
        echo json_encode($payload);
    }

    public function DeleteGroup(Request $request)
    {
        $request->validate(['id' => 'required|int|exists:resources,id']);
        DB::table('resources')->where('id', $request->id)->update(['active' => 0]);
        return response()->json(['success' => 'Group Deleted Successfully']);
    }

    public function createresourceitem(Request $request)
    {
        $request->validate([
            'group'         => 'required|int|max:2147483646',
            'item_name'     => 'required|string|max:255',
            'calendar_id'   => 'required|int|max:2147483646',
            'unit_cost'     => 'required|numeric|max:9999999',
            'programme_id'  => 'required_without:id|int|exists:programmes,id'
        ]);
        if ($request->id != '') {
            DB::table('resources')->where('id', $request->id)->update(['name' => $request->item_name, 'parent_id' => $request->group, 'calendar_id' => $request->calendar_id, 'unit_cost' => $request->unit_cost]);
            return response()->json(['success' => 'Resource item Updated Successfully']);
        } else {
            $values = array('name' => $request->item_name, 'parent_id' => $request->group, 'active' => 1, 'calendar_id' => $request->calendar_id, 'programme_id' => $request->programme_id, 'unit_cost' => $request->unit_cost);
            DB::table('resources')->insert($values);
            return response()->json(['success' => 'Resource item Create Successfully']);
        }
    }

    public function inflight_progress_update(Request $request)
    {
        $request->validate([
            'task_id'   => 'required|string|max:191',
            'percent'   => 'required|int|max:100',
        ]);
        $task_id = $request->task_id;
        $percent = $request->percent;
        $insert = array('task_id' => $task_id, 'progress' => $percent, 'datetime_recorded' => date('Y-m-d H:i:s'), 'date_recorded' => date('Y-m-d'));
        DB::table('gantt_task_process')->insert($insert);
        $payload = array("processed" => true);
        echo json_encode($payload);
    }

    public function snapshot_gantt(Request $request)
    {
        $created = time();
        $id = $request->id;
        $programme_id = $request->programme_id;
        $data = json_encode(array('data' => GanttTask::where('programme_id', $programme_id)->get(), 'links' => DB::table('links') ->get()));
        $guid = $this->generateGUID();
        $primary_object_guid = $request->primary_guid;
        $secondary_object_guid = $request->secondary_guid;
        $action_type = $request->action_type;
        $type = $request->type;
        $aux_data = $request->info;
        $afterForm = $request->afterForm;
        $testBefore = $request->testBefore;
        $changeString = $request->changeString;
        $task_text = $request->task_text;
        $ui_string = "";
        $to_finalise = "0";
        $array_key = array('text', 'start_date', 'end_date', 'baseline_start', 'baseline_end', 'deadline', 'progress', 'calendar_id', 'type', 'group', 'resource_id', 'programme_id');
        $newafterform = [];
        if ($afterForm) {
            foreach ($afterForm as $key => $value) {
                if (in_array($key, $array_key)) {
                    $newafterform[$key] = $value;
                }
            }
            foreach ($newafterform as $key => $value) {
                $name = $key;
                $value = $value;
                if ($key == 'group') {
                    $key = 'resource_group_id';
                }
                if ($value != $testBefore[$key]) {
                    $val1 = $value;
                    $val2 = $afterForm[$key];
                    if ($val1 == '') {
                        $val1 = 'not set';
                    }
                    $changeString .= $name . " was " . $val1 . " and is now " . $val2 . "<br>";
                }
            }
//            $finalChangeString = substr($changeString, 0, -4);
        }
        if ($type == "task") {
            $taskData = DB::table('gantt_tasks')->where('id', $id)->get();

//            $to_finalise = "0";
            if ($action_type == "added") {
                $to_finalise = "1";
                $ui_string = $action_type . " " . $type . " <span>'" . $task_text . "'<span>";
            } else if ($action_type == "edited") {
                $to_finalise = "0";
                 $ui_string = $action_type . " " . $type . " <span>'" . $taskData[0]->text . "'<span>";
            } else if ($action_type == "deleted") {
                $to_finalise = "0";
                $ui_string = $action_type . " " . $type . " <span>'" . $taskData[0]->text . "'<span>";
            } else {
                $to_finalise = "0";
//                $ui_string = $action_type . " " . $type;
                $ui_string = "change task duration.";
            }
        } else if ($type == "link") {
            $to_finalise = "0";
            // Get task name as of now
            $task_ui_primary = DB::table('gantt_tasks')->where('id', $primary_object_guid)->get();
            $task_ui_secondary = DB::table('gantt_tasks')->where('id', $secondary_object_guid)->get();
            $str_type = "";
            switch ($id) {
                case 0:
                    $str_type = "FS";
                    break;
                case 1:
                    $str_type = "SS";
                    break;
                case 2:
                    $str_type = "FF";
                    break;
                case 3:
                    $str_type = "SF";
                    break;
            }
            $ui_string = $action_type . " a " . $str_type . " dependency from <span>'" . $task_ui_primary['0']->text . "'<span> to <span>'" . $task_ui_secondary['0']->text . "'<span>";
        } else {
            $to_finalise = "1";
            $ui_string = $action_type . " data from " . " <span>'" . $task_text . "'<span>";
//            return response()->json(['success' => 'Import']);
        }

        $values = array('programme_id' => $programme_id, 'gantt_data' => $data, 'user_id' => t_profile()->id, 'created' => $created, 'action' => $action_type, 'type' => $type, 'primary_object_guid' => $primary_object_guid, 'secondary_object_guid' => $secondary_object_guid, 'aux_data' => $aux_data, 'guid' => $guid, 'ui_string' => $ui_string, 'to_finalise' => $to_finalise);
        $version_id = DB::table('gantt_versions')->insertGetId($values);
        $payload = array("processed" => true, "version_id" => $version_id, "save_time" => $created);

        echo json_encode($payload);
    }

    protected function deletetask(Request $request)
    {
        $created = time();
        $guid = $request->primary_guid;
        $secondary_object_guid = '';
        $ui_string = "deleted" . " " . "task" . " <span style='font-weight: bold;'>'" . $request->task_text . "'<span>";

        $values = array('programme_id' => $request->programme_id, 'gantt_data' => $request->gantt_data, 'user_id' => t_profile()->id, 'created' => $created, 'action' => 'deleted', 'type' => 'task', 'primary_object_guid' => $guid, 'secondary_object_guid' => $secondary_object_guid, 'aux_data' => '', 'guid' => $this->generateGUID(), 'ui_string' => $ui_string, 'to_finalise' => 0);
        $version_id = DB::table('gantt_versions')->insertGetId($values);

        DB::table('gantt_tasks')->where('id', $request->task_id)->where('programme_id', $request->programme_id)->update(['active' => 0]);
        $payload = array("processed" => true, "version_id" => $version_id, "save_time" => $created);
        echo json_encode($payload);
    }

    protected function set_ui_order(Request $request)
    {
        $data = json_decode($request->data, true);
        foreach ($data as $order) {
            $index = $order['index'];
            $id = $order['id'];
            DB::table('gantt_tasks')->where('programme_id', $request.programme_id)->update(['order_ui' => $index]);
        }
    }

    public function get($id)
    {
        $taskData = DB::table('gantt_tasks')->where('programme_id', $id)->where('active', 1)->whereNull('deleted_at')->orderBy('sortorder')->get();
        $task = [];
        foreach ($taskData as $key) {
            $task[] = [
                'id' => $key->id,
                'guid' => $key->guid,
                'parent' => $key->parent,
                'programme_id' => $key->programme_id,
                'text' => $key->text,
                'start_date' => ($key->start_date != '' ? date('Y-m-d H:i:s', strtotime($key->start_date)) : ''),
                'end_date' => ($key->end_date != '' ? date('Y-m-d H:i:s', strtotime($key->end_date)) : ''),
                'position' => $key->position,
                'planned_start' => ($key->baseline_start != '' ? date('Y-m-d H:i:s', strtotime($key->baseline_start)) : ''),
                'planned_end' => ($key->baseline_end != '' ? date('Y-m-d H:i:s', strtotime($key->baseline_end)) : ''),
                'baseline_progress' => $key->baseline_progress,
                'deadline' => ($key->deadline != '' ? date('Y-m-d H:i:s', strtotime($key->deadline)) : ''),
                'duration' => null, // $key->duration,
                'duration_unit' => $key->duration_unit,
                'duration_hours' => $key->duration_hours,
                'duration_worked' => $key->duration_worked,
                'opened' => $key->opened,
                'progress' => $key->progress,
                'sortorder' => $key->sortorder,
                'calendar_id' => $key->calendar_id,
                'type' => $key->type,
                'resource_id' => $key->resource_id,
                'active' => $key->active,
                'status' => $key->status,
                'workload_quantity' => $key->workload_quantity,
                'workload_quantity_unit' => $key->workload_quantity_unit,
                'resource_group_id' => $key->resource_group_id,
                'order_ui' => $key->order_ui,
                'comment' => $key->comment,
                'is_summary' => $key->is_summary,
                'pending_deletion' => $key->pending_deletion,
                'constraint_type' => $key->constraint_type,
                'color' => $key->color
            ];
        }
        return response()->json([
            "data" => $task,
            "links" => DB::table('links')->get(),
        ]);
    }

    public function getactivity(Request $request)
    {
        $activity = DB::table('gantt_versions')->where('programme_id', $request->programme_id)->orderBy('id', 'DESC')->get();
        $payload = array('activity' => $activity);
        echo json_encode($payload);
    }

    public function rollbackactivity(Request $request)
    {
        $activity_id = $request->activity_id;
        $programme_id = $request->programme_id;
        $version_data = DB::table('gantt_versions')->where('id', $activity_id)->first();
        $version_guid = '';
        if ($version_data) {
            $version_guid = $version_data->guid;
        }
        DB::table('gantt_versions')->where('programme_id', $programme_id)->where('id', '>', $activity_id)->update(['active' => 0]);
        DB::table('gantt_versions')->where('programme_id', $programme_id)->where('id', '<=', $activity_id)->update(['active' => 1]);
        GanttTask::where('programme_id', $programme_id)->delete();
        $data = json_decode($version_data->gantt_data, true);
        $tasks = $data['data'];
        $links = count($data) - 1 ? $data['links'] : null;
        $id_diff = (int) (is_null(DB::table('gantt_tasks')->get()->last()) ? 0 : (DB::table('gantt_tasks')->get()->last()->id)) - $tasks[0]['id'] + 1;
        foreach ($tasks as $task) {
            if (isset($task['is_summary'])) {
                unset($task['id']);
                $last_db_id = (int) (is_null(DB::table('gantt_tasks')->get()->last()) ? 0 : (DB::table('gantt_tasks')->get()->last()->id));
                $task_value_array = array('id' => $last_db_id + 1, 'guid' => $task['guid'], 'parent' => ($task['parent'] == 0) ? 0 : $task['parent'] + $id_diff, 'programme_id' => $task['programme_id'], 'text' => $task['text'], 'start_date' => $task['start_date'], 'end_date' => $task['end_date'], 'baseline_start' => $task['baseline_start'], 'baseline_end' => $task['baseline_end'], 'progress' => $task['progress'], 'deadline' => $task['deadline'], 'sortorder' => $task['sortorder'], 'type' => $task['type'], 'resource_id' => $task['resource_id'], 'resource_group_id' => $task['resource_group_id'], 'calendar_id' => $task['calendar_id'], 'comment' => $task['comment'], 'is_summary' => $task['is_summary'], 'color' => $task['color']);
                DB::table('gantt_tasks')->insert($task_value_array);
            }
        }
        if ($links) {
            foreach ($links as $link) {
//                return DB::table('links')->where('id', $link['id'])->first();
                if(DB::table('links')->where('id', $link['id'])->first()) {
                    DB::table('links')->where('id', $link['id'])->update(['source' => $link['source'] + $id_diff, 'target' => $link['target'] + $id_diff]);
                } else {
//                    return $link;
                    DB::table('links')->insert(['type' => $link['type'], 'source' => $link['source'] + $id_diff, 'target' => $link['target'] + $id_diff, 'lag' => $link['lag'], 'created_at' => $link['created_at'], 'updated_at' => $link['updated_at'], 'deleted_at' => $link['deleted_at']]);
                }
            }
        }
        $payload = array("purged" => true);
        echo json_encode($payload);
    }

    public function GetPhotos(Request $request)
    {
        $programme_id = $request->programme_id;
        $data = DB::table("programme_images")->select("id","name","path","description")->where("programme_id", $programme_id)->get();
        echo json_encode($data);
    }

    public function PhotoUpload(Request $request)
    {
        $name = $request->file('file')->getClientOriginalName();
        $image = $request->file('file');
        $path = $image->move(public_path('assets/images/programmes_photo/'),$name);
        $id = DB::table("programme_images")->insertGetId([
            'programme_id'=>$request->programme_id,
            'name' => $name,
            'path' => public_path("assets/images/programmes_photo/").$name
        ]);
        return $id ;
    }

    public function DeleteImage(Request $request)
    {
        return DB::table("programme_images")->where("id", $request->id)->delete();
    }
}
