@extends('tenant.layouts.master')

@section('title') Edit Compensation Event {{ $event->title }} @endsection

@section('content')
    <x-resource.breadcrumb :resource="$event" :title="'Edit Compensation Event ' . $event->title" />

    <div class="row justify-content-center">
        <div class="col-xl-9">
            <div class="card p-5">
                <div class="card-body">
                    <p class="card-title-desc">Please complete all fields below</p>
                    <form id="edit-compensation-event" method="POST" autocomplete="off">
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="is_draft" />

                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <x-form.select label="Contract" name="contract" 
                                    :options="$contracts" 
                                    :selected="old('contract', $event->programme->contract_id)"
                                />
                            </div>
                            <div class="col-sm-6 mb-3">
                                <x-form.select label="Programme" name="programme" 
                                    :options="$programmes" 
                                    :selected="old('programme', $event->programme->id)"
                                />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 mb-3">
                                <x-form.input label="Title" name="title" :value="old('title', $event->title)" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="mb-3">
                                <x-form.textarea label="Description" name="description" :value="old('description', $event->description)" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12 mb-3">
                                <x-form.select label="Early Warning" name="early_warning"
                                    :options="$early_warnings"
                                    :selected="old('early_warning', ($event->early_warning_id))"
                                />
                            </div>
                            <x-form.checkbox-customized label="the Contractor should have notified an Early Warning" 
                                name="early_warning_notified" 
                                :checked="old('early_warning_notified', $event->early_warning_notified) == 1 ? 'checked' : false" 
                            />
                        </div>


                        <div class="row mt-5 pb-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-success btn-rounded w-md waves-effect waves-light float-end">
                                    @if ($event->isDraft())
                                        Update and Notify
                                    @else
                                        Update
                                    @endif
                                </button>
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
            $('#edit-compensation-event').on('submit', function(e) {
                e.preventDefault();
                removeFormErrors(this);

                form_ajax('{{ t_route("compensation-events.update", $event->id) }}', this, {redirect: "{{ t_route('compensation-events.show', $event->id) }}"});
            });

            $('#early_warning_id').trigger('change')
        });
    </script>
@endpush