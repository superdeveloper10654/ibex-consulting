@extends('tenant.layouts.master')

@section('title') @lang('New Application') @endsection

@section('content')

@component('components.breadcrumb')
@slot('li_1') Applications @endslot
@slot('title') New Application @endslot
@endcomponent

    <div class="row justify-content-center">
        <div class="col-xl-11 col-xxl-10">
            <div class="card p-2 p-xl-3 p-xxl-4">
                <div class="card-body">
                    <p class="card-title-desc">Fill all information below</p>
                    <form id="create-application" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden" name="status_draft" >
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <x-form.select label="Contract" name="contract_id" :options="$contracts->pluck('contract_name', 'id')" />
                            </div>
                            <div class="col-sm-6 mb-3">
                                <x-form.select label="Measure" name="measure_id" :options="$measures->pluck('site_name', 'id')" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <x-form.input label="Title" name="title" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <x-form.textarea label="Notes / Comments" name="description" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <x-form.datetime-local label="Period from" name="period_from" />
                            </div>
                            <div class="col-sm-6 mb-3">
                                <x-form.datetime-local label="Period to" name="period_to" />
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
                        <div id="items-container"></div>
                        <div class="row pb-3">
                            <div class="col-7 col-md-8 pt-3">
                                <button type="button" id="btn_add" class="btn btn-sm btn-primary"><i class="mdi mdi-plus me-1"></i>&nbsp;Add Row</button>
                            </div>
                            <div class="col-2 px-1 pt-3 text-end">
                                <label class="form-label" style="padding-top: 10px;">Net £</label>
                            </div>
                            <div class="col-3 col-md-2 px-1 pt-3">
                                <x-form.input name="application_net" readonly />
                            </div>
                        </div>

                        <hr>

                        <div class="float-end mt-5 pb-3">
                            <button type="button" id="save-draft" class="btn btn-secondary btn-rounded w-md waves-effect waves-light me-3">Save Draft</button>
                            <button type="submit" class="btn btn-success btn-rounded w-md waves-effect waves-light">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        let contract_to_measures_arr = [
            @foreach ($contracts as $contract)
                {
                    contract_id : {{ $contract->id }},
                    measures    : [
                        @foreach ($contract->measures as $measure)
                            {{ $measure->id }},
                        @endforeach
                    ],
                },
            @endforeach
        ];

        jQuery(($) => {
            $('#create-application').on('submit', function(e) {
                e.preventDefault();
                removeFormErrors(this);

                form_ajax('{{ t_route("applications.store") }}', this, {redirect: "{{ t_route('applications') }}"});
            });

            $('#save-draft').on('click', function() {
                $('input[name=status_draft]').val(1);
                $('#create-application').submit();
            });

            // show appropriate measures list for selected contract
            $('#contract_id').on('change', function() {
                let contract_to_measure = contract_to_measures_arr.find((contract) => contract.contract_id == this.value);
                $('#measure_id').val('');
                $.each($('#measure_id option'), function(i, option) {
                    option = $(option).show();
                    if (!contract_to_measure.measures.includes(Number(option.val()))) {
                        option.hide();
                    }
                });
            });
        });
    </script>

@include('tenant.applications.create-edit-scripts')
@endsection