<?php

namespace AppTenant\Http\Controllers;

use AppTenant\Http\Controllers\BaseController\BaseController;
use AppTenant\Models\SubcontractPersonnel;
use Illuminate\Http\Request;

class SubcontractPersonnelController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subcontractPersonnel = SubcontractPersonnel::paginate(config('app.pagination_size'));

        return t_view('subcontract-personnel.index', [
            'subcontractPersonnel'  => $subcontractPersonnel
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return t_view('subcontract-personnel.create');
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
            'name'                 => 'required|string|max:255',
            'subbie_name'                 => 'required|string|max:255',
            'role'           => 'required|string|max:5000',
        ]);

        $subcontractPersonnel = SubcontractPersonnel::create($request->all());


        return $subcontractPersonnel ? $this->jsonSuccess('Subcontract personnel successfully created') : $this->jsonError();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subcontractPersonnel = SubcontractPersonnel::findOrFail($id);
        return t_view('subcontract-personnel.show', ['subcontractPersonnel' => $subcontractPersonnel]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subcontractPersonnel = SubcontractPersonnel::findOrFail($id);
        return t_view('subcontract-personnel.edit', ['subcontractPersonnel' => $subcontractPersonnel]);
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
        $request->validate([
            'name'                 => 'required|string|max:255',
            'subbie_name'                 => 'required|string|max:255',
            'role'           => 'required|string|max:5000',
        ]);

        $subcontractPersonnel = SubcontractPersonnel::findOrFail($id);

        $subcontractPersonnel = $subcontractPersonnel->update($request->all());

        return $subcontractPersonnel ? $this->jsonSuccess('subcontract personnel successfully updated') : $this->jsonError();
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
