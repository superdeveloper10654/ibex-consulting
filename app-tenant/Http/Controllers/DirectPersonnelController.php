<?php

namespace AppTenant\Http\Controllers;

use AppTenant\Http\Controllers\BaseController\BaseController;
use AppTenant\Models\DirectPersonnel;
use Illuminate\Http\Request;

class DirectPersonnelController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $directPersonnel = DirectPersonnel::paginate(config('app.pagination_size'));

        return t_view('direct-personnel.index', [
            'directPersonnel'  => $directPersonnel
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return t_view('direct-personnel.create');
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
            'role'           => 'required|string|max:5000',
        ]);

        $directPersonnel = DirectPersonnel::create($request->all());


        return $directPersonnel ? $this->jsonSuccess('Direct personnel successfully created') : $this->jsonError();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $directPersonnel = DirectPersonnel::findOrFail($id);
        return t_view('direct-personnel.show', ['directPersonnel' => $directPersonnel]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $directPersonnel = DirectPersonnel::findOrFail($id);
        return t_view('direct-personnel.edit', ['directPersonnel' => $directPersonnel]);
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
            'role'           => 'required|string|max:5000',
        ]);

        $directPersonnel = DirectPersonnel::findOrFail($id);

        $directPersonnel = $directPersonnel->update($request->all());

        return $directPersonnel ? $this->jsonSuccess('Direct personnel successfully updated') : $this->jsonError();
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
