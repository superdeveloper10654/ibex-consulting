<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="{{ CA::route('home') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ URL::asset('/assets/images/ibex-consulting-logo.svg') }}" alt="" height="50">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ URL::asset('/assets/images/ibex-consulting-logo.svg') }}" alt="" height="50">
                      <span style="color: #fff; padding: 10px"></span>
                    </span>
                </a>

                <a href="{{ CA::route('home') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ URL::asset('/assets/images/ibex-consulting-logo.svg') }}" alt="" height="50">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ URL::asset('/assets/images/ibex-consulting-logo.svg') }}" alt="" height="50">
                        <span style="color: #fff; padding: 10px"></span>
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>
        </div>
         
        <div class="d-flex justify-content-end">
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-16 d-inline-flex header-profile-user">
                        A
                    </span>
                    <span class="d-none d-xl-inline-block ms-1" key="t-henry">{{ ucfirst(CA::profile()->first_name) }}</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="#"><i class="bx bx-user font-size-16 align-middle me-1"></i> <span key="t-profile">@lang('Settings')</span></a>
                    <a class="dropdown-item d-block" href="#" data-bs-toggle="modal" data-bs-target=".change-password"><i class="bx bx-wrench font-size-16 align-middle me-1"></i> <span key="t-settings">@lang('Change password')</span></a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="javascript:void();" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span key="t-logout">@lang('Logout')</span></a>
                    <form id="logout-form" action="{{ CA::route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>

            {{-- <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect position-relative">
                    <i class="mdi mdi-pulse"></i>
                    <span class="badge bg-warning rounded-pill" id="topbar-activities-counter">0</span>
                </button>
            </div> --}}
        </div>
    </div>
</header>

<!--  Change-Password modal -->
<div class="modal fade change-password" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">@lang('Change Password')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="change-password">
                    @csrf
                    <input type="hidden" value="{{ CA::profile()->id }}" id="data_id">
                    <div class="mb-3">
                        <x-form.input-with-slot label="Current Password" name="current_password" type="password" placeholder="Enter Current Password">
                            <button class="btn btn-light password-addon" type="button"><i class="mdi mdi-eye-outline"></i></button>
                        </x-form.input-with-slot>
                    </div>

                    <div class="mb-3">
                        <x-form.input-with-slot label="New Password" name="new_password" type="password" placeholder="Enter New Password" autocomplete="new_password">
                            <button class="btn btn-light password-addon" type="button"><i class="mdi mdi-eye-outline"></i></button>
                        </x-form.input-with-slot>
                    </div>

                    <div class="mb-3">
                        <x-form.input-with-slot label="Confirm Password" name="new_password_confirmation" type="password" placeholder="Enter Confirm New Password" autocomplete="new_password">
                            <button class="btn btn-light password-addon" type="button"><i class="mdi mdi-eye-outline"></i></button>
                        </x-form.input-with-slot>
                    </div>

                    <div class="mt-3 d-grid">
                        <button class="btn btn-primary waves-effect waves-light" type="submit">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        jQuery(($) => {
            $('#change-password').on('submit', function(e) {
                e.preventDefault();
                removeFormErrors(this);

                form_ajax('#', this, {callback: () => {
                    $('.modal.change-password .btn-close').click();
                }});
            });
        });
    </script>
@endpush