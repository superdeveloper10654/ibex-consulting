<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="animated-menu {{ Route::currentRouteNameStartsWith('billing') ? 'mm-active' : '' }}" style="opacity: 1;">
                    <a href="{{ route('billing') }}" class="waves-effect">
                        <i class="mdi mdi-credit-card-outline"></i>
                        <span>@lang('Billing')</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
