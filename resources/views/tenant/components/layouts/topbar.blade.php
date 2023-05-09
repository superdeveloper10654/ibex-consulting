<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="{{t_route('dashboard') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ URL::asset('/assets/images/ibex-consulting-logo.svg') }}" alt="" height="50">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ URL::asset('/assets/images/ibex-consulting-logo.svg') }}" alt="" height="50">
                      <span style="color: #fff; padding: 10px"></span>
                    </span>
                </a>

                <a href="{{t_route('dashboard') }}" class="logo logo-light">
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

        <div class="d-flex">
            @if (settingGetLink(AppTenant\Models\Setting::KEY_ORGANISATION_LOGO))
                <img src="{{ settingGetLink(AppTenant\Models\Setting::KEY_ORGANISATION_LOGO) }}" alt="logo" height="50" />
            @endif
        </div>
         
        <div class="d-flex justify-content-end">
            @if ($notifications->isNotEmpty())
                <div class="dropdown d-inline-block">
                    <button type="button" 
                        class="btn header-item noti-icon position-relative"
                        id="page-header-notifications-dropdown"
                        data-bs-toggle="dropdown"
                        data-bs-auto-close="outside"
                        aria-haspopup="true"
                        aria-expanded="false"
                    >
                        <i class="bx bx-bell bx-tada"></i>
                        <span class="badge bg-info rounded-pill" id="topbar-notification-counter">{{ count($notifications) }}</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-start p-0" aria-labelledby="page-header-notifications-dropdown" id="notifications">
                        <div class="p-3">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h5 class="m-0">Notifications</h6>
                                </div>
                                <div class="col-auto" data-action="dismiss-all-notifications">
                                    Dismiss all
                                </div>
                            </div>
                        </div>
                        <div data-simplebar style="max-height: 80vh" class="pb-3">
                            @foreach ($notifications as $notification)
                                <div class="text-reset notification-item list-group-item" title="Click to open" role="button" onlick="window.location.href = '{{ $notification->link }}'">
                                    <div class="d-flex pb-2">
                                        <div class="avatar-xs me-3">
                                            <div class="rounded-circle bg-light text-center">
                                                <h2>{!! $notification->img !!}</h2>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="mb-1">
                                                {{ $notification->profile->full_name() }}
                                                {!! $notification->text !!}
                                            </p>
                                            <p class="text-muted small mb-0">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                        <button type="button" 
                                            class="btn d-flex align-items-start p-0" 
                                            data-action="dismiss-notification"
                                            data-notification-id="{{ $notification->id }}" 
                                        >
                                            <i class="mdi mdi-close font-size-20"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
          
          
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{ t_profile()->avatar_url() }}"
                        alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1" key="t-henry">{{ ucfirst(t_profile()->first_name) }}</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="{{t_route('profiles.edit', App\Models\Statical\Constant::ME) }}"><i class="bx bx-user font-size-16 align-middle me-1"></i> <span key="t-profile">@lang('Settings')</span></a>
                    <a class="dropdown-item d-block" href="#" data-bs-toggle="modal" data-bs-target=".change-password"><i class="bx bx-wrench font-size-16 align-middle me-1"></i> <span key="t-settings">@lang('Change password')</span></a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="javascript:void();" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span key="t-logout">@lang('Logout')</span></a>
                    <form id="logout-form" action="{{t_route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect position-relative">
                    <i class="mdi mdi-pulse"></i>
                    <span class="badge bg-warning rounded-pill" id="topbar-activities-counter">{{ $activities_count }}</span>
                </button>
            </div>
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
                    <input type="hidden" value="{{ t_profile()->id }}" id="data_id">
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

                form_ajax('{{t_route("profiles.update-password") }}', this, {callback: () => {
                    $('.modal.change-password .btn-close').click();
                }});
            });
        });
    </script>
@endpush