<?php

namespace AppTenant\Http\Controllers;

use AppTenant\Http\Controllers\BaseController\BaseController;
use AppTenant\Models\SubcontractOrHiredVehicleAndPlant;
use Illuminate\Http\Request;

class SubcontractVehicleAndPlantsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subcontractVehiclePlants = SubcontractOrHiredVehicleAndPlant::paginate(config('app.pagination_size'));

        return t_view('subcontract-vehicle-plants.index', [
            'subcontractVehiclePlants'  => $subcontractVehiclePlants
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return t_view('subcontract-vehicle-plants.create');
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
            'supplier_name'  => 'required|string|max:255',
            'ref_no'  => 'required|string|max:255',
        ]);

        $subcontractVehiclePlants = SubcontractOrHiredVehicleAndPlant::create($request->all());


        return $subcontractVehiclePlants ? $this->jsonSuccess('Subcontract / Hired Vehicle & Plants successfully created') : $this->jsonError();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subcontractVehiclePlants = SubcontractOrHiredVehicleAndPlant::findOrFail($id);
        return t_view('subcontract-vehicle-plants.show', ['subcontractVehiclePlants' => $subcontractVehiclePlants]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subcontractVehiclesPlants = SubcontractOrHiredVehicleAndPlant::findOrFail($id);
        return t_view('subcontract-vehicle-plants.edit', ['subcontractVehiclesPlants' => $subcontractVehiclesPlants]);
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
            'supplier_name'  => 'required|string|max:255',
            'ref_no'  => 'required|string|max:255',
        ]);

        $subcontractVehiclePlants = SubcontractOrHiredVehicleAndPlant::findOrFail($id);

        $subcontractVehiclePlants = $subcontractVehiclePlants->update($request->all());

        return $subcontractVehiclePlants ? $this->jsonSuccess('Subcontract / Hired Vehicle & Plants successfully updated') : $this->jsonError();
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
