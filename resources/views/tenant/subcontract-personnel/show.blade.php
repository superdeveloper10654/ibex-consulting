@extends('tenant.layouts.master')

@section('title') Subcontract Personnel #{{ $subcontractPersonnel->id }} @endsection

@section('content')

@component('components.breadcrumb')
@slot('li_1') Subcontract Personnel @endslot
@slot('title') Subcontract Personnel #{{ $subcontractPersonnel->id }} @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        <div class="card p-5">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6 mb-5">
                        @if (settingGetLink(AppTenant\Models\Setting::KEY_ORGANISATION_LOGO))
                            <img src="{{ settingGetLink(AppTenant\Models\Setting::KEY_ORGANISATION_LOGO) }}" alt="logo" height="50" />
                        @endif
                    </div>
                    <div class="col-sm-6" style="text-align: right">
                        <h4 class="font-size-18 fw-bold">
                            <span class="ps-3">Subcontract Personnel #{{ $subcontractPersonnel->id }}</span>
                        </h4>
                    </div>
                </div>
                <div class="row pb-3">
                    <div class="col-sm-4">
                        <strong>Name</strong><br>
                        {{ $subcontractPersonnel->name }}
                    </div>
                    <div class="col-sm-4">
                        <strong>Subbie name</strong><br>
                        {{ $subcontractPersonnel->subbie_name }}
                    </div>
                    <div class="col-sm-4">
                        <strong>Role</strong><br>
                        {{ $subcontractPersonnel->role }}
                    </div>
                </div>
                <div class="d-print-none">
                    <div class="float-end">
                        <a href="javascript:window.print()" class="btn btn-secondary btn-rounded w-md waves-effect waves-light"><i class="fa fa-print me-1"></i>&nbsp;Print</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection