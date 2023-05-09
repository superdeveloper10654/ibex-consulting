<?php

namespace AppTenant\Http\Controllers;

use AppTenant\Http\Controllers\BaseController\BaseController;
use AppTenant\Models\DirectVehicleAndPlant;
use Illuminate\Http\Request;

class DirectVehiclesAndPlantsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $directVehiclePlants = DirectVehicleAndPlant::paginate(config('app.pagination_size'));

        return t_view('direct-vehicles-plants.index', [
            'directVehiclePlants'  => $directVehiclePlants
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return t_view('direct-vehicles-plants.create');
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
            'vehicle_or_plant_name'  => 'required|string|max:255',
            'ref_no'  => 'required|string|max:255',
        ]);

        $directVehiclePlants = DirectVehicleAndPlant::create($request->all());


        return $directVehiclePlants ? $this->jsonSuccess('Direct Vehicle & Plants successfully created') : $this->jsonError();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $directVehiclePlants = DirectVehicleAndPlant::findOrFail($id);
        return t_view('direct-vehicles-plants.show', ['directVehiclePlants' => $directVehiclePlants]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $directVehiclePlants = DirectVehicleAndPlant::findOrFail($id);
        return t_view('direct-vehicles-plants.edit', ['directVehiclePlants' => $directVehiclePlants]);
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
            'vehicle_or_plant_name'  => 'required|string|max:255',
            'ref_no'           => 'required|string|max:255',
        ]);

        $directVehiclePlants = DirectVehicleAndPlant::findOrFail($id);

        $directVehiclePlants = $directVehiclePlants->update($request->all());

        return $directVehiclePlants ? $this->jsonSuccess('Direct Vehicle & Plants successfully updated') : $this->jsonError();
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
