@extends('tenant.layouts.master')

@section('title') Direct Personnel #{{ $directPersonnel->id }} @endsection

@section('content')

@component('components.breadcrumb')
@slot('li_1') Direct Personnel @endslot
@slot('title') Direct Personnel #{{ $directPersonnel->id }} @endslot
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
                            <span class="ps-3">Direct Personnel #{{ $directPersonnel->id }}</span>
                        </h4>
                    </div>
                </div>
                <div class="row col-md-12 pb-3">
                    <div class="col-sm-4">
                        <label class="form-label">Name</label><br>
                        {{ $directPersonnel->name }}
                    </div>
                    <div class="col-sm-4">
                        <label class="form-label">Role</label><br>
                        {{ $directPersonnel->role }}
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