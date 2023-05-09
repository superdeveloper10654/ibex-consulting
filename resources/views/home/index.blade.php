@extends('central.web.layouts.master-home')

@section('title') Register @endsection

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('/assets/libs/owl.carousel/owl.carousel.min.css') }}">

    <style>
        .bx {
            line-height: unset !important;
        }

        .avatar-lg {
            line-height: 6rem !important;
            vertical-align: middle;
        }

        .active,
        .active a {
            color: #000 !important;
            background-color: #fff !important;
        }

        .dropdown-item:focus,
        .dropdown-item:hover {
            background-color: var(--bs-dropdown-link-hover-bg);
            color: var(--bs-dropdown-link-hover-color);
            text-decoration: none;
        }
    </style>
@endsection

@section('body')
    <body style="background: #fff; overflow: hidden;">
@endsection

    @section('content')
        <div class="container-fluid p-lg-5 p-sm-2">
            <div class="row align-items-center text-center" style="padding-top: 100px;">
                <div class="text-center p-5">
                    <div class="display-3">Looking for NEC4 software?</div>
                    <div class="h2">You’ve come to the right place!</div>
                </div>
                
    @endsection