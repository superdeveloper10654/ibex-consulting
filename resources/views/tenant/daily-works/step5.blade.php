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
@slot('title') Step - 05 @endslot
@endcomponent

<div class="row justify-content-center">
    <div class="col-xl-9">
                {!! Form::open(array('route' => ['daily-work-records.updateStep5', $dailyWorkRecordId], 'method' => 'PUT', 'role' => 'form', 'class' => 'needs-validation')) !!}
                {!! csrf_field() !!}
                
                <div class="card">
                    <div class="card-body" >
                        <h4 class="card-title text-center">Site Problems/ Risks/ Issues/ Narrative of work</label>
                        </h4><hr/>
                        <div id="dailySiteRisks-container"></div>
                        
                            <div class="row mb-1">
                                <div class="col-7 col-md-8">
                                    <button type="button" id="btn_dailyDailySiteRisks_add" class="btn btn-sm btn-primary"><i class="mdi mdi-plus me-1"></i>&nbsp;Add Row</button>
                                </div>
                            </div>
                            <div class="row float-end mt-5">
                                    <button type="submit" class="btn btn-success btn-rounded w-md waves-effect waves-light">Save</button>
                            </div>
                    </div>
                </div>
               
               
                
                {!! Form::close() !!}
                <div class="card">
                    <div class="card-body" >
                        <h4 class="card-title text-center">Photographic Evidence</label></h4>
                        <hr/>
                        <ul class="nav nav-tabs" id="myTab" role="tablist" hidden>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="uploads-tab" data-bs-toggle="tab" data-bs-target="#uploads" type="button" role="tab" aria-controls="uploads" aria-selected="true">Uploads</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="uploads" role="tabpanel" aria-labelledby="uploads-tab">
                        <x-uploads.files-list :files="$files" :folder="AppTenant\Models\Statical\MediaCollection::COLLECTION_DAILY_WORK_RECORD" :resource-id="$dailyWorkRecordId" hide-empty-list="true">
                                <div>
                                    <ul class="list-group" data-simplebar="init" style="max-height: 350px;">
                                        <div class="simplebar-wrapper" style="margin: 0px;">
                                            <div class="simplebar-height-auto-observer-wrapper">
                                                <div class="simplebar-height-auto-observer"></div>
                                            </div>
                                            <div class="simplebar-mask">
                                                <div class="simplebar-offset" style="right: -16.8px; bottom: 0px;">
                                                    <div class="simplebar-content-wrapper" style="height: auto; overflow: hidden scroll; padding-right: 20px; padding-bottom: 0px;">
                                                        <div class="simplebar-content" style="padding: 0px;">
                                                            <div class="mb-3">
                                                            <p class="text-muted text-center"><i class="bx bx-info-circle"></i>&nbsp;<small>You can upload any related documents and zipped folders here. These will be listed below</small></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="simplebar-placeholder" style="width: 351px; height: 512px;"></div>
                                        </div>
                                        <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                            <div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div>
                                        </div>
                                        <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                                            <div class="simplebar-scrollbar" style="height: 297px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
                                        </div>
                                    </ul>
                                </div>
                                <div class="mb-3 text-center d-print-none">
                                    <hr>
                                    <button type="button" class="btn btn-secondary btn-rounded w-md waves-effect waves-light" onclick="$('#new-files').click()">
                                        <i class="mdi mdi-upload me-1"></i>&nbsp;Upload
                                    </button>
                                </div>
                            </x-uploads.files-list>
                        </div>
                        </div>
                        <div class="row mt-5">
                            <div>
                                <div class="float-start">
                                    <a href= "{{ URL::to('daily-work-records/' .$dailyWorkRecordId.'/step4') }}"><button type="button"  class="btn btn-primary btn-rounded w-md waves-effect waves-light">Back</button></a>
                                </div>
                                <div class="float-end ">
                                    <a href= "{{ URL::to('daily-work-records') }}"><button type="button"  class="btn btn-success btn-rounded w-md waves-effect waves-light">Finish</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    </div>
</div>
@endsection

@section('script')
@include('tenant.daily-works.scripts.dynamic-step5-scripts')
@endsection