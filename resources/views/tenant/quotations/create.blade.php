@extends('tenant.layouts.master')

@section('title') Create Quotation @endsection

@section('content')
    <x-resource.breadcrumb :resource="\AppTenant\Models\Quotation::class" title="Create Quotation" />

    <div class="row justify-content-center">
        <div class="col-xl-9">
            <div class="card p-5">
                <div class="card-body">
                    <p class="card-title-desc">Please complete all fields below</p>
                    <form id="create-quotation" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden" name="is_draft" />

                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <x-form.select label="Contract" name="contract" 
                                    :options="$contracts" 
                                    :selected="$quotation->contract_id ?? old('contract')"
                                    show-option-custom-attrs
                                />
                            </div>
                            <div class="col-sm-6 mb-3">
                                <x-form.select label="Programme" name="programme" :options="$programmes" :selected="old('programme')" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 mb-3">
                                <x-form.input label="Title" name="title" :value="old('title')" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="mb-3">
                                <x-form.textarea label="Description" name="description" :value="old('description')" />
                            </div>
                        </div>
                        
                        <div class="row border-top border-bottom py-3">
                            <div class="col-12">
                                <div class="card-title mb-2">Proposed effect of Contract Dates</div>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <x-form.input type="number" label="Completion Date effect (+/- days)" name="contract_completion_date_effect" :value="old('contract_completion_date_effect', 0)" disabled />
                            </div>
                            <div class="col-sm-6 mb-4">
                                <x-form.input type="date" label="Completion Date" name="contract_completion_date" :value="old('contract_completion_date')" disabled />
                            </div>

                            <div class="col-12 date-effects-wrapper">
                                <div class="row">
                                    <div class="col-sm-6 mb-3">
                                        <x-form.input type="number" label="Key Date 1 effect (+/- days)" name="contract_key_date_1_effect" :value="old('contract_key_date_1_effect', 0)" disabled />
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <x-form.input type="date" label="Key Date 1" name="contract_key_date_1" :value="old('contract_key_date_1')" disabled />
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <x-form.input type="number" label="Key Date 2 effect (+/- days)" name="contract_key_date_2_effect" :value="old('contract_key_date_2_effect', 0)" disabled />
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <x-form.input type="date" label="Key Date 2" name="contract_key_date_2" :value="old('contract_key_date_2')" disabled />
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <x-form.input type="number" label="Key Date 3 effect (+/- days)" name="contract_key_date_3_effect" :value="old('contract_key_date_3_effect', 0)" disabled />
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <x-form.input type="date" label="Key Date 3" name="contract_key_date_3" :value="old('contract_key_date_3')" disabled />
                                    </div>
                                </div>
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
                                <x-form.input type="number" label="Price effect (+/- £)" name="price_effect" :value="old('price_effect', 0)" step='10' />
                            </div>
                        </div>

                        <div class="row float-end mt-5 pb-3">
                            <div class="col-6">
                                <button type="button" onclick="saveAsDraft(this)" class="btn btn-secondary btn-rounded w-md waves-effect waves-light">Save Draft</button>
                            </div>
                            <div class="col-6">
                                <button type="submit" class="btn btn-success btn-rounded w-md waves-effect waves-light">Create</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('tenant.quotations.create-edit-scripts')

@section('script')
    <script>
        jQuery(($) => {
            $('#create-quotation').on('submit', function(e) {
                e.preventDefault();
                removeFormErrors(this);

                form_ajax('{{ t_route("quotations.store") }}', this, {redirect: "{{ t_route('quotations') }}"});
            });
        });
    </script>
@endsection