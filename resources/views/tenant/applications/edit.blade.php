@extends('tenant.layouts.master')

@section('title') @lang('Edit Application') #{{ $application->id }} @endsection

@section('content')

@component('components.breadcrumb')
@slot('li_1') Applications @endslot
@slot('title') Edit Application #{{ $application->id }} @endslot
@endcomponent

<div class="row justify-content-center">
    <div class="col-xl-11 col-xxl-10">
        <div class="card p-2 p-xl-3 p-xxl-4">
            <div class="card-body">
                <p class="card-title-desc">Fill all information below</p>
                <form id="update-application" method="POST" autocomplete="off">
                    @csrf
                    <x-form.input type="hidden" name="application_id" :value="$application->id" />
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <x-form.select label="Contract" name="contract_id" :options="$contracts->pluck('contract_name', 'id')" :selected="$application->contract_id" />
                        </div>
                        <div class="col-sm-6 mb-3">
                            <x-form.select label="Measure" name="measure_id" :options="$measures->pluck('site_name', 'id')" :selected="$application->measure_id" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-3">
                            <x-form.input label="Title" name="title" :value="$application->title" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-3">
                            <x-form.textarea label="Notes / Comments" name="description" :value="$application->description" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <x-form.datetime-local label="Period from" name="period_from" :value="$application->period_from" />
                        </div>
                        <div class="col-sm-6 mb-3">
                            <x-form.datetime-local label="Period to" name="period_to" :value="$application->period_to" />
                        </div>
                    </div>

                    <hr>

                    <label class="form-label">Measured works</label>
                    <div class="row mt-3 mb-2" id="items-header">
                        <div class="col-md-7">
                            <label class="form-label">Item</label>
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">Qty</label>
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">Unit</label>
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">Rate £</label>
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">Sum £</label>
                        </div>
                        <div class="col-md-1">
                            <label class="form-label" style="text-align: center;">Actions</label>
                        </div>
                    </div>
                    <div id="items-container">
                        @foreach ($application->items as $i => $item)
                        <div class="row mb-3 mb-md-1 line" id="measured_items">
                            <div class="col-md-7 mb-2">
                                <select class="form-select item_select" name="items[{{ $i }}][rate_card_id]">
                                    <option value=''>Select</option>
                                    @foreach ($rate_cards as $index => $rate_card)
                                    <option value="{{ $rate_card->id }}" data-index="{{ $index }}" {{ $rate_card->id == $item->rate_card_id ? 'selected' : '' }}>{{ $rate_card->item_desc }}</option>
                                    @endforeach
                                </select>
                                <div class="text-danger" data-error="measure"></div>
                            </div>
                            <div class="col-md-1 mb-2">
                                <x-form.input name="items[{{ $i }}][qty]" class="qty" :value="$item->qty" />
                            </div>
                            <div class="col-md-1 mb-2">
                                <x-form.input name="items[{{ $i }}][unit]" class="unit" :value="$item->unit" readonly />
                            </div>
                            <div class="col-md-1 mb-2">
                                <x-form.input name="items[{{ $i }}][rate]" class="rate" :value="$item->rate" readonly />
                            </div>
                            <div class="col-md-1 mb-2">
                                <x-form.input name="items[{{ $i }}][sum]" class="sum" :value="$item->sum" readonly />
                            </div>
                            <div class="col-md-1 mb-2 text-center">
                                <button type="button" class="btn-rounded btn btn-danger btn_delete waves-effect waves-light"><i class="bx bx-trash"></i></button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="row pb-3">
                        <div class="col-7 col-md-8 pt-3">
                            <button type="button" id="btn_add" class="btn btn-sm btn-primary"><i class="mdi mdi-plus me-1"></i>&nbsp;Add Row</button>
                        </div>
                        <div class="col-2 px-1 pt-3 text-end">
                            <label class="form-label" style="padding-top: 10px;">Net £</label>
                        </div>
                        <div class="col-3 col-md-2 px-1 pt-3">
                            <x-form.input name="application_net" :value="$application->net" readonly />
                        </div>
                    </div>

                    <hr>

                    <div class="row float-end row mt-5 pb-3">
                        <button type="submit" class="btn btn-success btn-rounded w-md waves-effect waves-light">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    jQuery(($) => {
        $('#update-application').on('submit', function(e) {
            e.preventDefault();
            removeFormErrors(this);

            form_ajax('{{ t_route("applications.update", $application->id) }}', this);
        });
    });
</script>

@include('tenant.applications.create-edit-scripts')
@endsection