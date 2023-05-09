@extends('tenant.layouts.master')

@section('title') @lang('New Rate Card Marker') @endsection

@section('content')

@component('components.breadcrumb')
    @slot('li_1') Rate Cards @endslot
    @slot('title') New Marker @endslot
@endcomponent

<div class="row justify-content-center">
    <div class="col-xl-11 col-xxl-10">
        <div class="card p-2 p-xl-3 p-xxl-4">
            <div class="card-body">
                <p class="card-title-desc">Fill all information below</p>
                <form id="create-rate-card-pin" action="{{ t_route('rate-card-pins.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <x-form.input label="Name" name="name" />
                        </div>
                        <div class="col-sm-6 mb-3">
                            <x-form.select label="Unit" name="unit" :options="$units" />
                        </div>
                    </div>
                    <div class="row" data-unit="{{ AppTenant\Models\Statical\RateCardUnit::ITEM_ID }}">
                        <div class="col-12 mb-3">
                            <x-form.file-upload.single label="Icon" name="icon" 
                                text="Drop icon here or click to upload"
                                max-filesize="2"
                            />
                        </div>
                    </div>
                    <div class="row" data-unit="{{ AppTenant\Models\Statical\RateCardUnit::LINE_ID }}">
                        <div class="col-6 mb-3">
                            <x-form.select label="Line type" name="line_type" :options="$line_types" />
                        </div>
                        <div class="col-6 mb-3">
                            <x-form.color-picker label="Line color" name="line_color" />
                        </div>
                    </div>
                    <div class="row" data-unit="{{ AppTenant\Models\Statical\RateCardUnit::POLYGON_ID }}">
                        <div class="col-6 mb-3">
                            <x-form.color-picker label="Fill color" name="fill_color" />
                        </div>
                    </div>

                    <div class="row float-end row mt-5 pb-3">
                        <button type="submit" class="btn btn-success btn-rounded w-md waves-effect waves-light">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    let form = $('#create-rate-card-pin');
    let maybe_redirect = "{{ t_route('rate-card-pins') }}";
</script>

@include('tenant.rate-card-pins.create-edit-scripts')
@endpush