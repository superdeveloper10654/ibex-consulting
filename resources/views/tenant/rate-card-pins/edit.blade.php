@extends('tenant.layouts.master')

@section('title') @lang('Edit Rate Card Marker') {{ $pin->id }} @endsection

@section('content')

@component('components.breadcrumb')
    @slot('li_1') Rate Cards @endslot
    @slot('title') Edit Marker {{ $pin->id }} @endslot
@endcomponent

<div class="row justify-content-center">
    <div class="col-xl-11 col-xxl-10">
        <div class="card p-2 p-xl-3 p-xxl-4">
            <div class="card-body">
                <p class="card-title-desc">Fill all information below</p>
                <form id="edit-rate-card-pin" action="{{ t_route('rate-card-pins.update', $pin->id) }}">
                    @csrf
                    <input type="hidden" name="remove_icon" />
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <x-form.input label="Name" name="name" :value="$pin->name" />
                        </div>
                        <div class="col-sm-6 mb-3">
                            <x-form.select label="Unit" name="unit" :options="$units" :selected="$pin->rate_card_unit" />
                        </div>
                    </div>
                    <div class="row" data-unit="{{ AppTenant\Models\Statical\RateCardUnit::ITEM_ID }}">
                        <div class="col-12 mb-3">
                            <x-form.file-upload.single label="Icon" name="icon" 
                                text="Drop icon here or click to upload"
                                max-filesize="2"
                                :existing-file="!empty($pin->icon) ? $pin->icon_url : ''"
                            />
                        </div>
                    </div>
                    <div class="row" data-unit="{{ AppTenant\Models\Statical\RateCardUnit::LINE_ID }}">
                        <div class="col-6 mb-3">
                            <x-form.select label="Line type" name="line_type" :options="$line_types" :selected="$pin->line_type" />
                        </div>
                        <div class="col-6 mb-3">
                            <x-form.color-picker label="Line color" name="line_color" :value="$pin->line_color" />
                        </div>
                    </div>
                    <div class="row" data-unit="{{ AppTenant\Models\Statical\RateCardUnit::POLYGON_ID }}">
                        <div class="col-6 mb-3">
                            <x-form.color-picker label="Fill color" name="fill_color" :value="$pin->fill_color" />
                        </div>
                    </div>

                    <div class="row float-end row mt-5 pb-3">
                        <button type="submit" class="btn btn-success btn-rounded w-md waves-effect waves-light">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    let form = $('#edit-rate-card-pin');
    let unit_id = '{{ $pin->rate_card_unit }}';
    
    @if (!empty($pin->icon))
        let icon_url = '{{ $pin->icon_url }}';
    @endif
</script>
@include('tenant.rate-card-pins.create-edit-scripts')

@endpush