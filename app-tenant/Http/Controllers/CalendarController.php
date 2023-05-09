<?php

namespace AppTenant\Http\Controllers;

use AppTenant\Http\Controllers\BaseController\BaseController;
use AppTenant\Models\Calendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalendarController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateRequest($request);

        $calendar_id = $request->id;
        $type = 1;
        $name = $request->name;
        $start_time_array = explode(":", $request->start_time);
        $start_hour = $start_time_array[0];
        $start_minute = $start_time_array[1];
        $end_time_array = explode(":", $request->end_time);
        $end_hour = $end_time_array[0];
        $end_minute = $end_time_array[1];

        if ($request->id == 0) {
             $cal = new Calendar;
             $cal->programme_id = $request->programme_id;
             $cal->name = $name;
             $cal->start_hour = $start_hour;
             $cal->start_minute = $start_minute;
             $cal->end_hour = $end_hour;
             $cal->end_minute = $end_minute;
             $cal->working_day_monday = $request->working_day_monday;
             $cal->working_day_tuesday = $request->working_day_tuesday;
             $cal->working_day_wednesday = $request->working_day_wednesday;
             $cal->working_day_thursday = $request->working_day_thursday;
             $cal->working_day_friday = $request->working_day_friday;
             $cal->working_day_saturday = $request->working_day_saturday;
             $cal->working_day_sunday = $request->working_day_sunday;
             $cal->is_default_task_calendar = $request->default;
             $cal->type = $type;
            $calendar_id = $cal->save();
        }
        else
        {
            Calendar::findOrFail($calendar_id)->update([
                'name'                      => $name,
                'start_hour'                => $start_hour,
                'start_minute'              => $start_minute,
                'end_hour'                  => $end_hour,
                'end_minute'                => $end_minute,
                'working_day_monday'        => $request->working_day_monday,
                'working_day_tuesday'       => $request->working_day_tuesday,
                'working_day_wednesday'     => $request->working_day_wednesday,
                'working_day_thursday'      => $request->working_day_thursday,
                'working_day_friday'        => $request->working_day_friday,
                'working_day_saturday'      => $request->working_day_saturday,
                'working_day_sunday'        => $request->working_day_sunday,
                'is_default_task_calendar'  => $request->default,
                'type'                      => $type
            ]);
        }

        $calendar = Calendar::findOrFail($calendar_id);
        $overrides = json_decode($request->overrides, true);

        foreach ($overrides as $override) {
            $values = array('programme_id' => $calendar->programme->id ,'calendar_id'=>$calendar_id,'start_date'=>$override['startDate'],'end_date'=>$override['endDate']);
            DB::table('calendar_overrides')->insert($values);
        }

        return $this->jsonSuccess('Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \AppTenant\Models\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function show(Calendar $calendar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \AppTenant\Models\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function edit(Calendar $calendar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \AppTenant\Models\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Calendar $calendar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \AppTenant\Models\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $calendar_id = $request->id;
        $result = DB::table('gantt_tasks')->where('programme_id',$request->programme_id)->where('calendar_id',$calendar_id)->get();
        if($result->isEmpty())
        {
            DB::table('calendars')->where('id', $calendar_id)->where('programme_id',$request->programme_id)->delete();
            $payload = array("calendar_deleted" => true,'message'=>'Calendar deleted successfully');
            echo json_encode($payload);
        }
        else
        {
            $payload = array("calendar_deleted" => true,'message'=>'This Calendar already assigned.so, calendar not deleted');
            echo json_encode($payload);
        }


    }

    public function reload_gantt(Request $request)
    {
        $calendars = DB::table('calendars')->where('programme_id',$request->programme_id)->get();
        $calendar_overrides = DB::table('calendar_overrides')->where('programme_id',$request->programme_id)->get();
        $payload = array("calendars" => $calendars,"calendar_overrides"=>$calendar_overrides);
        echo json_encode($payload);
    }

    public function save_resource_calendar(Request $request)
    {
        $x = $request->all();
        $this->validateRequest($request);

        $calendar_id = $request->id;
        $type = 2;
        $name = $request->name;
        $start_time_array = explode(":", $request->start_time);
        $start_hour = $start_time_array[0];
        $start_minute = $start_time_array[1];
        $end_time_array = explode(":", $request->end_time);
        $end_hour = $end_time_array[0];
        $end_minute = $end_time_array[1];
        $programme_id = $request->programme_id;

        if ($request->default == "true") {
            DB::table('calendars')->where('programme_id', $programme_id)->update(['is_default_resource_calendar' => '0']);
        }

        if ($request->id == 0) {
             $cal = new Calendar;
             $cal->programme_id = $programme_id;
             $cal->name = $name;
             $cal->start_hour = $start_hour;
             $cal->start_minute = $start_minute;
             $cal->end_hour = $end_hour;
             $cal->end_minute = $end_minute;
             $cal->working_day_monday = $request->working_day_monday;
             $cal->working_day_tuesday = $request->working_day_tuesday;
             $cal->working_day_wednesday = $request->working_day_wednesday;
             $cal->working_day_thursday = $request->working_day_thursday;
             $cal->working_day_friday = $request->working_day_friday;
             $cal->working_day_saturday = $request->working_day_saturday;
             $cal->working_day_sunday = $request->working_day_sunday;
             $cal->is_default_resource_calendar = $request->default;
             $cal->type = $type;
            $calendar_id = $cal->save();
        }
        else {
            DB::table('calendars')->where('id', $calendar_id)->update(['name' => $name, 'start_hour' => $start_hour, 'start_minute' => $start_minute, 'end_hour' => $end_hour, 'end_minute' => $end_minute, 'working_day_monday' => $request->working_day_monday, 'working_day_tuesday' => $request->working_day_tuesday, 'working_day_wednesday' => $request->working_day_wednesday, 'working_day_thursday' => $request->working_day_thursday, 'working_day_friday' => $request->working_day_friday, 'working_day_saturday' => $request->working_day_saturday, 'working_day_sunday' => $request->working_day_sunday, 'is_default_resource_calendar' => $request->default, 'type' => $type]);

        }
        
        return $this->jsonSuccess('Saved');
    }

    protected function validateRequest(Request $request)
    {
        $request->validate([
            'id'                    => 'int',
            'programme_id'          => 'required|int|exists:programmes,id',
            'name'                  => 'required|string|max:191',
            'start_time'            => 'required|date_format:H:i',
            'end_time'              => 'required|date_format:H:i',
            'working_day_monday'    => 'required|boolean',
            'working_day_tuesday'   => 'required|boolean',
            'working_day_wednesday' => 'required|boolean',
            'working_day_thursday'  => 'required|boolean',
            'working_day_friday'    => 'required|boolean',
            'working_day_saturday'  => 'required|boolean',
            'working_day_sunday'    => 'required|boolean',
            'default'               => 'required|boolean',
            'overrides'             => 'json',
            'enabled'               => 'boolean',
            'type'                  => 'boolean',

        ]);
    }
}
