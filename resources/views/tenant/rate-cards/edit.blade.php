@extends('tenant.layouts.master')

@section('title') @lang('New Rate Card') @endsection

@section('content')

@component('components.breadcrumb')
@slot('li_1') Settings @endslot
@slot('title') Edit Rate Card @endslot
@endcomponent

<div class="row justify-content-center">
    <div class="col-xl-11 col-xxl-10">
        <div class="card p-2 p-xl-3 p-xxl-4">
            <div class="card-body">
                <p class="card-title-desc">Fill all information below</p>
                <form id="edit-rate-card" method="POST" autocomplete="off">
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <x-form.select label="Contract" name="contract_id" :options="$contracts" selected="{{$rateCard->contract_id}}" />
                        </div>
                        <div class="col-sm-6 mb-3">
                            <x-form.select label="Unit" name="unit" :options="$units" selected="{{$rateCard->unitId}}" />
                        </div>
                        <div class="col-sm-12 mb-3">
                            <x-form.select label="Marker" name="pin_id" :options="$pins" selected="{{$rateCard->pin_id}}" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3">
                            <x-form.input label="Reference" name="ref" value="{{$rateCard->ref}}" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3">
                            <x-form.input type='number' label="Rate £" name="rate" step="0.01" value="{{$rateCard->rate}}" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3">
                            <x-form.textarea label="Description" name="item_desc" value="{{$rateCard->item_desc}}" />
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
    jQuery(($) => {
        $('#edit-rate-card').on('submit', function(e) {
            e.preventDefault();
            removeFormErrors(this);

            form_ajax('{{ t_route("rate-cards.update", $rateCard->id) }}', this, {redirect: "{{ t_route('rate-cards.show', $rateCard->id) }}"});
        });
    });
</script>
@endpush