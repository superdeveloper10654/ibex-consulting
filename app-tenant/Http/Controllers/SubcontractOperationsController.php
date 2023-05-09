<?php

namespace AppTenant\Http\Controllers;

use AppTenant\Http\Controllers\BaseController\BaseController;
use AppTenant\Models\SubcontractOrClientOperation;
use Illuminate\Http\Request;

class SubcontractOperationsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subcontractOperations = SubcontractOrClientOperation::paginate(config('app.pagination_size'));

        return t_view('subcontract-operations.index', [
            'subcontractOperations'  => $subcontractOperations
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return t_view('subcontract-operations.create');
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
            'subbie_name'                 => 'required|string|max:255',
            'operation_name'                 => 'required|string|max:255',
        ]);

        $subcontractOperation = SubcontractOrClientOperation::create($request->all());


        return $subcontractOperation ? $this->jsonSuccess('Subcontract Operation successfully created') : $this->jsonError();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subcontractOperation = SubcontractOrClientOperation::findOrFail($id);
        return t_view('subcontract-operations.show', ['subcontractOperation' => $subcontractOperation]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subcontractOperation = SubcontractOrClientOperation::findOrFail($id);
        return t_view('subcontract-operations.edit', ['subcontractOperation' => $subcontractOperation]);
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
            'subbie_name'                 => 'required|string|max:255',
            'operation_name'                 => 'required|string|max:255',
        ]);

        $subcontractOperation = SubcontractOrClientOperation::findOrFail($id);

        $subcontractOperation = $subcontractOperation->update($request->all());

        return $subcontractOperation ? $this->jsonSuccess('Subcontract Operation successfully updated') : $this->jsonError();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort(404);
    }
}
