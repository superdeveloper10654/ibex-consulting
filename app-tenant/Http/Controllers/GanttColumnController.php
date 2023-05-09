<?php

namespace AppTenant\Http\Controllers;

use AppTenant\Http\Controllers\BaseController\BaseController;
use AppTenant\Models\gantt_column;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GanttColumnController extends BaseController
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
        $request->validate([
            'programme_id'  => 'required|int|exists:programmes,id',
            'json'          => 'required|array|required_array_keys:wbs,text,start_date,end_date,progress,baseline_start,baseline_end,task_calendar,resource_id,duration_worked',
        ]);
        $json = [];

        foreach ($request->json as $key => $value) {
            $json[$key] = filter_var($value, FILTER_VALIDATE_BOOLEAN); 
        }
        
        $column = gantt_column::where('user_id', t_profile()->id)->where('programme_id', $request->get('programme_id'))->first();

        if (!empty($column)) {
            $column->task_columns = '['.json_encode($json).']';
            $column->update();
        } else {
            gantt_column::create([
                "user_id"       => t_profile()->id,
                "programme_id"  => $request->programme_id,
                "task_columns"  => '['.json_encode($json).']'
            ]);
        }

        return $this->jsonSuccess('Gantt columns changed Successfully');
    }


    public function storeresourcecolumns(Request $request)
    {
        $request->validate([
            'programme_id'  => 'required|int|exists:programmes,id',
            'json'          => 'required|array|required_array_keys:name,resource_calendar,complete,workload,unit_cost',
        ]);
        $json = [];

        foreach ($request->json as $key => $value) {
            $json[$key] = filter_var($value, FILTER_VALIDATE_BOOLEAN); 
        }

        gantt_column::updateOrCreate(
            ["user_id"=>t_profile()->id],
            ["user_id"=>t_profile()->id,"programme_id"=>$request->programme_id,"resource_columns"=>'['.json_encode($json).']']                
        );
        return $this->jsonSuccess('Gantt Resource columns changed Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \AppTenant\Models\gantt_column  $gantt_column
     * @return \Illuminate\Http\Response
     */
    public function show(gantt_column $gantt_column)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \AppTenant\Models\gantt_column  $gantt_column
     * @return \Illuminate\Http\Response
     */
    public function edit(gantt_column $gantt_column)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \AppTenant\Models\gantt_column  $gantt_column
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, gantt_column $gantt_column)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \AppTenant\Models\gantt_column  $gantt_column
     * @return \Illuminate\Http\Response
     */
    public function destroy(gantt_column $gantt_column)
    {
        //
    }
}
