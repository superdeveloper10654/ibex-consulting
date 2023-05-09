<?php

namespace AppTenant\Http\Controllers;

use AppTenant\Http\Controllers\BaseController\BaseController;
use AppTenant\Http\Controllers\Resource\Traits\HasComments;
use AppTenant\Http\Controllers\Resource\Traits\HasDeletionsAndDrafts;
use AppTenant\Models\Activity;
use AppTenant\Models\Calendar_override;
use AppTenant\Models\Contract;
use AppTenant\Models\Programme;
use AppTenant\Models\GanttTask;
use AppTenant\Models\Link;
use App\Models\Statical\Constant;
use AppTenant\Models\Statical\MediaCollection;
use AppTenant\Models\Status\ProgrammeStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProgrammesController extends BaseController
{
    use HasComments, HasDeletionsAndDrafts;

    public function index()
    {
        if (t_profile()->isContractor()) {
            $base_query = Programme::whereСontractor(t_profile()->id);
        } else if (t_profile()->isSubContractor()) {
            $base_query = Programme::whereSubcontractor(t_profile()->id);
        } else {
            $base_query = Programme::query();
        }

        $programmes = $base_query->notDraftedOrMine()
            ->orderBy('accepted_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(config('app.pagination_size'));

        $programme = new Programme();

        return t_view('programme.list-of-programme', [
            'resource'      => $programme,
            'programmes'    => $programmes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $contracts = Contract::all();
        $programmes = Programme::all();
        $calendars = ['Create a default calendar', 'Create a new calendar'];
        return t_view('programme.create-programme',['contracts' => $contracts, 'calendars' => $calendars, 'programmes' => $programmes]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateRequest($request, Constant::ACTION_STORE);

        if ($request->get('calendar') == "1") {
            $request->validate([
                'task_calendar_edit_override_start'                 => 'required|string|max:255',
                'task_calendar_edit_override_end'                 => 'required|string|max:255'
            ]);
        }

        $status = $request->get('is_draft') ? ProgrammeStatus::DRAFT_ID : ProgrammeStatus::SUBMITTED_ID;
        $programme = Programme::create([
            'created_by'            => t_profile()->id,
            'name'                  => $request->get('name'),
            'contract_id'           => $request->get('contract'),
            'sharing_identifier'    => Str::uuid(),
            'status'                => $status,
        ]);

        if($request->get('calendar')=="0"){
            $columns_json = '[{"status": true,"wbs":false,"text":true,"start_date":true,"end_date":false,"progress":true,"baseline_start":false,"baseline_end":false,"task_calendar":true,"deadline":false,"resource_id":true,"duration_worked":false}]';

            $columns_resources_json = '[{"name":true,"resource_calendar":false,"complete":true,"workload":true,"unit_cost":true}]';

            $values = array("user_id" => t_profile()->id, 'task_columns' => $columns_json, 'resource_columns' => $columns_resources_json, 'programme_id' => $programme->id, 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s'));
            DB::table('gantt_columns')->insert($values);


            $working_days = '{"working_day_monday":1,"working_day_tuesday":1,"working_day_wednesday":1,"working_day_thursday":1,"working_day_friday":1,"working_day_saturday":0,"working_day_sunday":0}';

            // Working days
            $working_days = json_decode($working_days, true);
            $calendar_name = "Default task calendar";
            $is_default_task_calendar = "1";
            $start_time = "07:00";
            $end_time = "17:00";
            $start_hour = "7";
            $start_minute = "0";
            $end_hour = "17";
            $end_minute = "0";

            $default_task_calendar = array("programme_id" => $programme->id, 'name' => $calendar_name, 'start_time' => $start_time, 'start_hour' => $start_hour, 'start_minute' => $start_minute, 'end_time' => $end_time, 'end_hour' => $end_hour, 'end_minute' => $end_minute, 'working_day_monday' => $working_days['working_day_monday'], 'working_day_tuesday' => $working_days['working_day_tuesday'], 'working_day_wednesday' => $working_days['working_day_wednesday'], 'working_day_thursday' => $working_days['working_day_thursday'], 'working_day_friday' => $working_days['working_day_friday'], 'working_day_saturday' => $working_days['working_day_saturday'], 'working_day_sunday' => $working_days['working_day_sunday'], 'is_default_task_calendar' => $is_default_task_calendar, 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s'));
            DB::table('calendars')->insert($default_task_calendar);

            $working_days = '{"working_day_monday":1,"working_day_tuesday":1,"working_day_wednesday":1,"working_day_thursday":1,"working_day_friday":1,"working_day_saturday":0,"working_day_sunday":0}';
            $working_days = json_decode($working_days, true);
            $calendar_name = "Default resource calendar";
            $type = "2";
            $is_default_resource_calendar = "1";
            $start_time = "07:00";
            $end_time = "17:00";
            $start_hour = "7";
            $start_minute = "0";
            $end_hour = "17";
            $end_minute = "0";

            $default_resource_calendar = array("programme_id" => $programme->id, 'name' => $calendar_name, 'start_time' => $start_time, 'start_hour' => $start_hour, 'start_minute' => $start_minute, 'end_time' => $end_time, 'end_hour' => $end_hour, 'end_minute' => $end_minute, 'working_day_monday' => $working_days['working_day_monday'], 'working_day_tuesday' => $working_days['working_day_tuesday'], 'working_day_wednesday' => $working_days['working_day_wednesday'], 'working_day_thursday' => $working_days['working_day_thursday'], 'working_day_friday' => $working_days['working_day_friday'], 'working_day_saturday' => $working_days['working_day_saturday'], 'working_day_sunday' => $working_days['working_day_sunday'], 'is_default_resource_calendar' => $is_default_resource_calendar, 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s'), 'type' => 2);
            DB::table('calendars')->insert($default_resource_calendar);
            $calendar_ids = DB::getPdo()->lastInsertId();

            $first_group = array('name' => 'civil crew 1', 'programme_id' => $programme->id, 'parent_id' => 0, 'calendar_id' => $calendar_ids, 'unit_cost' => 50);
            DB::table('resources')->insert($first_group);
            $first_group_id = DB::getPdo()->lastInsertId();

            $fisrt_group_resource = array('name' => 'Operative 1', 'programme_id' => $programme->id, 'parent_id' => $first_group_id, 'calendar_id' => $calendar_ids, 'unit_cost' => 50);

            $fisrt_group_resource_id = DB::table('resources')->insert($fisrt_group_resource);

            $second_group = array('name' => 'TM crew', 'programme_id' => $programme->id, 'parent_id' => 0, 'calendar_id' => $calendar_ids, 'unit_cost' => 40);
            DB::table('resources')->insert($second_group);
            $second_group_id = DB::getPdo()->lastInsertId();

            $Second_group_resource = array('name' => 'Driver', 'programme_id' => $programme->id, 'parent_id' => $second_group_id, 'calendar_id' => $calendar_ids, 'unit_cost' => 40);

            $Second_group_resource_id = DB::table('resources')->insert($Second_group_resource);
            $encryed_id = Crypt::encryptString($programme->id);
            $return_array = array('id' => $programme->id, 'url' => "{{route('gantt',$encryed_id}}");

        } elseif($request->get('calendar')=="1"){
            $columns_json = '[{"status": true,"wbs":false,"text":true,"start_date":true,"end_date":false,"progress":true,"baseline_start":false,"baseline_end":false,"task_calendar":true,"deadline":false,"resource_id":true,"duration_worked":false}]';

            $columns_resources_json = '[{"name":true,"resource_calendar":false,"complete":true,"workload":true,"unit_cost":true}]';

            $values = array("user_id" => t_profile()->id, 'task_columns' => $columns_json, 'resource_columns' => $columns_resources_json, 'programme_id' => $programme->id, 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s'));
            DB::table('gantt_columns')->insert($values);
            $calendar_name = $request->get('calendar_name');
            if($request->get('task_calendar_edit_default')=='on'){
                $is_default_task_calendar = 1;
            } else $is_default_task_calendar = 0;
            $start_time = $request->get('task_calendar_edit_start_time');
            $end_time = $request->get('task_calendar_edit_end_time');
            $start_hm = explode(":", $start_time);
            $start_hour = $start_hm['0'];
            $start_minute = $start_hm['1'];
            $end_hm = explode(":", $end_time);
            $end_hour = $end_hm['0'];
            $end_minute = $end_hm['1'];

            if($request->get('working_day_monday')=='on'){
                $working_days['working_day_monday'] = 1;
            } else $working_days['working_day_monday'] = 0;

            if($request->get('working_day_tuesday')=='on'){
                $working_days['working_day_tuesday'] = 1;
            } else $working_days['working_day_tuesday'] = 0;

            if($request->get('working_day_wednesday')=='on'){
                $working_days['working_day_wednesday'] = 1;
            } else $working_days['working_day_wednesday'] = 0;

            if($request->get('working_day_thursday')=='on'){
                $working_days['working_day_thursday'] = 1;
            } else $working_days['working_day_thursday'] = 0;

            if($request->get('working_day_friday')=='on'){
                $working_days['working_day_friday'] = 1;
            } else $working_days['working_day_friday'] = 0;

            if($request->get('working_day_saturday')=='on'){
                $working_days['working_day_saturday'] = 1;
            } else $working_days['working_day_saturday'] = 0;

            if($request->get('working_day_sunday')=='on'){
                $working_days['working_day_sunday'] = 1;
            } else $working_days['working_day_sunday'] = 0;

            $default_task_calendar = array("programme_id" => $programme->id, 'name' => $calendar_name, 'start_time' => $start_time, 'start_hour' => $start_hour, 'start_minute' => $start_minute, 'end_time' => $end_time, 'end_hour' => $end_hour, 'end_minute' => $end_minute, 'working_day_monday' => $working_days['working_day_monday'], 'working_day_tuesday' => $working_days['working_day_tuesday'], 'working_day_wednesday' => $working_days['working_day_wednesday'], 'working_day_thursday' => $working_days['working_day_thursday'], 'working_day_friday' => $working_days['working_day_friday'], 'working_day_saturday' => $working_days['working_day_saturday'], 'working_day_sunday' => $working_days['working_day_sunday'], 'is_default_task_calendar' => $is_default_task_calendar, 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s'));
            DB::table('calendars')->insert($default_task_calendar);

            $encryed_id = Crypt::encryptString($programme->id);
            $return_array = array('id' => $programme->id, 'url' => "{{route('gantt',$encryed_id}}");
            $task_calendar_edit_override_start = $request->get('task_calendar_edit_override_start');
            $task_calendar_edit_override_end = $request->get('task_calendar_edit_override_end');

            $calendar_id = DB::getPdo()->lastInsertId();
            $values = array('programme_id' => $programme->id ,'calendar_id'=>$calendar_id,'start_date'=>$task_calendar_edit_override_start,'end_date'=>$task_calendar_edit_override_end);
            // DB::table('calendar_overrides')->insert($values);
            Calendar_override::create([
                'programme_id'  => $programme->id ,
                'calendar_id'   => $calendar_id,
                'start_date'    => $task_calendar_edit_override_start,
                'end_date'      => $task_calendar_edit_override_end
            ]);
        }

        if ($programme) {
            if ($request->get('temp') == null) {
                return $this->jsonSuccess('Programme successfully created', $encryed_id);
            }

            $programme_id = $request->get('temp');
            $tasks = GanttTask::where('programme_id', $programme_id)->get();
            $links = DB::table('links')->get();
            $id_diff = (int) (is_null(DB::table('gantt_tasks')->get()->last()) ? 0 : (DB::table('gantt_tasks')->get()->last()->id)) - $tasks[0]['id'] + 1;
            foreach ($tasks as $task) {
                if (isset($task['is_summary'])) {
                    unset($task['id']);
                    $last_db_id = (int) (is_null(DB::table('gantt_tasks')->get()->last()) ? 0 : (DB::table('gantt_tasks')->get()->last()->id));
                    $task_value_array = array('id' => $last_db_id + 1, 'guid' => $task['guid'], 'parent' => ($task['parent'] == 0) ? 0 : $task['parent'] + $id_diff, 'programme_id' => $programme['id'], 'text' => $task['text'], 'start_date' => $task['start_date'], 'end_date' => $task['end_date'], 'baseline_start' => $task['baseline_start'], 'baseline_end' => $task['baseline_end'], 'progress' => $task['progress'], 'deadline' => $task['deadline'], 'sortorder' => $task['sortorder'], 'type' => $task['type'], 'resource_id' => $task['resource_id'], 'resource_group_id' => $task['resource_group_id'], 'calendar_id' => $task['calendar_id'], 'comment' => $task['comment'], 'is_summary' => $task['is_summary'], 'color' => $task['color']);
                    DB::table('gantt_tasks')->insert($task_value_array);
                }
            }
            DB::table('links')->update(['source' => DB::raw("source + $id_diff"), 'target' => DB::raw("target + $id_diff")]);

            if (!$programme->isDraft()) {
                Activity::resource('Created', $programme);
            }
            return $this->jsonSuccess('Programme successfully created', $encryed_id);
        }

        return $this->jsonError();
    }
    /**
     * Display the specified resource.
     *
     * @param  \AppTenant\Models\Programme  $programme
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (t_profile()->isContractor()) {
            $programme = Programme::whereСontractor(t_profile()->id)->findOrFail($id);

        } else if (t_profile()->isSubContractor()) {
            $programme = Programme::whereSubcontractor(t_profile()->id)->findOrFail($id);

        } else {
            $programme = Programme::findOrFail($id);
        }

        $files = Media::where('collection_name', MediaCollection::COLLECTION_PROGRAMMES)
            ->where('custom_properties->resource_id', $id)
            ->get();

        return t_view('programme.show', [
            'programme' => $programme,
            'files'     => $files,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \AppTenant\Models\Programme  $programme
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = (int) $id == $id ? $id : Crypt::decryptString($id);
        $programme = Programme::notDraftedOrMine()->findOrFail($id);

        if (empty($programme) || !$programme->canBeUpdated()) {
            abort(404);
        }

        $calendars = DB::table('calendars')->where('programme_id', $id)->get();
        $calendar_overrides = DB::table('calendar_overrides')->where('programme_id', $id)->get();
        $contracts = Contract::all();

        return t_view('programme.edit-of-programme', compact('programme', 'contracts', 'calendars', 'calendar_overrides'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \AppTenant\Models\Programme  $programme
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validateRequest($request, Constant::ACTION_UPDATE);
        $programme = Programme::notDraftedOrMine($request->id)->first();

        if (empty($programme) || !$programme->canBeUpdated()) {
            abort(404);
        }

        $programme->name = $request->name;
        $programme->update();

        Activity::resource('Updated', $programme);

        return $programme ? $this->jsonSuccess('Programme successfully updated') : $this->jsonError();
    }

    /**
     * Update Programme status to Accepted
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function accept($id)
    {
        $programme = Programme::findOrFail($id);

        if ($programme->isSubmitted()) {
            $programme->status = ProgrammeStatus::ACCEPTED_ID;
            $programme->save();
            Activity::resource(ProgrammeStatus::ACCEPTED, $programme);
        } else {
            Log::warning('Trying to accept Programme that not submitted');
            abort(404);
        }

        return redirect($programme->link('show'));
    }

    /**
     * Update Programme status to Rejected
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reject($id)
    {
        $programme = Programme::findOrFail($id);

        if ($programme->isSubmitted()) {
            $programme->status = ProgrammeStatus::REJECTED_ID;
            $programme->save();
            Activity::resource(ProgrammeStatus::REJECTED, $programme);
        } else {
            Log::warning('Trying to reject Programme that not submitted');
            abort(404);
        }

        return redirect($programme->link('show'));
    }

    /**
     * Update Programme status to Submitted
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function submit($id)
    {
        $programme = Programme::findMineDraftedOrFail($id);
        $programme->status = ProgrammeStatus::SUBMITTED_ID;
        $programme->save();
        Activity::resource(ProgrammeStatus::SUBMITTED, $programme);

        return redirect($programme->link('show'));
    }

    /**
     * Validate store/update request
     * @param Request $request
     * @param int $action
     * @param Programme $programme
     */
    protected function validateRequest(Request $request, $action, $programme = null)
    {
        if ($action == Constant::ACTION_STORE) {
            $request->validate([
                'name'      => 'required|string|max:255',
                'contract'  => 'required|exists:contracts,id',
                'calendar'  => 'required|string|max:255',
                'is_draft'  => 'boolean',
            ]);
        } else {
            $request->validate([
                'name'  => 'required|string|max:255',
                'id'    => 'required|exists:programmes,id',
            ]);
        }
    }
}
