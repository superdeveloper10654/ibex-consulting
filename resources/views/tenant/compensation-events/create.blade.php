@extends('tenant.layouts.master')

@section('title') @lang('Create Compensation Event') @endsection

@section('content')
    <x-resource.breadcrumb :resource="\AppTenant\Models\CompensationEvent::class" title="Create Compensation Event" />

    <div class="row justify-content-center">
        <div class="col-xl-9">
            <div class="card p-5">
                <div class="card-body">
                    <p class="card-title-desc">Please complete all fields below</p>
                    <form id="create-compensation-event" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden" name="is_draft" />

                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <x-form.select label="Contract" name="contract_id" 
                                    :options="$contracts" 
                                    :selected="$compensation_event->contract_id ?? old('contract_id')"
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

                        <div class="row mb-3">
                            <div class="col-12 mb-3">
                                <x-form.select label="Early Warning" name="early_warning" :options="$early_warnings" :selected="old('early_warning')" />
                            </div>
                            <div class="col-12 mb-3">
                                <x-form.checkbox-customized label="the Contractor should have notified an Early Warning" 
                                    name="early_warning_notified" 
                                    :checked="old('early_warning_notified') == 1 ? 'checked' : false"
                                    wrapper-class="d-none"
                                />
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

@push('script')
    @include('tenant.compensation-events.create-edit-scripts')
    
    <script>
        jQuery(($) => {
            $('#create-compensation-event').on('submit', function(e) {
                e.preventDefault();
                removeFormErrors(this);

                form_ajax('{{ t_route("compensation-events.store") }}', this, {redirect: "{{ t_route('compensation-events') }}"});
            });

            @if(!empty($selected_ew_id))
                $("[name=early_warning]").val(<?= $selected_ew_id ?>).change();
            @endif
        });
    </script>
@endpush