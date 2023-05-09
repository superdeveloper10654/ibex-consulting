@extends('tenant.layouts.master')

@section('title') @lang('Daily work plan') @endsection

@section('content')

@component('components.breadcrumb')
@slot('li_1') New Daily work plan @endslot
@slot('title') Step - 01 @endslot

@endcomponent

<div class="row justify-content-center">
    <div class="col-xl-9">
        <div class="card p-5">
            <div class="card-body">
                <p class="card-title-desc">Fill all information below</p>
                {!! Form::open(array('route' => ['daily-work-records.store'], 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation')) !!}
                {!! csrf_field() !!}
                    <div class="row">
                        <div class="col-md-6">
                            <div class=" mb-3">
                                <x-form.select label="Contract" name="contract_id" :options="$contracts->pluck('contract_name', 'id')" selected="{{ old('contract_id') }}" />
                            </div>
                            <div class="mb-3">
                                <x-form.select label="Client" name="client_profile_id" :options="$client_profiles->pluck('name_with_role', 'id')" selected="{{ old('client_profile_id') }}" />
                            </div>
                            <div class="mb-3">
                                <x-form.input label="Reference No" name="reference_no" value="{{ old('reference_no') }}" />
                            </div>
                            <div class="mb-3">
                                <x-form.input label="Crew Name" name="crew_name" value="{{ old('crew_name') }}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <x-form.input type="date" label="Date" name="date" value="{{ old('date') }}" />
                            </div>
                            <div class="mb-3">
                                <x-form.input label="Site Name" name="site_name" value="{{ old('site_name') }}" />
                            </div>
                            <div class="mb-3">
                                <x-form.select label="Supervisor" name="supervisor_profile_id" :options="$supervisor_profiles->pluck('name', 'id')" selected="{{ old('supervisor_profile_id') }}" />
                            </div>
                            <div class="mb-3">
                                <x-form.input label="Foreman" name="foreman" value="{{ old('foreman') }}" />
                            </div>
                        </div>
                    </div>
                    <div class="row float-end row mt-5 pb-3">
                        <button type="submit" class="btn btn-success btn-rounded w-md waves-effect waves-light">Save & Next</button>
                    </div>
                    {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
