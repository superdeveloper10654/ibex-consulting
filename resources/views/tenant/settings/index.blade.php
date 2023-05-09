@extends('tenant.layouts.master')

@section('title')
    @lang('General')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Settings
        @endslot
        @slot('title')
            General
        @endslot
    @endcomponent

    <form id="update-settings" method="POST" autocomplete="off">
        @method('PUT') @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <x-form.file-upload.single label="Landing image" name="{{ AppTenant\Models\Setting::KEY_LANDING_IMAGE }}" text="Drop image here or click to upload" max-filesize="5" :existing-file="$landing_image ?? ''"></x-form.file-upload.single>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <x-form.file-upload.single label="Organisation logo" name="{{ AppTenant\Models\Setting::KEY_ORGANISATION_LOGO }}" text="Drop image here or click to upload" max-filesize="2" :existing-file="$organisation_logo ?? ''" thumbnail-width="300"></x-form.file-upload.single>
                    </div>
                </div>
            </div>
        </div>
        <div class="row float-end row mt-5 pb-3">
            <div class="col-12">
                <button type="submit" class="btn btn-success btn-rounded w-md waves-effect waves-light">Update</button>
            </div>
        </div>

    </form>

@endsection

@push('script')
<script>
    jQuery(($) => {
        $('#update-settings').on('submit', function(e) {
            e.preventDefault();
            removeFormErrors(this);

            form_ajax('{{ t_route("settings.update") }}', this, {redirect: "{{ t_route('settings') }}"});
        });
    });
</script>
@endpush