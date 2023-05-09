<?php

namespace AppTenant\Http\Controllers;

use AppTenant\Http\Controllers\BaseController\BaseController;
use AppTenant\Models\Operation;
use Illuminate\Http\Request;

class OperationsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $operations = Operation::paginate(config('app.pagination_size'));

        return t_view('operations.index', [
            'operations'  => $operations
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return t_view('operations.create');
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
        ]);

        $operation = Operation::create($request->all());


        return $operation ? $this->jsonSuccess('Operation successfully created') : $this->jsonError();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $operation = Operation::findOrFail($id);
        return t_view('operations.show', ['operation' => $operation]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $operation = Operation::findOrFail($id);
        return t_view('operations.edit', ['operation' => $operation]);
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
        ]);

        $operation = Operation::findOrFail($id);

        $operation = $operation->update($request->all());

        return $operation ? $this->jsonSuccess('Operation successfully updated') : $this->jsonError();
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
