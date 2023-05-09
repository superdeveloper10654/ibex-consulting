@extends('tenant.layouts.master-without-nav')

@section('title')
    @lang('Log In')
@endsection

@section('body')

    <body class="auth-body-bg">
        <div class="container-fluid p-0" id="login-container">
            <div class="row g-0">
                <div class="col-xl-9">
                    @if (settingGetLink(AppTenant\Models\Setting::KEY_LANDING_IMAGE))
                        <div class="landing-wrapper " style="background-image: url({{ settingGetLink(AppTenant\Models\Setting::KEY_LANDING_IMAGE) }});">
                        </div>
                    @else
                        <div class="landing-wrapper" style="background: rgba(42, 48, 66,0.8);"></div>
                    @endif
                </div>
                <div class="col-xl-3 animated-slow" style="background: #fff;">
                    <div class="auth-full-page-content p-md-5 p-4">
                        <div class="w-100">
                            <div class="d-flex flex-column h-100">
                                <div class="mb-4 mb-md-5">
                                    <div class="d-block auth-logo animated-slow">
                                        @if (settingGetLink(AppTenant\Models\Setting::KEY_ORGANISATION_LOGO))
                                            <img src="{{ settingGetLink(AppTenant\Models\Setting::KEY_ORGANISATION_LOGO) }}" alt="logo"
                                                height="50" />
                                        @endif
                                    </div>
                                </div>
                                <div class="my-auto">
                                    <div>
                                        <h2 class="text-dark animated-slow">Log In</h2>
                                        <p class="text-muted animated-slow">Welcome to Ibex </p>
                                    </div>
                                    <div class="mt-4 animated-slow">
                                        <form method="POST" action="{{ t_route('auth.login') }}" id="login">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="username" class="form-label">Email</label>
                                                <input name="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                                    value="{{ old('email', '') }}" id="username" placeholder="" autocomplete="email" autofocus>
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <x-form.input-with-slot label="Password" name="password" type="password">
                                                    <button class="btn btn-light password-addon" type="button"><i
                                                            class="mdi mdi-eye-outline"></i></button>
                                                </x-form.input-with-slot>
                                            </div>
                                            <div class="mt-4 d-grid animated-slow">
                                                <button class="btn btn-primary waves-effect waves-light" type="submit">Log In</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="mt-4 mt-md-5">
                                    <div class="d-block auth-logo animated-slow">
                                        <img src="{{ URL::asset('/assets/images/ibex-consulting-logo.svg') }}" alt="" height="40"
                                            class="auth-logo-dark mb-3">
                                    </div>
                                    <span class="animated-slow">©
                                        <script>
                                            document.write(new Date().getFullYear())
                                        </script> Ibex Consulting. All rights reserved.
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container-fluid -->
    </body>
@endsection

@push('script')
    <script>
        jQuery($ => {
            $('form#login').on('submit', function(e) {
                e.preventDefault();
                removeFormErrors(this);
                form_ajax('{{ t_route("auth.login-setup") }}', this, {redirect: "{{ t_route('dashboard') }}"});
            });
        });
    </script>
@endpush