@extends('central.web.layouts.master-without-nav')

@section('title')
Sign-up
@endsection

@section('css')
<!-- owl.carousel css -->
<link rel="stylesheet" href="{{ URL::asset('/assets/libs/owl.carousel/owl.carousel.min.css') }}">
<link href="{{ URL::asset('/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('body')

<body class="auth-body-bg">
    @endsection

    @section('content')

    <div>
        <div class="container-fluid p-0">
            <div class="row g-0">
                <div class="col-md-7">
                    <div class="auth-full-bg pt-lg-5 p-4">
                        <div class="w-100">
                            <div class="bg-overlay"></div>
                            <div class="d-flex h-100 flex-column">
                                <div class="p-4 mt-auto">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-7">
                                            <div class="text-center">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->

                <div class="col-md-5">
                    <div class="auth-full-page-content p-md-5 p-4">
                        <div class="w-100">

                            <div class="d-flex flex-column h-100">
                                <div class="mb-4 mb-md-5">
                                    <a href="index" class="d-block auth-logo">
                                        <img src="{{ URL::asset('/assets/images/ibex-consulting-logo.svg') }}" alt="" height="40" class="auth-logo-dark" style="filter: invert(1);">
                                    </a>
                                </div>
                                <div class="my-auto">

                                    <div>
                                        <h5 class="text-dark">Create your Ibex account</h5>
                                        <p class="text-muted">Sign-up for free during our Alpha stage. <br>Please review and agree to our <a href="terms-and-conditions.blade.php" class="text-primary">Terms & Conditions</a>. </p>
                                    </div>

                                    <form method="POST" class="form-horizontal" id="registration-form" action="{{ route('register') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row mt-4">
                                            <div class="col-md-6 mb-3">
                                                <label for="first_name" class="form-label">First Name</label>
                                                <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" value="{{ old('first_name') }}" name="first_name" placeholder="" autofocus required>
                                                @error('first_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="last_name" class="form-label">Last Name</label>
                                                <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" value="{{ old('last_name') }}" name="last_name" placeholder="" autofocus required>
                                                @error('last_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="organisation" class="form-label">Organisation</label>
                                            <input type="text" class="form-control @error('organisation') is-invalid @enderror" value="{{ old('organisation') }}" id="organisation" name="organisation" autofocus placeholder="">
                                            @error('organisation')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="useremail" class="form-label">Email</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="useremail" value="{{ old('email') }}" name="email" placeholder="" autofocus required>
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <x-form.input-with-slot label="Enter Password" name="password" type="password" autocomplete="new_password" autofocus>
                                                    <button class="btn btn-light password-addon" type="button"><i class="mdi mdi-eye-outline"></i></button>
                                                </x-form.input-with-slot>
                                            </div>
                                            <div class="col-md-6">
                                                <x-form.input-with-slot label="Confirm Password" name="password_confirmation" type="password" autocomplete="new_password" autofocus>
                                                    <button class="btn btn-light password-addon" type="button"><i class="mdi mdi-eye-outline"></i></button>
                                                </x-form.input-with-slot>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <x-form.file-upload.input label="Profile Picture" name="avatar" />
                                        </div>

                                        <div class="mt-4 d-grid">
                                            <button class="btn btn-primary waves-effect waves-light" type="submit"><i class="bx bx-user-plus font-size-20 me-1" style="vertical-align: bottom"></i> Sign up</button>
                                        </div>
                                    </form>
                                    <div class="mt-3 text-center">
                                        <p>Already have an account ? <a href="{{ url('login') }}" class="fw-medium text-primary"><i class="bx bx-log-in"></i> Log in</a> </p>
                                    </div>
                                </div>
                                <div class="mt-4 mt-md-5">
                                    <img src="{{ URL::asset('/assets/images/ibex-consulting-logo.svg') }}" alt="" height="40" class="auth-logo-dark" style="filter: invert(1);">
                                    <span class="px-3">© <script>document.write(new Date().getFullYear())</script> Ibex Consulting</span>
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
    </div>
    @endsection

    @section('script')
        <script src="{{ URL::asset('/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
        <!-- owl.carousel js -->
        <script src="{{ URL::asset('/assets/libs/owl.carousel/owl.carousel.min.js') }}"></script>
        <!-- auth-2-carousel init -->
        <script src="{{ URL::asset('/assets/js/pages/auth-2-carousel.init.js') }}"></script>

        <script>
            jQuery(($) => {
                $('#registration-form').on('submit', function() {
                    showLoader();
                });
            });
        </script>
    @endsection