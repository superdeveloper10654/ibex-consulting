@extends('tenant.layouts.master')

@section('title') @lang('Daily work plan') @endsection

@section('content')

@component('components.breadcrumb')
@slot('li_1') Daily work plan @endslot
@slot('title') Edit Daily work plan #{{ $dailyWorkRecord->id }} @endslot
@endcomponent

<div class="row justify-content-center">
    <div class="col-xl-9">
        <div class="card p-5">
            <div class="card-body">
                <p class="card-title-desc">Fill all information below</p>
                {!! Form::open(array('route' => ['daily-work-records.update', $dailyWorkRecord->id], 'method' => 'PUT', 'role' => 'form', 'class' => 'needs-validation')) !!}
                {!! csrf_field() !!}
                    <div class="row">
                        <div class="col-md-6">
                            <div class=" mb-3">
                                <x-form.select label="Contract" :selected="$dailyWorkRecord->contract_id"  name="contract_id" :options="$contracts->pluck('contract_name', 'id')" />
                            </div>
                            <div class="mb-3">
                                <x-form.select label="Client Name" :selected="$dailyWorkRecord->client_profile->id"  name="client_profile_id" :options="$client_profiles->pluck('name_with_role', 'id')" />
                            </div>
                            <div class="mb-3">
                                <x-form.input label="Reference No" name="reference_no" value="{{$dailyWorkRecord->reference_no}}"/>
                            </div>
                            <div class="mb-3">
                                <x-form.input label="Crew Name" name="crew_name" value="{{$dailyWorkRecord->crew_name}}"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <x-form.input type="date" label="Date" name="date" value="{{$dailyWorkRecord->date}}"/>
                            </div>
                            <div class="mb-3">
                                <x-form.input label="Site Name" name="site_name" value="{{$dailyWorkRecord->site_name}}"/>
                            </div>
                            <div class="mb-3">
                                <x-form.select label="Supervisor" :selected="$dailyWorkRecord->supervisor_profile->id"  name="supervisor_profile_id" :options="$supervisor_profiles->pluck('name', 'id')" />
                            </div>
                            <div class="mb-3">
                                <x-form.input label="Foreman" name="foreman" value="{{$dailyWorkRecord->foreman}}"/>
                            </div>
                        </div>
                    </div>
                    <div class="row float-end ">
                        <div class="">
                            <button type="submit" class="btn btn-success btn-rounded w-md waves-effect waves-light">Update</button>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    jQuery(($) => {
        $('#edit-workplan').on('submit', function(e) {
            e.preventDefault();
            removeFormErrors(this);

            form_ajax('{{ t_route("daily-work-records.update",$dailyWorkRecord->id) }}', this, {
                redirect: "{{ t_route('daily-work-records') }}"
            });
        });

    });
</script>
@endsection
