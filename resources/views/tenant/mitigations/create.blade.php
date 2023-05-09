@extends('tenant.layouts.master')

@section('title') @lang('New Mitigation') @endsection

@section('content')
    <x-resource.breadcrumb :resource="\AppTenant\Models\Mitigation::class" title="Create Mitigation" />

    <div class="row justify-content-center">
        <div class="col-xl-9">
            <div class="card p-5">
                <div class="card-body">
                    <p class="card-title-desc">Please complete all fields below</p>
                    <form id="create-mitigation" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden" name="is_draft" />

                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <x-form.input label="Name" name="name" :value="old('name')" />
                            </div>
                            <div class="col-sm-6 mb-3">
                                <x-form.select label="Early Warning" name="early_warning" :options="$early_warnings->pluck('title', 'id')"  :selected="old('early_warning_id')" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <x-form.textarea label="Description" name="description" :value="old('description')" />
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

@section('script')
    <script>
        jQuery(($) => {
            $('#create-mitigation').on('submit', function(e) {
                e.preventDefault();
                removeFormErrors(this);

                form_ajax('{{ t_route("mitigations.store") }}', this, {redirect: "{{ t_route('mitigations') }}"});
            });

            @if (isset($_GET['early_warning_id']))
                $("[name=early_warning]").val("{{ $_GET['early_warning_id'] }}").change();
            @endif
        });
    </script>
@endsection