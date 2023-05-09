
<!-- JAVASCRIPT -->

<script src="{{ asset('assets/libs/jquery/jquery.min.js') }}" crossorigin="anonymous"></script>
<script src="{{ asset('assets/libs/bootstrap/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/libs/metismenu/metismenu.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/libs/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/libs/node-waves/node-waves.min.js') }}"></script>
<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/libs/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>
<script src="{{ asset('assets/libs/dropzone/dropzone.min.js') }}"></script>
<script src="{{ asset('assets/libs/popper/popper.min.js') }}"></script>
<script src="{{ asset('assets/libs/tippy/tippy-bundle.umd.min.js') }}"></script>
<script src="{{ asset('/assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.js') }}"></script>
<script src="{{ asset('/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('/assets/libs/datepicker/datepicker.min.js') }}"></script>
<script src="{{ asset('/assets/libs/lodash/lodash.min.js') }}"></script>
<script src="{{ asset('assets/js/app-central.min.js') . '?v=' . filemtime(public_path('assets/js/app-central.min.js')) }}"></script>

@stack('script')
@yield('script')
@yield('script-bottom')