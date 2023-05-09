<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title> @yield('title') | Ibex</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.ico') }}">
    @include('central.admin.layouts.head-css')
</head>

@section('body')

<body data-sidebar="dark">
    @show
    <!-- Begin page -->
    <div id="layout-wrapper" class="animated-slow">
        <x-central.admin.layouts.topbar />
        <x-central.admin.layouts.sidebar />

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid" style="max-width: 1800px;">
                    @yield('content')
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            @include('central.admin.layouts.footer')
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <!-- Modals -->
    @stack('modals')
    <!-- /Modals -->

    <x-overlay.loader />

    <!-- JAVASCRIPT -->
    @include('central.admin.layouts.vendor-scripts')
    @yield('scripts')
</body>

</html>