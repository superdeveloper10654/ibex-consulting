@extends('tenant.layouts.master')

@section('title') Edit Mitigation {{ $mitigation->name }} @endsection

@section('content')
    <x-resource.breadcrumb :resource="$mitigation" :title="'Edit Mitigation ' . $mitigation->name" />

    <div class="row justify-content-center">
        <div class="col-xl-9">
            <div class="card p-5">
                <div class="card-body">
                    <p class="card-title-desc">Please complete all fields below</p>
                    <form id="update-mitigation" method="POST" autocomplete="off">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <x-form.input label="Name" name="name" :value="$mitigation->name" />
                            </div>
                            <div class="col-sm-6 mb-3">
                                <x-form.select label="Early Warning" name="early_warning" :options="$early_warnings->pluck('title', 'id')"  :selected="$mitigation->early_warning_id" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <x-form.textarea label="Description" name="description" :value="$mitigation->description" />
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

@section('script')
<script>
        jQuery(($) => {
            $('#update-mitigation').on('submit', function(e) {
                e.preventDefault();
                removeFormErrors(this);

                form_ajax('{{ t_route("mitigations.update", $mitigation->id) }}', this, {redirect: "{{ t_route('mitigations.show', $mitigation->id) }}"});
            });
        });
    </script>
@endsection