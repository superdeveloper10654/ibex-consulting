@extends('tenant.layouts.master')

@section('title') @lang('Daily work plan') @endsection
@section('css')
<style>
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}

</style>
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') New Daily work plan @endslot
@slot('title') Step - 04 @endslot
@endcomponent

<div class="row justify-content-center">
    <div class="col-xl-9">
                {!! Form::open(array('route' => ['daily-work-records.updateStep4', $dailyWorkRecordId], 'method' => 'PUT', 'role' => 'form', 'class' => 'needs-validation')) !!}
                {!! csrf_field() !!}
                
                <div class="card">
                    <div class="card-body" >
                        <h4 class="card-title text-center">Operational Timings</label>
                        </h4>
                        <hr/>
                        <div class="row mb-3">
                                
                                <div class="col-md-4">
                                    <label class="form-label">Operation</label>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Started</label>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Completed</label>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Comments</label>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label" style="text-align: center;"></label>
                                </div>
                            <div id="dailyOperationalTimingOperations-container"></div>
                            <div class="row mb-1">
                                <div class="col-7 col-md-8">
                                    <button type="button" id="btn_dailyOperationalTimingOperations_add" class="btn btn-sm btn-primary"><i class="mdi mdi-plus me-1"></i>&nbsp;Add Row</button>
                                </div>
                            </div>
                        </div>

                        <hr/>
                        <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Material Supplies</label>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Started</label>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Completed</label>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Comments</label>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label" style="text-align: center;"></label>
                                </div>
                            <div id="dailyOperationalTimingSuppliedMaterials-container"></div>
                            <div class="row mb-1">
                                <div class="col-7 col-md-8">
                                    <button type="button" id="btn_dailyOperationalTimingSuppliedMaterials_add" class="btn btn-sm btn-primary"><i class="mdi mdi-plus me-1"></i>&nbsp;Add Row</button>
                                </div>
                            </div>
                        </div>

                        <hr/>
                        <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Plant Haulage</label>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Started</label>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Completed</label>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Comments</label>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label" style="text-align: center;"></label>
                                </div>
                            <div id="dailyOperationalTimingSuppliedPlantHaulages-container"></div>
                            <div class="row mb-1">
                                <div class="col-7 col-md-8">
                                    <button type="button" id="btn_dailyOperationalTimingSuppliedPlantHaulages_add" class="btn btn-sm btn-primary"><i class="mdi mdi-plus me-1"></i>&nbsp;Add Row</button>
                                </div>
                            </div>
                        </div>

                        <hr/>
                        <div class="row mb-3">
                                <div class="col-md-3">
                                    <label class="form-label">Demobilised/ Off-Site</label>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Informed the Client</label>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Comments to Client</label>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label" style="text-align: center;"></label>
                                </div>
                            <div id="dailyOperationalTimingToClientInfos-container"></div>
                            <!-- <div class="row mb-1">
                                <div class="col-7 col-md-8">
                                    <button type="button" id="btn_dailyOperationalTimingSuppliedPlantHaulages_add" class="btn btn-sm btn-primary"><i class="mdi mdi-plus me-1"></i>&nbsp;Add Row</button>
                                </div>
                            </div> -->
                        </div>

                    </div>
                </div>
                <div class="card">
                    <div class="card-body" >
                    <div class="row">
                        <div>
                            <div class="float-start">
                            <a href= "{{ URL::to('daily-work-records/' .$dailyWorkRecordId.'/step3') }}"><button type="button"  class="btn btn-primary btn-rounded w-md waves-effect waves-light">Back</button></a>
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
@include('tenant.daily-works.scripts.dynamic-step4-scripts')
@endsection