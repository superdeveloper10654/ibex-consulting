@extends('tenant.layouts.master')

@section('title') @lang('Edit Assessment') #{{ $assessment->id }} @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Assessments @endslot
        @slot('title') Edit Assessment #{{ $assessment->id }} @endslot
    @endcomponent

    <div class="row justify-content-center">
        <div class="col-xl-11 col-xxl-10">
            <div class="card p-2 p-xl-3 p-xxl-4">
                <div class="card-body">
                    <p class="card-title-desc">Fill all information below</p>
                    <form id="edit-assessment" method="POST" autocomplete="off">
                        @csrf
                        <x-form.input type="hidden" name="assessment_id" :value="$assessment->id" />
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <x-form.select label="Contract" name="contract" :options="$contracts->pluck('contract_name', 'id')" :selected="$assessment->contract_id" />
                            </div>
                            <div class="col-sm-6 mb-3">
                                <x-form.input label="Title" name="title" :value="$assessment->title" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <x-form.textarea label="Description" name="description" :value="$assessment->description" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <x-form.datetime-local label="Period from" name="period_from" :value="$assessment->period_from" />
                            </div>
                            <div class="col-sm-6 mb-3">
                                <x-form.datetime-local label="Period to" name="period_to" :value="$assessment->period_to" />
                            </div>
                        </div>

                        <hr>

                        <label class="form-label">Measured works</label>
                        <div class="row mt-3 mb-2" id="items-header">
                            <div class="col-md-4">
                                <label class="form-label">Item</label>
                            </div>
                            <div class="col-md-1">
                                <label class="form-label">Qty</label>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Unit</label>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Rate £</label>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Sum £</label>
                            </div>
                            <div class="col-md-1">
                                <label class="form-label" style="text-align: center;">Actions</label>
                            </div>
                        </div>
                        <div id="items-container"></div>

                        <div class="row pb-3">
                            <div class="col-7 col-md-8 pt-3">
                                <button type="button" id="btn_add" class="btn btn-sm btn-primary"><i class="mdi mdi-plus me-1"></i>&nbsp;Add Row</button>
                            </div>
                            <div class="col-2 px-1 pt-3 text-end">
                                <label class="form-label" style="padding-top: 10px;">Net £</label>
                            </div>
                            <div class="col-3 col-md-2 px-1 pt-3">
                                <x-form.input name="net" :value="$assessment->net" readonly />
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

@push('script')
    @include('tenant.assessments.create-edit-scripts')

    <script>
        jQuery(($) => {
            $('#edit-assessment').on('submit', function(e) {
                e.preventDefault();
                removeFormErrors(this);

                form_ajax('{{ t_route("assessments.update", $assessment->id) }}', this, {redirect: "{{ t_route('assessments') }}"});
            });

            @foreach ($assessment->items as $item)
                addMeasuredItemsRow(@json($item));
            @endforeach
        });
    </script>
@endpush