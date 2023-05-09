@extends('tenant.layouts.master')

@section('title') Edit Quotation {{ $quotation->title }} @endsection

@section('content')
    <x-resource.breadcrumb :resource="$quotation" :title="'Edit Quotation ' . $quotation->title" />

    <div class="row justify-content-center">
        <div class="col-xl-9">
            <div class="card p-5">
                <div class="card-body">
                    <p class="card-title-desc">Please complete all fields below</p>
                    <form id="edit-quotation" method="POST" autocomplete="off">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <x-form.select label="Contract" name="contract" 
                                    :options="$contracts" 
                                    :selected="old('contract', $quotation->contract->id)"
                                    show-option-custom-attrs
                                />
                            </div>
                            <div class="col-sm-6 mb-3">
                                <x-form.select label="Programme" name="programme"
                                    :options="$programmes"
                                    :selected="old('programme', $quotation->programme_id)" 
                                />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <x-form.input label="Title" name="title" :value="old('title', $quotation->title)" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="mb-3">
                                <x-form.textarea label="Description" name="description"
                                    :value="old('description', $quotation->description)"
                                />
                            </div>
                        </div>
                        
                        <div class="row border-top border-bottom py-3">
                            <div class="col-12">
                                <div class="card-title mb-2">Proposed effect of Contract Dates</div>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <x-form.input type="number" label="Completion Date effect (+/- days)"
                                    name="contract_completion_date_effect"
                                    :value="old('contract_completion_date_effect', $quotation->contract_completion_date_effect)" 
                                    disabled
                                />
                            </div>
                            <div class="col-sm-6 mb-4">
                                <x-form.input type="date" label="Completion Date"
                                    name="contract_completion_date"
                                    :value="old('contract_completion_date')"
                                    disabled
                                />
                            </div>

                            <div class="col-sm-6 mb-3">
                                <x-form.input type="number" label="Key Date 1 effect (+/- days)"
                                    name="contract_key_date_1_effect"
                                    :value="old('contract_key_date_1_effect', $quotation->contract_key_date_1_effect)"
                                    disabled
                                />
                            </div>
                            <div class="col-sm-6 mb-3">
                                <x-form.input type="date" label="Key Date 1"
                                    name="contract_key_date_1"
                                    :value="old('contract_key_date_1')"
                                    disabled
                                />
                            </div>
                            <div class="col-sm-6 mb-3">
                                <x-form.input type="number" label="Key Date 2 effect (+/- days)"
                                    name="contract_key_date_2_effect"
                                    :value="old('contract_key_date_2_effect', $quotation->contract_key_date_2_effect)"
                                    disabled
                                />
                            </div>
                            <div class="col-sm-6 mb-3">
                                <x-form.input type="date" label="Key Date 2"
                                    name="contract_key_date_2"
                                    :value="old('contract_key_date_2')"
                                    disabled
                                />
                            </div>
                            <div class="col-sm-6 mb-3">
                                <x-form.input type="number" label="Key Date 3 effect (+/- days)"
                                    name="contract_key_date_3_effect"
                                    :value="old('contract_key_date_3_effect', $quotation->contract_key_date_3_effect)"
                                    disabled
                                />
                            </div>
                            <div class="col-sm-6 mb-3">
                                <x-form.input type="date" label="Key Date 3"
                                    name="contract_key_date_3"
                                    :value="old('contract_key_date_3')"
                                    disabled
                                />
                            </div>
                        </div>

                        @php
                            // todo: add displaying of total contract price
                        @endphp
                        <div class="row border-top border-bottom py-3">
                            <div class="col-12">
                                <div class="card-title mb-2">Proposed effect to Price</div>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <x-form.input type="number" label="Price effect (+/- £)"
                                    name="price_effect"
                                    :value="old('price_effect', $quotation->price_effect)"
                                    step='10'
                                />
                            </div>
                        </div>

                        <div class="row float-end mt-5 pb-3">
                            <div class="col-6">
                                <button type="submit" class="btn btn-success btn-rounded w-md waves-effect waves-light">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('tenant.quotations.create-edit-scripts')

@push('script')
    <script>
        jQuery(($) => {
            $('#edit-quotation').on('submit', function(e) {
                e.preventDefault();
                removeFormErrors(this);

                form_ajax('{{ t_route("quotations.update", $quotation->id) }}', this, {redirect: "{{ t_route('quotations') }}"});
            });

            $.each($('#contract, #contract_completion_date_effect, #contract_key_date_1_effect, #contract_key_date_2_effect, #contract_key_date_3_effect'), (i, el) => {
                $(el).change(); // trigger contract date update
            });
        });
    </script>
@endpush