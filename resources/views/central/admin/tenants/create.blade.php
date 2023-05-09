@extends('central.admin.layouts.master')

@section('title') Create Tenant @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1_link') {{ ca_route('tenants') }} @endslot
        @slot('li_1') Tenants list @endslot
        @slot('title') Create tenant  @endslot
    @endcomponent

    <div class="row justify-content-center">
        <div class="col-xl-9">
            <div class="card p-5">
                <div class="card-body">
                    <p class="card-title-desc">Please complete fields below to create tenant with registered admin profile</p>
                    <form id="create-tenant" method="POST" autocomplete="off" do-not-autofill>
                        @csrf

                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <x-form.input label="Admin first name" name="admin_first_name" />
                            </div>
                            <div class="col-sm-6">
                                <x-form.input label="Admin last name" name="admin_last_name" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <x-form.input label="Admin email" name="admin_email" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <x-form.input label="Organisation" name="organisation" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <x-form.input-with-slot label="Admin account password" name="admin_account_password" type="password">
                                    <button class="btn btn-light password-addon" type="button"><i class="mdi mdi-eye-outline"></i></button>
                                </x-form.input-with-slot>
                            </div>
                            <div class="col-md-6">
                                <x-form.input-with-slot label="Confirm Password" name="admin_account_password_confirmation" type="password">
                                    <button class="btn btn-light password-addon" type="button"><i class="mdi mdi-eye-outline"></i></button>
                                </x-form.input-with-slot>
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-12">
                                <x-form.file-upload.input label="Admin Profile Picture" name="admin_profile_avatar" />
                            </div>
                        </div>
                        
                        <div class="row mb-5">
                            <div class="col-sm-6">
                                <x-form.select label="Subscription" name="subscription" :options="$subscriptions" />
                            </div>
                            <div class="col-sm-6">
                                <x-form.input-with-slot label="Tenant subdomain" name="tenant_subdomain" type="text">
                                    <span class="input-group-text">.{{ env('APP_DOMAIN') }}</span>
                                </x-form.input-with-slot>
                            </div>
                        </div>

                        <div class="row float-end mt-5 pb-3">
                            <div class="col-6">
                                <a href="{{ ca_route('tenants') }}" class="btn btn-secondary btn-rounded w-md waves-effect waves-light">Cancel</a>
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
            $('#create-tenant').on('submit', function(e) {
                e.preventDefault();
                removeFormErrors(this);

                let processing_timeout = setTimeout(() => {
                    infoMsg('In process of tenant setup. It can take a while', '', {timeOut: 12000});
                }, 2000);

                form_ajax('{{ ca_route("tenants.store") }}', this, {redirect: "{{ ca_route('tenants') }}"})
                    .catch(() => {
                        clearTimeout(processing_timeout);
                    });
            });

            $('[name=organisation]').on('input', function() {
                let tenant_subdomain = Str.subdomain(this.value);
                $('[name=tenant_subdomain]').val(tenant_subdomain);
            });
        });
    </script>
@endsection