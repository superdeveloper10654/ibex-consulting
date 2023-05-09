<?php

namespace AppTenant\Http\Controllers;

use AppTenant\Http\Controllers\BaseController\BaseController;
use Illuminate\Http\Request;

use AppTenant\Models\DailySubContractPersonnel;
use AppTenant\Models\DailyDirectVehiclesAndPlant;
use AppTenant\Models\DailySubContractClientOperation;
use AppTenant\Models\DailySubContractOrHiredVehiclesAndPlant;
use AppTenant\Models\DailyWorkRecord;
use AppTenant\Models\DailyDirectPersonnel;
use AppTenant\Models\DailyOrderedSuppliedMaterial;
use AppTenant\Models\DailyWeatherCondition;
use AppTenant\Models\DailyOperationalTimingOperation;
use AppTenant\Models\DailyOperationalTimingSuppliedMaterial;
use AppTenant\Models\DailyOperationalTimingPlantHaulage;
use AppTenant\Models\DailyOperationalTimingToClientInfo;
use AppTenant\Models\DailySiteRisk;

use AppTenant\Models\DirectPersonnel;
use AppTenant\Models\SubcontractPersonnel;
use AppTenant\Models\DirectVehicleAndPlant;
use AppTenant\Models\SubcontractOrHiredVehicleAndPlant;
use AppTenant\Models\SubcontractOrClientOperation;
use AppTenant\Models\Operation;
use AppTenant\Models\Material;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use AppTenant\Models\Statical\MediaCollection;
use AppTenant\Models\Contract;
use AppTenant\Models\Profile;
use AppTenant\Models\Statical\Role;

class DailyWorkRecordController extends BaseController
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dailyWorkRecords=DailyWorkRecord::paginate(config('app.pagination_size'));
        
        return t_view('daily-works.index', [
            'dailyWorkRecords' => $dailyWorkRecords
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $contracts = Contract::all();
        $client_profiles = Profile::where('email', '<>', env('SUPPORT_PROFILE_EMAIL'))->get()
            ->map(function($profile) {
                $profile->name_with_role = $profile->name . ' (' . $profile->role()->name . ')';
                return $profile;
            });
        $supervisor_profiles = Profile::where('role', Role::SUPERVISOR_ID)->get();

        return t_view('daily-works.create',[
            'contracts'             => $contracts,
            'client_profiles'       => $client_profiles,
            'supervisor_profiles'   => $supervisor_profiles,
        ]);
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
            'contract_id'           => 'required|integer|exists:contracts,id',
            'client_profile_id'     => 'required|integer|exists:profiles,id',
            'supervisor_profile_id' => 'required|integer|exists:profiles,id',
            'reference_no'          => 'required|string|max:255',
            'crew_name'             => 'required|string|max:255',
            'date'                  => 'required|string|max:255',
            'site_name'             => 'required|string|max:255',
            'foreman'               => 'required|string|max:255',
        ]);

        $dailyWorkRecord = DailyWorkRecord::create($request->all());

        return $dailyWorkRecord ? redirect('/daily-work-records/'.$dailyWorkRecord->id.'/step2') : $this->jsonError();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $files = Media::where('collection_name', MediaCollection::COLLECTION_DAILY_WORK_RECORD)
                        ->where('custom_properties->resource_id', $id)
                        ->get();
        $dailyWorkRecord = DailyWorkRecord::findOrFail($id);
        $dailyDirectPessonels=DailyDirectPersonnel::where('daily_work_record_id',$id)->get();
        $dailySubContractPessonels =DailySubContractPersonnel::where('daily_work_record_id',$id)->get();
        $dailyDirectVehiclesAndPlants =DailyDirectVehiclesAndPlant::where('daily_work_record_id',$id)->get();
        $dailySubcontractOrHiredVehiclesAndPlants =DailySubContractOrHiredVehiclesAndPlant::where('daily_work_record_id',$id)->get();

        $dailySubcontractOrClientOperations=DailySubContractClientOperation::where('daily_work_record_id',$id)->get();
        $dailyOrderedSuppliedMaterials=DailyOrderedSuppliedMaterial::where('daily_work_record_id',$id)->get();
        $dailyWeatherConditions = DailyWeatherCondition::where('daily_work_record_id',$id)->get();

        $dailyOperationalTimingOperations = DailyOperationalTimingOperation::where('daily_work_record_id',$id)->get();
        $dailyOperationalTimingSuppliedMaterials = DailyOperationalTimingSuppliedMaterial::where('daily_work_record_id',$id)->get();
        $dailyOperationalTimingPlantHaulages = DailyOperationalTimingPlantHaulage::where('daily_work_record_id',$id)->get();
        $dailyOperationalTimingToClientInfos = DailyOperationalTimingToClientInfo::where('daily_work_record_id',$id)->get();

        $dailySiteRisks = DailySiteRisk::where('daily_work_record_id',$id)->get();
        return t_view('daily-works.show',compact(
            'dailyWorkRecord',

            'dailyDirectPessonels',
            'dailySubContractPessonels',
            'dailyDirectVehiclesAndPlants',
            'dailySubcontractOrHiredVehiclesAndPlants',

            'dailySubcontractOrClientOperations',
            'dailyOrderedSuppliedMaterials',
            'dailyWeatherConditions',

            'dailyOperationalTimingOperations',
            'dailyOperationalTimingSuppliedMaterials',
            'dailyOperationalTimingPlantHaulages',
            'dailyOperationalTimingToClientInfos',
            'dailySiteRisks',
            'files'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dailyWorkRecord = DailyWorkRecord::findOrFail($id);
        $contracts = Contract::all();
        $client_profiles = Profile::where('email', '<>', env('SUPPORT_PROFILE_EMAIL'))->get()
            ->map(function($profile) {
                $profile->name_with_role = $profile->name . ' (' . $profile->role()->name . ')';
                return $profile;
            });
        $supervisor_profiles = Profile::where('role', Role::SUPERVISOR_ID)->get();

        return t_view('daily-works.edit', [
            'dailyWorkRecord'       => $dailyWorkRecord,
            'contracts'             => $contracts,
            'client_profiles'       => $client_profiles,
            'supervisor_profiles'   => $supervisor_profiles,
        ]);
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
        $dailyWorkRecord = DailyWorkRecord::findOrFail($id);

        $request->validate([
            'contract_id'           => 'required|integer|exists:contracts,id',
            'client_profile_id'     => 'required|integer|exists:profiles,id',
            'supervisor_profile_id' => 'required|integer|exists:profiles,id',
            'reference_no'          => 'required|string|max:255',
            'crew_name'             => 'required|string|max:255',
            'date'                  => 'required|string|max:255',
            'site_name'             => 'required|string|max:255',
            'foreman'               => 'required|string|max:255',
        ]);

        $isUpdatedSucess = $dailyWorkRecord->update($request->all());
        if( $isUpdatedSucess){
            return redirect('/daily-work-records/'.$dailyWorkRecord->id.'/step2') ;
        }
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


    public function step2($id)
    {
        $createdDailyDirectPessonels=DailyDirectPersonnel::where('daily_work_record_id',$id)->get();
        $createdDailySubContractPessonels =DailySubContractPersonnel::where('daily_work_record_id',$id)->get();
        $createdDailyDirectVehiclesAndPlants =DailyDirectVehiclesAndPlant::where('daily_work_record_id',$id)->get();
        $createdDailySubcontractOrHiredVehiclesAndPlants =DailySubContractOrHiredVehiclesAndPlant::where('daily_work_record_id',$id)->get();
        $directPessonelOptions = collect(array_map(function($option){
            $option['optionName']=$option['name'] . ' / '.$option['role'];
            return $option;
        },DirectPersonnel::all()->toArray()));

        $subContractPessonelOptions = collect(array_map(function($option){
            $option['optionName']=$option['name'] . ' / '.$option['role'].' / '.$option['subbie_name'];
            return $option;
        },SubcontractPersonnel::all()->toArray()));

        $directVehicleAndPlantOptions = collect(array_map(function($option){
            $option['optionName']=$option['vehicle_or_plant_name'] . ' / '.$option['ref_no'];
            return $option;
        },DirectVehicleAndPlant::all()->toArray()));

        $subcontractOrHiredVehicleAndPlantOptions = collect(array_map(function($option){
            $option['optionName']=$option['vehicle_or_plant_name'] . ' / '.$option['supplier_name'].' / '.$option['ref_no'];
            return $option;
        },SubcontractOrHiredVehicleAndPlant::all()->toArray()));

        $dailyWorkRecordId = $id;
        // dd($dailyWorkRecordId);
        return t_view('daily-works.step2',compact(
            'dailyWorkRecordId',
            'createdDailyDirectPessonels',
            'createdDailySubContractPessonels',
            'createdDailyDirectVehiclesAndPlants',
            'createdDailySubcontractOrHiredVehiclesAndPlants',

            'directPessonelOptions',
            'subContractPessonelOptions',
            'directVehicleAndPlantOptions',
            'subcontractOrHiredVehicleAndPlantOptions'
            )
        );
    }
    public function updateStep2(Request $request, $id)
    {
        // dd("updateStep2",$request);
        //  dd($request["dailyDirectPessonels"]);
         if($request["dailyDirectPessonels"] && count($request["dailyDirectPessonels"])>0){
            $alreadyCreatedDailyDirectPersonnelIds=DailyDirectPersonnel::where('daily_work_record_id',$id)->pluck('id')->toArray();
            foreach ($request["dailyDirectPessonels"] as $dailyDirectPessonel) {
                if($dailyDirectPessonel["id"]=="NEW"){
                    unset($dailyDirectPessonel["id"]);
                    DailyDirectPersonnel::create($dailyDirectPessonel);
                }else{
                    $ddp=DailyDirectPersonnel::findOrFail($dailyDirectPessonel["id"]);
                    $ddp->update($dailyDirectPessonel);
                }
            }
            $requestDdpIds=array_column($request["dailyDirectPessonels"],'id');
            foreach($alreadyCreatedDailyDirectPersonnelIds as $ddpid){
                if(!in_array($ddpid,$requestDdpIds)){
                    $ddp =  DailyDirectPersonnel::findOrfail($ddpid);
                    $ddp->delete();
                }
            }
        }
        //  dd($request["dailySubContractPessonels"]);
        if($request["dailySubContractPessonels"] && count($request["dailySubContractPessonels"])>0){
            $alreadyCreatedDailySubcontractPersonnelIds=DailySubContractPersonnel::where('daily_work_record_id',$id)->pluck('id')->toArray();
            foreach ($request["dailySubContractPessonels"] as $dailySubContractPessonel) {
                if($dailySubContractPessonel["id"]=="NEW"){
                    unset($dailySubContractPessonel["id"]);
                    DailySubContractPersonnel::create($dailySubContractPessonel);
                }else{
                $dsp=DailySubContractPersonnel::findOrFail($dailySubContractPessonel["id"]);
                $dsp->update($dailySubContractPessonel);
                }
            }
            $requestDspIds=array_column($request["dailySubContractPessonels"],'id');
            foreach($alreadyCreatedDailySubcontractPersonnelIds as $dspid){
                if(!in_array($dspid,$requestDspIds)){
                    $dsp =  DailySubContractPersonnel::findOrfail($dspid);
                    $dsp->delete();
                }
            }
        }
        //  dd($request["dailyDirectVehicleAndPlants"]);
        if($request["dailyDirectVehicleAndPlants"] && count($request["dailyDirectVehicleAndPlants"])>0){
            $alreadyCreatedDailyDirectVehicleAndPlantIds=DailyDirectVehiclesAndPlant::where('daily_work_record_id',$id)->pluck('id')->toArray();
            foreach ($request["dailyDirectVehicleAndPlants"] as $dailyDirectVehicleAndPlant) {
                if($dailyDirectVehicleAndPlant["id"]=="NEW"){
                    unset($dailyDirectVehicleAndPlant["id"]);
                    DailyDirectVehiclesAndPlant::create($dailyDirectVehicleAndPlant);
                }else{
                $ddvp=DailyDirectVehiclesAndPlant::findOrFail($dailyDirectVehicleAndPlant["id"]);
                $ddvp->update($dailyDirectVehicleAndPlant);
                }
            }
            $requestDdvpIds=array_column($request["dailyDirectVehicleAndPlants"],'id');
            foreach($alreadyCreatedDailyDirectVehicleAndPlantIds as $ddvpid){
                if(!in_array($ddvpid,$requestDdvpIds)){
                    $dsp =  DailyDirectVehiclesAndPlant::findOrfail($ddvpid);
                    $dsp->delete();
                }
            }
        }
        //  dd($request["dailySubContractOrHiredVehicleAndPlants"]);
        if($request["dailySubContractOrHiredVehicleAndPlants"] && count($request["dailySubContractOrHiredVehicleAndPlants"])>0){
            $alreadyCreatedSubContractorHiredVehicleAndPlantIds=DailySubContractOrHiredVehiclesAndPlant::where('daily_work_record_id',$id)->pluck('id')->toArray();
            foreach ($request["dailySubContractOrHiredVehicleAndPlants"] as $dailySubContractOrHiredVehicleAndPlant) {
                if($dailySubContractOrHiredVehicleAndPlant["id"]=="NEW"){
                    unset($dailySubContractOrHiredVehicleAndPlant["id"]);
                    DailySubContractOrHiredVehiclesAndPlant::create($dailySubContractOrHiredVehicleAndPlant);
                }else{
                    $dshvp=DailySubContractOrHiredVehiclesAndPlant::findOrFail($dailySubContractOrHiredVehicleAndPlant["id"]);
                    $dshvp->update($dailySubContractOrHiredVehicleAndPlant);
                }
            }
            $requestDshvIds=array_column($request["dailySubContractOrHiredVehicleAndPlants"],'id');
            foreach($alreadyCreatedSubContractorHiredVehicleAndPlantIds as $ddvpid){
                if(!in_array($ddvpid,$requestDshvIds)){
                    $dshvp =  DailySubContractOrHiredVehiclesAndPlant::findOrfail($ddvpid);
                    $dshvp->delete();
                }
            }
        }
        return redirect('/daily-work-records/'.$id.'/step3');
    }
    public function step3($id)
    {
        $createdDailySubcontractOrClientOperations=DailySubContractClientOperation::where('daily_work_record_id',$id)->get();
        $createdDailyOrderedSuppliedMaterials=DailyOrderedSuppliedMaterial::where('daily_work_record_id',$id)->get();
        $createdDailyWeatherConditions = DailyWeatherCondition::where('daily_work_record_id',$id)->get();

        $subcontractOrClientOperationOptions = SubcontractOrClientOperation::all();
        $materialOptions = Material::all();
        $operationOptions=Operation::all();
        $dailyWorkRecordId = $id;
        return t_view('daily-works.step3',compact(
            'dailyWorkRecordId',
            'createdDailySubcontractOrClientOperations',
            'createdDailyOrderedSuppliedMaterials',
            'createdDailyWeatherConditions',
            'subcontractOrClientOperationOptions',
            'operationOptions',
            'materialOptions'

        ));
    }
    public function updateStep3(Request $request, $id)
    {
         //  dd($request["dailySubcontractOrClientOperations"]);
         if($request["dailySubcontractOrClientOperations"] && count($request["dailySubcontractOrClientOperations"])>0){
            $alreadyCreatedDailySubcontractOrClientOperationsIds=DailySubContractClientOperation::where('daily_work_record_id',$id)->pluck('id')->toArray();
            foreach ($request["dailySubcontractOrClientOperations"] as $dailySubcontractOrClientOperation) {
                if($dailySubcontractOrClientOperation["id"]=="NEW"){
                    unset($dailySubcontractOrClientOperation["id"]);
                    DailySubContractClientOperation::create($dailySubcontractOrClientOperation);
                }else{
                    $dshvp=DailySubContractClientOperation::findOrFail($dailySubcontractOrClientOperation["id"]);
                    $dshvp->update($dailySubcontractOrClientOperation);
                }
            }
            $requestDsCoIds=array_column($request["dailySubcontractOrClientOperations"],'id');
            foreach($alreadyCreatedDailySubcontractOrClientOperationsIds as $dscoid){
                if(!in_array($dscoid,$requestDsCoIds)){
                    $dsco =  DailySubContractClientOperation::findOrfail($dscoid);
                    $dsco->delete();
                }
            }
        }
        // dd($request["dailyOrderedOrSuppliedMaterials"]);
        if($request["dailyOrderedOrSuppliedMaterials"] && count($request["dailyOrderedOrSuppliedMaterials"])>0){
           $alreadyCreatedDailyOrderedOrSuppliedMaterialIds=DailyOrderedSuppliedMaterial::where('daily_work_record_id',$id)->pluck('id')->toArray();
           foreach ($request["dailyOrderedOrSuppliedMaterials"] as $dailyOrderedOrSuppliedMaterial) {
               if($dailyOrderedOrSuppliedMaterial["id"]=="NEW"){
                   unset($dailyOrderedOrSuppliedMaterial["id"]);
                   DailyOrderedSuppliedMaterial::create($dailyOrderedOrSuppliedMaterial);
               }else{
                   $dosm=DailyOrderedSuppliedMaterial::findOrFail($dailyOrderedOrSuppliedMaterial["id"]);
                   $dosm->update($dailyOrderedOrSuppliedMaterial);
               }
           }
           $requestDoSmIds=array_column($request["dailyOrderedOrSuppliedMaterials"],'id');
           foreach($alreadyCreatedDailyOrderedOrSuppliedMaterialIds as $dosmId){
               if(!in_array($dosmId,$requestDoSmIds)){
                   $dsco =  DailyOrderedSuppliedMaterial::findOrfail($dosmId);
                   $dsco->delete();
               }
           }
       }
        // dd($request["dailyWeatherConditions"]);
        if($request["dailyWeatherConditions"] && count($request["dailyWeatherConditions"])>0){
            $alreadyCreatedDailyWeatherConditionIds=DailyWeatherCondition::where('daily_work_record_id',$id)->pluck('id')->toArray();
            foreach ($request["dailyWeatherConditions"] as $dailyOrderedOrSuppliedMaterial) {
                if($dailyOrderedOrSuppliedMaterial["id"]=="NEW"){
                    unset($dailyOrderedOrSuppliedMaterial["id"]);
                    DailyWeatherCondition::create($dailyOrderedOrSuppliedMaterial);
                }else{
                    $dwc=DailyWeatherCondition::findOrFail($dailyOrderedOrSuppliedMaterial["id"]);
                    $dwc->update($dailyOrderedOrSuppliedMaterial);
                }
            }
            $requestDwcIds=array_column($request["dailyWeatherConditions"],'id');
            foreach($alreadyCreatedDailyWeatherConditionIds as $dwcId){
                if(!in_array($dwcId,$requestDwcIds)){
                    $dwc =  DailyWeatherCondition::findOrfail($dwcId);
                    $dwc->delete();
                }
            }
        }
        return redirect('/daily-work-records/'.$id.'/step4');
    }

    public function step4($id)
    {
        $operationOptions=Operation::all();
        $materialOptions = Material::all();

        $createdDailyOperationalTimingOperations = DailyOperationalTimingOperation::where('daily_work_record_id',$id)->get();
        $createdDailyOperationalTimingSuppliedMaterials = DailyOperationalTimingSuppliedMaterial::where('daily_work_record_id',$id)->get();
        $createdDailyOperationalTimingPlantHaulages = DailyOperationalTimingPlantHaulage::where('daily_work_record_id',$id)->get();
        $createdDailyOperationalTimingToClientInfos = DailyOperationalTimingToClientInfo::where('daily_work_record_id',$id)->get();

        $dailyWorkRecordId = $id;
        return t_view('daily-works.step4',compact(
            'dailyWorkRecordId',
            'operationOptions',
            'materialOptions',

            'createdDailyOperationalTimingOperations',
            'createdDailyOperationalTimingSuppliedMaterials',
            'createdDailyOperationalTimingPlantHaulages',
            'createdDailyOperationalTimingToClientInfos'

        ));
    }
    public function updateStep4(Request $request, $id)
    {
        // dd("updateStep4",$request);
        // dd($request["dailyOperationalTimingOperations"]);
        if($request["dailyOperationalTimingOperations"] && count($request["dailyOperationalTimingOperations"])>0){
            $alreadyCreatedDailyOperationalTimingOperationIds=DailyOperationalTimingOperation::where('daily_work_record_id',$id)->pluck('id')->toArray();
            foreach ($request["dailyOperationalTimingOperations"] as $dailyOperationalTimingOperation) {
                if($dailyOperationalTimingOperation["id"]=="NEW"){
                    unset($dailyOperationalTimingOperation["id"]);
                    DailyOperationalTimingOperation::create($dailyOperationalTimingOperation);
                }else{
                    $doTo=DailyOperationalTimingOperation::findOrFail($dailyOperationalTimingOperation["id"]);
                    $doTo->update($dailyOperationalTimingOperation);
                }
            }
            $requestDoToIds=array_column($request["dailyOperationalTimingOperations"],'id');
            foreach($alreadyCreatedDailyOperationalTimingOperationIds as $doToId){
                if(!in_array($doToId,$requestDoToIds)){
                    $doTo =  DailyOperationalTimingOperation::findOrfail($doToId);
                    $doTo->delete();
                }
            }
        }

        // dd($request["dailyOperationalTimingSuppliedMaterials"]);
        if($request["dailyOperationalTimingSuppliedMaterials"] && count($request["dailyOperationalTimingSuppliedMaterials"])>0){
            $alreadyCreatedDailyOperationalTimingSuppliedMaterialIds=DailyOperationalTimingSuppliedMaterial::where('daily_work_record_id',$id)->pluck('id')->toArray();
            foreach ($request["dailyOperationalTimingSuppliedMaterials"] as $dailyOperationalTimingSuppliedMaterial) {
                if($dailyOperationalTimingSuppliedMaterial["id"]=="NEW"){
                    unset($dailyOperationalTimingSuppliedMaterial["id"]);
                    DailyOperationalTimingSuppliedMaterial::create($dailyOperationalTimingSuppliedMaterial);
                }else{
                    $doTph=DailyOperationalTimingSuppliedMaterial::findOrFail($dailyOperationalTimingSuppliedMaterial["id"]);
                    $doTph->update($dailyOperationalTimingSuppliedMaterial);
                }
            }
            $requestDoTsmIds=array_column($request["dailyOperationalTimingSuppliedMaterials"],'id');
            foreach($alreadyCreatedDailyOperationalTimingSuppliedMaterialIds as $doTsmId){
                if(!in_array($doTsmId,$requestDoTsmIds)){
                    $doTsm =  DailyOperationalTimingSuppliedMaterial::findOrfail($doTsmId);
                    $doTsm->delete();
                }
            }
        }
        //
        // dd($request["dailyOperationalTimingSuppliedPlantHaulages"]);
        if($request["dailyOperationalTimingSuppliedPlantHaulages"] && count($request["dailyOperationalTimingSuppliedPlantHaulages"])>0){
            $alreadyCreatedDailyOperationalTimingPlantHaulageIds=DailyOperationalTimingPlantHaulage::where('daily_work_record_id',$id)->pluck('id')->toArray();
            foreach ($request["dailyOperationalTimingSuppliedPlantHaulages"] as $dailyOperationalTimingSuppliedPlantHaulage) {
                if($dailyOperationalTimingSuppliedPlantHaulage["id"]=="NEW"){
                    unset($dailyOperationalTimingSuppliedPlantHaulage["id"]);
                    DailyOperationalTimingPlantHaulage::create($dailyOperationalTimingSuppliedPlantHaulage);
                }else{
                    $doTph=DailyOperationalTimingPlantHaulage::findOrFail($dailyOperationalTimingSuppliedPlantHaulage["id"]);
                    $doTph->update($dailyOperationalTimingSuppliedPlantHaulage);
                }
            }
            $requestDoTphIds=array_column($request["dailyOperationalTimingSuppliedPlantHaulages"],'id');
            foreach($alreadyCreatedDailyOperationalTimingPlantHaulageIds as $doTphId){
                if(!in_array($doTphId,$requestDoTphIds)){
                    $doTph =  DailyOperationalTimingPlantHaulage::findOrfail($doTphId);
                    $doTph->delete();
                }
            }
        }
        // dd($request["dailyOperationalTimingToClientInfos"]);
        if($request["dailyOperationalTimingToClientInfos"] && count($request["dailyOperationalTimingToClientInfos"])>0){
            $alreadyCreatedDailyOperationalTimingPlantHaulageIds=DailyOperationalTimingToClientInfo::where('daily_work_record_id',$id)->pluck('id')->toArray();
            foreach ($request["dailyOperationalTimingToClientInfos"] as $dailyOperationalTimingToClientInfo) {
                if($dailyOperationalTimingToClientInfo["id"]=="NEW"){
                    unset($dailyOperationalTimingToClientInfo["id"]);
                    DailyOperationalTimingToClientInfo::create($dailyOperationalTimingToClientInfo);
                }else{
                    $doTCI=DailyOperationalTimingToClientInfo::findOrFail($dailyOperationalTimingToClientInfo["id"]);
                    $doTCI->update($dailyOperationalTimingToClientInfo);
                }
            }

        }
        return redirect('/daily-work-records/'.$id.'/step5');
    }
    public function step5($id){
        $files = Media::where('collection_name', MediaCollection::COLLECTION_DAILY_WORK_RECORD)
                        ->where('custom_properties->resource_id', $id)
                        ->get();
        $dailyWorkRecordId = $id;
        $createdDailySiteRisks = DailySiteRisk::where('daily_work_record_id',$id)->get();
        return t_view('daily-works.step5',compact(
            'dailyWorkRecordId',
            'createdDailySiteRisks',
            'files'
        ));
    }
    public function updateStep5(Request $request, $id)
    {
        // dd("updateStep5",$request);
        // dd($request["dailySiteRisks"]);
        if($request["dailySiteRisks"] && count($request["dailySiteRisks"])>0){
            $alreadyCreatedDailySiteRiskIds=DailySiteRisk::where('daily_work_record_id',$id)->pluck('id')->toArray();
            foreach ($request["dailySiteRisks"] as $dailySiteRisk) {
                if($dailySiteRisk["id"]=="NEW"){
                    unset($dailySiteRisk["id"]);
                    DailySiteRisk::create($dailySiteRisk);
                }else{
                    $dsr=DailySiteRisk::findOrFail($dailySiteRisk["id"]);
                    $dsr->update($dailySiteRisk);
                }
            }
            $requestDSRIds=array_column($request["dailySiteRisks"],'id');
            foreach($alreadyCreatedDailySiteRiskIds as $DSRId){
                if(!in_array($DSRId,$requestDSRIds)){
                    $dsr =  DailySiteRisk::findOrfail($DSRId);
                    $dsr->delete();
                }
            }
        }
        return back();
    }
}

