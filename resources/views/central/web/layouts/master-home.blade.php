<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title> Sign Up | Ibex Software</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="Ibex" name="description" />
    <meta content="Ibex Consulting" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.ico')}}">
    @include('central.web.layouts.head-css')
</head>

@yield('body')

<header id="page-topbar" style="background: #fff; -webkit-box-shadow: none; box-shadow: none;">
    <div class="navbar-header mx-lg-5">
        <div class="d-flex align-items-center">
            <!-- LOGO -->
            <div class="navbar-brand-box" style="display: block !important; width: 80px; text-align: left; padding: 10px;">
                <a href="index" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="https://ibex.software/assets/images/ibex-consulting-logo.svg" alt="" height="50" style="filter: invert(1); padding: 0 0 0 10px;">
                    </span>
                    <span class="logo-lg">
                        <img src="https://ibex.software/assets/images/ibex-consulting-logo.svg" alt="" height="50" style="filter: invert(1);">
                    </span>
                </a>


            </div>
            <span class="d-none d-md-inline-block">Ibex Software</span>
            <!--
            <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content" aria-expanded="true">
                <i class="fa fa-fw fa-bars"></i>
            </button>-->
        </div>
        <div class="d-flex">
            <a class="btn btn-primary btn-rounded w-md waves-effect waves-light mx-1 d-inline-block" href="{{ route('register') }}">
                <i class="bx bx-user-plus font-size-20 me-1" style="vertical-align: middle;"></i> Sign Up
            </a>
            <a class="btn mx-1 d-flex align-items-center" href="{{ route('login') }}"> Log In</a>
        </div>
    </div>
</header>

<div class="topnav" style="background: #fff; -webkit-box-shadow: none; box-shadow: none;">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

            <div class="navbar-collapse collapse" id="topnav-menu-content" style="text-align: center; justify-content: center;">


                <div class="dropdown d-none d-lg-inline-block ms-1">
                    <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        Features
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-3" style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate3d(0px, 72px, 0px);" data-popper-placement="bottom-end">
                        <div class="px-lg-2">
                            <div class="row g-0">
                                <div class="col">
                                    <a class="dropdown-icon-item" href="#">
                                        <div class="display-5"><i class="bx bx-pen"></i></div>
                                        <span>Contracts</span>
                                    </a>
                                </div>
                                <div class="col">
                                    <a class="dropdown-icon-item" href="#">
                                        <div class="display-5"><i class="mdi mdi-traffic-cone"></i></div>
                                        <span>Operations</span>
                                    </a>
                                </div>
                                <div class="col">
                                    <a class="dropdown-icon-item" href="#">
                                        <div class="display-5"><i class="mdi mdi-alert-outline"></i></div>
                                        <span>Risks</span>
                                    </a>
                                </div>
                            </div>

                            <div class="row g-0">
                                <div class="col">
                                    <a class="dropdown-icon-item" href="#">
                                        <div class="display-5"><i class="mdi mdi-bank"></i></div>
                                        <span>Payments</span>
                                    </a>
                                </div>
                                <div class="col">
                                    <a class="dropdown-icon-item" href="#">
                                        <div class="display-5"><i class="mdi mdi-diamond-stone"></i></div>
                                        <span>Quality</span>
                                    </a>
                                </div>
                                <div class="col">
                                    <a class="dropdown-icon-item" href="#">
                                        <div class="display-5"><i class="mdi mdi-paperclip"></i></div>
                                        <span>Uploads</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    </div>
</div>




<?php /*
<!--
              <ul class="navbar-nav">

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" role="button">
                            <span>Features</span> <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu dropdown-megamenu" >

                            <a href="" class="dropdown-item col-md-3" ><i class="bx bx-user font-size-16 align-middle me-1"></i>User Profiles</a>
                            <a href="" class="dropdown-item col-md-3" ><i class="bx bx-user font-size-16 align-middle me-1"></i>User Profiles</a>
                          <a href="" class="dropdown-item col-md-3" ><i class="bx bx-user font-size-16 align-middle me-1"></i>User Profiles</a>
                          <a href="" class="dropdown-item col-md-3" ><i class="bx bx-user font-size-16 align-middle me-1"></i>User Profiles</a>
                        </div>
                    </li>
                  
                  <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" role="button">
                            <span>Benefits</span> <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" >

                            <a href="" class="dropdown-item" ><i class="bx bx-user font-size-16 align-middle me-1"></i>User Profiles</a>
                            <a href="" class="dropdown-item" >Saas</a>
                            <a href="" class="dropdown-item">Crypto</a>
                            <a href="" class="dropdown-item">Blog</a>
                        </div>
                    </li>



                </ul>
    -->
*/ ?>
</div>
</nav>


</div>
</div>


@yield('content')

@include('central.web.layouts.vendor-scripts')
</body>

</html>