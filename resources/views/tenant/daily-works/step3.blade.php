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
@slot('title') Step - 03 @endslot
@endcomponent

<div class="row justify-content-center">
    <div class="col-xl-9">
                {!! Form::open(array('route' => ['daily-work-records.updateStep3', $dailyWorkRecordId], 'method' => 'PUT', 'role' => 'form', 'class' => 'needs-validation')) !!}
                {!! csrf_field() !!}
                <div class="card">
                    <div class="card-body" >
                        <h4 class="card-title text-center">Sub Contract / Client Operations</label>
                        </h4>
                        <hr/>
                        <div class="row mb-3">
                                <div class="col-md-1">
                                    <label class="form-label">#</label>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Company name</label>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Operation</label>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Comments</label>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label" style="text-align: center;"></label>
                                </div>
                            <div id="dailySubcontractOrClientOperations-container"></div>
                            <div class="row mb-1">
                                <div class="col-7 col-md-8">
                                    <button type="button" id="btn_dailySubcontractOrClientOperations_add" class="btn btn-sm btn-primary"><i class="mdi mdi-plus me-1"></i>&nbsp;Add Row</button>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body" >
                        <h4 class="card-title text-center">Material Ordered/ Supplied</label>
                        </h4>
                        <hr/>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Name/ Description</label>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Prog'd (t)</label>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">On site (t)</label>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Supplied (t)</label>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Comments</label>
                            </div>
                            <div class="col-md-1">
                                <label class="form-label"></label>
                            </div>
                        </div>
                        <div id="dailyOrderedOrSuppliedMaterials-container"></div>
                        <div class="row mb-1">
                            <div class="col-7 col-md-2">
                                <button type="button" id="btn_dailyOrderedOrSuppliedMaterials_add" class="btn btn-sm btn-primary"><i class="mdi mdi-plus me-1"></i>&nbsp;Add Row</button>
                            </div>
                            <div class="col-md-1 mb-2">
                            <span class="form-label ml-2">Totals</span>
                            </div>
                            <div class="col-md-2 mb-2">
                                <x-form.input name="sum_of_prog" id="sumOfProg" class="act-no" readonly/>
                            </div>
                            <div class="col-md-2 mb-2">
                                <x-form.input name="sum_of_onsite" id="sumOfOnsite" class="act-no" readonly/>
                            </div>
                            <div class="col-md-2 mb-2">
                                <x-form.input name="sum_of_supplied" id="sumOfSupplied" class="act-no" readonly/>
                            </div>
                            <div class="col-md-2 mb-2">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body" >
                        <h4 class="card-title text-center">Weather Conditions</label>
                        </h4>
                        <hr/>
                        <div class="row mb-3">
                                
                                <div class="col-md-3">
                                    <label class="form-label">Time</label>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Observation</label>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Air (°C)</label>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Ground (°C)</label>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Wind (km/h)</label>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label" style="text-align: center;"></label>
                                </div>
                            <div id="dailyWeatherConditions-container"></div>
                            <div class="row mb-1">
                                <div class="col-7 col-md-8">
                                    <button type="button" id="btn_dailyWeatherConditions_add" class="btn btn-sm btn-primary"><i class="mdi mdi-plus me-1"></i>&nbsp;Add Row</button>
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
                            <a href= "{{ URL::to('daily-work-records/' .$dailyWorkRecordId.'/step2') }}"><button type="button"  class="btn btn-primary btn-rounded w-md waves-effect waves-light">Back</button></a>
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
@include('tenant.daily-works.scripts.dynamic-step3-scripts')
@endsection