<?php

namespace AppTenant\Http\Controllers;

use AppTenant\Http\Controllers\BaseController\BaseController;
use AppTenant\Http\Controllers\Resource\Traits\HasComments;
use Illuminate\Http\Request;

class TestsAndInspectionsController extends BaseController
{
    use HasComments;

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
        // Activity::add( replace with ::resource()
        //     "Submitted new <a href='" . t_route('instructions.show', $instruction->id) ."'>Test/Inspection {$instruction->id}</a>", 
        //     TestInspection::$activity_icon
        // );
        // Notification::add( replace with ::resource()
        //     "Submitted new <a href='" . t_route('instructions.show', $instruction->id) ."'>instruction {$instruction->id}</a>", 
        //     Instruction::$activity_icon
        // );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Activity::add( replace with ::resource()
        //     "Updated <a href='" . t_route('instructions.show', $instruction->id) ."'>Test/Inspection {$instruction->id}</a>", 
        //     TestInspection::$activity_icon
        // );
        // Notification::add( replace with ::resource()
        //     "Updated <a href='" . t_route('instructions.show', $instruction->id) ."'>instruction {$instruction->id}</a>", 
        //     Instruction::$activity_icon
        // );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
