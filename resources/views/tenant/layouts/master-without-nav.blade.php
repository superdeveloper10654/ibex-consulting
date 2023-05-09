<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8" />
        <title> @yield('title') | Ibex</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta content="Ibex" name="description" />
        <meta content="Ibex Consulting" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.ico')}}">
        @include('tenant.layouts.head-css')
  </head>

    @yield('body')
    
    @yield('content')

    <x-overlay.loader />

    @include('tenant.layouts.vendor-scripts')
    </body>
</html>