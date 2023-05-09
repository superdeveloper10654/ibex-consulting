@extends('tenant.layouts.master')

@section('title') @lang('Daily work plan') @endsection

@section('content')

@component('components.breadcrumb')
@slot('li_1') New Daily work plan @endslot
@slot('title') Step - 02 @endslot
@endcomponent

<div class="row justify-content-center">
    <div class="col-xl-9">
                {!! Form::open(array('route' => ['daily-work-records.updateStep2', $dailyWorkRecordId], 'method' => 'PUT', 'role' => 'form', 'class' => 'needs-validation')) !!}
                {!! csrf_field() !!}
                <div class="card">
                    <div class="card-body" >
                        <h4 class="card-title text-center">Direct Personnel</label>
                        </h4>
                        <hr/>
                        <div class="row mb-3">
                            
                                <div class="col-md-1">
                                    <label class="form-label">#</label>
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label">Direct personnel</label>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Worked hours</label>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label" style="text-align: center;"></label>
                                </div>
                            <div id="daily-direct-personnel-container"></div>
                            <div class="row mb-1">
                                <div class="col-7 col-md-8">
                                    <button type="button" id="btn_direct_personnel_add" class="btn btn-sm btn-primary"><i class="mdi mdi-plus me-1"></i>&nbsp;Add Row</button>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body" >
                        <h4 class="card-title text-center">Daily Sub Contract Personnel</label>
                        </h4>
                        <hr/>
                        <div class="row mb-3">
                            
                                <div class="col-md-1">
                                    <label class="form-label">#</label>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label">Sub Contract personnel</label>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label">Worked hours</label>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Comments</label>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label" style="text-align: center;"></label>
                                </div>
                            <div id="daily-subContract-personnel-container"></div>
                            <div class="row mb-1">
                                <div class="col-7 col-md-8">
                                    <button type="button" id="btn_subcontract_personnel_add" class="btn btn-sm btn-primary"><i class="mdi mdi-plus me-1"></i>&nbsp;Add Row</button>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body" >
                        <h4 class="card-title text-center">Daily Direct Vehicles And Plants</label>
                        </h4>
                        <hr/>
                        <div class="row mb-3">
                                <div class="col-md-1">
                                    <label class="form-label">#</label>
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label">Direct Vehicles And Plants</label>
                                </div>
                                <div class="col-md-2" hidden>
                                    <label class="form-label">Comments</label>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label" style="text-align: center;"></label>
                                </div>
                            <div id="dailyDirectVehicleAndPlants-container"></div>
                            <div class="row mb-1">
                                <div class="col-7 col-md-8">
                                    <button type="button" id="btn_dailyDirectVehicleAndPlants__add" class="btn btn-sm btn-primary"><i class="mdi mdi-plus me-1"></i>&nbsp;Add Row</button>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body" >
                        <h4 class="card-title text-center">Daily Subcontract / Hired Vehicles And Plants</label>
                        </h4>
                        <hr/>
                        <div class="row mb-3">
                                <div class="col-md-1">
                                    <label class="form-label">#</label>
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label">Subcontract / Hired Vehicles And Plants</label>
                                </div>
                                <div class="col-md-2" hidden>
                                    <label class="form-label">Comments</label>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label" style="text-align: center;"></label>
                                </div>
                            <div id="dailySubContractOrHiredVehicleAndPlants-container"></div>
                            <div class="row mb-1">
                                <div class="col-7 col-md-8">
                                    <button type="button" id="btn_dailySubContractOrHiredVehicleAndPlants__add" class="btn btn-sm btn-primary"><i class="mdi mdi-plus me-1"></i>&nbsp;Add Row</button>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body" >
                    <div class="row">
                        <div>
                            <div class="float-start">
                            <a href= "{{ URL::to('daily-work-records/' .$dailyWorkRecordId.'/edit') }}"><button type="button"  class="btn btn-primary btn-rounded w-md waves-effect waves-light">Back</button></a>
                            </div>
                            <div class="float-end ">
                                <button type="submit" class="btn btn-success btn-rounded w-md waves-effect waves-light">Save & Next</button>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                {!! Form::close() !!}
    </div>
</div>
@endsection

@section('script')
@include('tenant.daily-works.scripts.dynamic-step2-scripts')
@endsection