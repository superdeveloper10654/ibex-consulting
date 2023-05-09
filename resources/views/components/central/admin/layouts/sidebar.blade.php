<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="animated-menu {{ Route::currentRouteNameStartsWith('central.admin.tenants') ? 'mm-active' : '' }}" style="opacity: 1;">
                    <a href="{{ ca_route('tenants') }}" class="waves-effect">
                        <i class="mdi mdi-account-cog-outline"></i>
                        <span>@lang('Tenants')</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
