<?php

namespace AppTenant\Http\Controllers;

use AppTenant\Http\Controllers\BaseController\BaseController;
use AppTenant\Models\Calendar_override;
use Illuminate\Http\Request;
use DB;
class CalendarOverrideController extends BaseController
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
        $programme_id = $request->programme_id;
        $calendar_id = $request->calendar_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $cal_over = new Calendar_override; 
        $cal_over->programme_id = $programme_id;
        $cal_over->calendar_id = $calendar_id;
        $cal_over->start_date = $start_date;
        $cal_over->end_date = $end_date;
        $calendar_override_id = $cal_over->save();


         $overrides = DB::table('calendar_overrides')->where('programme_id',$programme_id)->where('calendar_id',$calendar_id)->orderBy('start_date','ASC')->get();
         $payload = array("created" => true, "calendar_overrides" => $overrides);
        echo json_encode($payload);
    }

    /**
     * Display the specified resource.
     *
     * @param  \AppTenant\Models\Calendar_override  $calendar_override
     * @return \Illuminate\Http\Response
     */
    public function show(Calendar_override $calendar_override)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \AppTenant\Models\Calendar_override  $calendar_override
     * @return \Illuminate\Http\Response
     */
    public function edit(Calendar_override $calendar_override)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \AppTenant\Models\Calendar_override  $calendar_override
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Calendar_override $calendar_override)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \AppTenant\Models\Calendar_override  $calendar_override
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $override_id = $request->id;
        $calendar_id = $request->calendar_id;
        $programme_id = $request->programme_id;
         Calendar_override::where('id', $override_id)->where('calendar_id',$calendar_id)->delete();
        $overrides = DB::table('calendar_overrides')->where('programme_id',$programme_id)->where('calendar_id',$calendar_id)->orderBy('start_date','ASC')->get();
        $payload = array("created" => true, "calendar_overrides" => $overrides);
        echo json_encode($payload);

    }
}
