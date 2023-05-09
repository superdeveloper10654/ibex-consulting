<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                @t_can('profiles.read')
                    @if (!t_profile()->isSuperAdmin())
                        <li class="animated-menu {{ Route::currentRouteNameStartsWith('profiles') ? 'mm-active' : '' }}" style="opacity: 1;">
                            <a href="{{t_route('profiles') }}" class="waves-effect">
                                <i class="bx bx-user"></i>
                                <span>@lang('Profiles')</span>
                            </a>
                        </li>
                    @endif
                @endt_can

                <li class="animated-menu {{ Route::currentRouteNameStartsWith('users') ? 'mm-active' : '' }}" style="opacity: 1;">
                    <a href="{{t_route('users') }}" class="waves-effect">
                        <i class="mdi mdi-account-cog-outline"></i>
                        <span>@lang('Users')</span>
                    </a>
                </li>

                @t_can('dashboard.browse')
                    <li class="animated-menu {{ Route::currentRouteNameStartsWith('dashboard') ? 'mm-active' : '' }}" style="opacity: 1;">
                        <a href="{{t_route('dashboard') }}" class="waves-effect">
                            <i class="mdi mdi-gauge"></i>
                            <span>@lang('Dashboard')</span>
                        </a>
                    </li>
                @endt_can

                @t_can('manage-billing')
                    @if (!t_profile()->isSuperAdmin())
                        <li class="animated-menu {{ Route::currentRouteNameStartsWith('billing') ? 'mm-active' : '' }}" style="opacity: 1;">
                            <a href="{{t_route('billing') }}" class="waves-effect">
                                <i class="mdi mdi-credit-card-outline"></i>
                                <span>@lang('Billing')</span>
                            </a>
                        </li>
                    @endif
                @endt_can

                @t_can('contracts.read')
                    <li class="animated-menu {{ Route::currentRouteNameStartsWith('contracts') ? 'mm-active' : '' }}" style="opacity: 1;">
                        <a href="{{t_route('contracts') }}" class="waves-effect">
                            <i class="bx bx-pen"></i><span>@lang('Contracts')</span>
                        </a>
                    </li>
                @endt_can

                @if ($has_contracts)
                    @t_canany(['workflow.browse', 'operations.read', 'programmes.read', 'measures.read', 'work-records.browse'])
                        <li class="animated-menu {{ Route::currentRouteNameStartsWith(['operations', 'measures', 'daily-work-records', 'operations-workflow', 'programme', 'gantt']) ? 'mm-active' : '' }}"
                            style="opacity: 1;">
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="mdi mdi-traffic-cone"></i><span>@lang('Operations')</span>
                            </a>
                            <ul class="sub-menu mm-collapse {{ Route::currentRouteNameStartsWith(['measures', 'daily-work-records']) ? 'mm-show' : '' }}"
                                aria-expanded="false">
                                @t_can('workflow.browse')
                                    <li class="{{ Route::currentRouteNameStartsWith('operations-workflow') ? 'mm-active' : '' }}">
                                        <a href="{{t_route('operations-workflow') }}"><i
                                                class="mdi mdi-directions font-size-18"></i>@lang('Workflow')</a>
                                    </li>
                                @endt_can

                                @t_can('programmes.read')
                                    <li class="{{ Route::currentRouteNameStartsWith(['programmes', 'gantt']) ? 'mm-active' : '' }}">
                                        <a href="{{t_route('programmes') }}">@lang('Programmes')</a>
                                    </li>
                                @endt_can

                                @subscription_paid
                                    @t_can('operations.read')
                                        <li
                                            class="{{ Route::currentRouteNameStartsWith('operations') && !Route::currentRouteNameStartsWith('operations-workflow') ? 'mm-active' : '' }}">
                                            <a href="{{t_route('operations') }}">@lang('Overview')</a>
                                        </li>
                                    @endt_can

                                    <li>
                                        <a href="#">@lang('Instructions')</a>
                                    </li>

                                    @t_can('measures.read')
                                        <li class="{{ Route::currentRouteNameStartsWith('measures') ? 'mm-active' : '' }}">
                                            <a href="{{t_route('measures') }}">@lang('Measures')</a>
                                        </li>
                                    @endt_can

                                    @t_can('work-records.browse')
                                        <li class="{{ Route::currentRouteNameStartsWith('daily-work-records') ? 'mm-active' : '' }}">
                                            <a href="{{t_route('daily-work-records') }}">@lang('Work Records')</a>
                                        </li>
                                    @endt_can
                                @endsubscription_paid
                            </ul>
                        </li>
                    @endt_canany

                    @t_canany(['risk-management.read', 'early-warnings.read', 'workflow.browse', 'mitigations.read'])
                        <li class="animated-menu {{ Route::currentRouteNameStartsWith(['risk-management', 'early-warnings', 'risk-management-workflow']) ? 'mm-active' : '' }}"
                            style="opacity: 1;">
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="mdi mdi-alert-outline"></i><span>@lang('Risk Management')</span>
                            </a>
                            <ul class="sub-menu mm-collapse {{ Route::currentRouteNameStartsWith(['early-warnings', 'mitigations', 'risk-management-workflow']) ? 'mm-show' : '' }}"
                                aria-expanded="false">
                                @t_can('workflow.browse')
                                    <li class="{{ Route::currentRouteNameStartsWith('risk-management-workflow') ? 'mm-active' : '' }}">
                                        <a href="{{t_route('risk-management-workflow') }}"><i
                                                class="mdi mdi-directions font-size-18"></i>@lang('Workflow')</a>
                                    </li>
                                @endt_can
                                @t_can('risk-management.read')
                                    <li
                                        class="{{ Route::currentRouteNameStartsWith('risk-management') && !Route::currentRouteNameStartsWith('risk-management-workflow') ? 'mm-active' : '' }}">
                                        <a href="{{t_route('risk-management') }}">@lang('Overview')</a>
                                    </li>
                                @endt_can
                                @t_can('early-warnings.read')
                                    <li class="{{ Route::currentRouteNameStartsWith('early-warnings') ? 'mm-active' : '' }}">
                                        <a href="{{t_route('early-warnings') }}">@lang('Early Warnings')</a>
                                    </li>
                                @endt_can

                                @t_can('mitigations.read')
                                    <li class="{{ Route::currentRouteNameStartsWith('mitigations') ? 'mm-active' : '' }}">
                                        <a href="{{t_route('mitigations') }}">@lang('Mitigatons')</a>
                                    </li>
                                @endt_can
                            </ul>
                        </li>
                    @endt_canany

                    @t_canany(['compensation-events.read', 'compensation-events-notification.read', 'instructions.read',
                        'quotations.read', 'workflow.browse'])
                        <li class="animated-menu" style="opacity: 1;">
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="mdi mdi-scale-balance"></i><span>@lang('Compensation Events')</span>
                            </a>
                            <ul class="sub-menu mm-collapse" aria-expanded="false">
                                @t_can('workflow.browse')
                                    <li class="{{ Route::currentRouteNameStartsWith('compensation-events-workflow') ? 'mm-active' : '' }}">
                                        <a href="{{t_route('compensation-events-workflow') }}"><i
                                                class="mdi mdi-directions font-size-18"></i>@lang('Workflow')</a>
                                    </li>
                                @endt_can
                                @t_can('compensation-events.read')
                                    <li
                                        class="{{ Route::currentRouteNameStartsWith('compensation-events') && !Route::currentRouteNameStartsWith('compensation-events-workflow') ? 'mm-active' : '' }}">
                                        <a href="{{t_route('compensation-events') }}">@lang('Overview')</a>
                                    </li>
                                @endt_can

                                @subscription_paid
                                    @t_can('compensation-events-notification.read')
                                        <li class="{{ Route::currentRouteNameStartsWith('compensation-events-notification') ? 'mm-active' : '' }}">
                                            <a href="{{t_route('compensation-events-notification') }}">@lang('Notifications')</a>
                                        </li>
                                    @endt_can
                                    @t_can('instructions.read')
                                        <li>
                                            <a href="javascript: void(0);" class="has-arrow waves-effect">@lang('Instructions')</a>

                                            <ul class="sub-menu mm-collapse" aria-expanded="false">
                                                <li class="{{ Route::currentRouteNameStartsWith('instructions') ? 'mm-active' : '' }}">
                                                    <a href="{{t_route('instructions') }}">
                                                        @if (t_profile()->isContractor())
                                                            @lang('Received')
                                                        @else
                                                            @lang('Issued')
                                                        @endif
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{t_route('instructions') }}">@lang('Proposed')</a>
                                                </li>
                                            </ul>
                                        </li>
                                    @endt_can
                                @endsubscription_paid

                                @t_can('quotations.read')
                                    <li class="{{ Route::currentRouteNameStartsWith('quotations') ? 'mm-active' : '' }}">
                                        <a href="{{t_route('quotations') }}">@lang('Quotations')</a>
                                    </li>
                                @endt_can
                            </ul>
                        </li>
                    @endt_canany
                @endif

                @subscription_paid
                    @if ($has_contracts)
                        @t_canany(['quality-and-defects.browse', 'tests-and-inspections.browse', 'snags-and-defects.browse',
                            'workflow.browse'])
                            <li class="animated-menu {{ Route::currentRouteNameStartsWith(['quality-and-defects', 'tests-and-inspections', 'snags-and-defects', 'quality-and-defects-workflow']) ? 'mm-active' : '' }}"
                                style="opacity: 1;">
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="mdi mdi-diamond-stone"></i><span>@lang('Quality Control')</span>
                                </a>
                                <ul class="sub-menu mm-collapse {{ Route::currentRouteNameStartsWith(['quality-and-defects', 'tests-and-inspections', 'snags-and-defects', 'quality-and-defects-workflow']) ? 'mm-show' : '' }}"
                                    aria-expanded="false">
                                    @t_can('workflow.browse')
                                        <li class="{{ Route::currentRouteNameStartsWith('quality-and-defects-workflow') ? 'mm-active' : '' }}">
                                            <a href="{{t_route('quality-and-defects-workflow') }}"><i
                                                    class="mdi mdi-directions font-size-18"></i>@lang('Workflow')</a>
                                        </li>
                                    @endt_can
                                    @t_can('quality-and-defects.browse')
                                        <li class="{{ Route::currentRouteNameStartsWith('quality-and-defects') && !Route::currentRouteNameStartsWith('quality-and-defects-workflow') ? 'mm-active' : '' }}">
                                            <a href="{{t_route('quality-and-defects') }}">@lang('Overview')</a>
                                        </li>
                                    @endt_can

                                    @t_can('tests-and-inspections.browse')
                                        <li class="{{ Route::currentRouteNameStartsWith('tests-and-inspections') ? 'mm-active' : '' }}">
                                            <a href="{{t_route('tests-and-inspections') }}">@lang('Tests & Inspections')</a>
                                        </li>
                                    @endt_can

                                    @t_can('snags-and-defects.browse')
                                        <li class="{{ Route::currentRouteNameStartsWith('snags-and-defects') ? 'mm-active' : '' }}">
                                            <a href="{{t_route('snags-and-defects') }}">@lang('Snags & Defects')</a>
                                        </li>
                                    @endt_can
                                </ul>
                            </li>
                        @endt_canany

                        @t_canany(['payments.read', 'applications.read', 'assessments.read', 'payment-certificates.browse',
                            'workflow.browse'])
                            <li class="animated-menu {{ Route::currentRouteNameStartsWith(['payments', 'applications', 'assessments', 'payment-certificates', 'payments-workflow']) ? 'mm-active' : '' }}"
                                style="opacity: 1;">
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="mdi mdi-bank"></i><span>@lang('Payments')</span>
                                </a>
                                <ul class="sub-menu mm-collapse {{ Route::currentRouteNameStartsWith(['payments', 'applications', 'assessments', 'payment-certificates', 'payments-workflow']) ? 'mm-show' : '' }}"
                                    aria-expanded="false">
                                    @t_can('workflow.browse')
                                        <li class="{{ Route::currentRouteNameStartsWith('payments-workflow') ? 'mm-active' : '' }}">
                                            <a href="{{t_route('payments-workflow') }}"><i
                                                    class="mdi mdi-directions font-size-18"></i>@lang('Workflow')</a>
                                        </li>
                                    @endt_can
                                    @t_can('payments.read')
                                        <li class="{{ Route::currentRouteNameStartsWith('payments') && !Route::currentRouteNameStartsWith('payments-workflow') ? 'mm-active' : '' }}">
                                            <a href="{{t_route('payments') }}">@lang('Overview')</a>
                                        </li>
                                    @endt_can

                                    @t_can('applications.read')
                                        <li class="{{ Route::currentRouteNameStartsWith('applications') ? 'mm-active' : '' }}">
                                            <a href="{{t_route('applications') }}">@lang('Applications')</a>
                                        </li>
                                    @endt_can

                                    @t_can('assessments.read')
                                        <li class="{{ Route::currentRouteNameStartsWith('assessments') ? 'mm-active' : '' }}">
                                            <a href="{{t_route('assessments') }}">@lang('Assessments')</a>
                                        </li>
                                    @endt_can

                                    @t_can('payment-certificates.browse')
                                        <li>
                                            <a href="#">@lang('Certificates')</a>
                                        </li>
                                    @endt_can
                                </ul>
                            </li>
                        @endt_canany
                    @endif
                @endsubscription_paid

                @if ($has_contracts)
                    @t_can('uploads.browse')
                        <li class="animated-menu {{ Route::currentRouteName() == 'uploads' ? 'mm-active' : '' }}" style="opacity: 1;">
                            <a href="{{t_route('uploads') }}" class="waves-effect">
                                <i class="mdi mdi-paperclip"></i>
                                <span>@lang('Shared Uploads')</span>
                            </a>
                        </li>
                    @endt_can
                @endif

                @subscription_paid
                    @if ($has_contracts)
                        @t_canany(['notification-settings.browse', 'settings-manage', 'resources.read', 'rate-cards.read',
                            'rate-card-pins.read'])
                            <li class="animated-menu {{ in_array(Route::currentRouteName(), ['notification-settings', 'settings']) ? 'mm-active' : '' }}"
                                style="opacity: 1;">
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="mdi mdi-cog"></i><span>@lang('Settings')</span>
                                </a>
                                <ul class="sub-menu mm-collapse {{ in_array(Route::currentRouteName(), ['notification-settings', 'settings']) ? 'mm-show' : '' }}"
                                    aria-expanded="false">
                                    @t_can('notification-settings.browse')
                                        <li class="{{ Route::currentRouteName() == 'notification-settings' ? 'mm-active' : '' }}">
                                            <a href="{{t_route('notification-settings') }}">@lang('Configurations')</a>
                                        </li>
                                    @endt_can
                                    @t_can('settings-manage')
                                        <li class="{{ Route::currentRouteName() == 'settings' ? 'mm-active' : '' }}">
                                            <a href="{{t_route('settings') }}" class="waves-effect">@lang('General')</a>
                                        </li>
                                    @endt_can
                                    @t_can('resources.read')
                                        <li class="animated-menu {{ Route::currentRouteNameStartsWith([
                                            'direct-personnel',
                                            'subcontract-personnel',
                                            'direct-vehicles-plants',
                                            'subcontract_or_hired-vehicles-plants',
                                            'materials',
                                            'subcontract_or_client-operations',
                                        ])
                                            ? 'mm-active'
                                            : '' }}"
                                            style="opacity: 1;">
                                            <a href="javascript: void(0);" class="has-arrow waves-effect"><span>@lang('Resources')</span></a>

                                            <ul class="sub-menu mm-collapse {{ Route::currentRouteNameStartsWith([
                                                'direct-personnel',
                                                'subcontract-personnel',
                                                'direct-vehicles-plants',
                                                'subcontract_or_hired-vehicles-plants',
                                                'materials',
                                                'subcontract_or_client-operations',
                                            ])
                                                ? 'mm-show'
                                                : '' }}"
                                                aria-expanded="false">
                                                <li class="{{ Route::currentRouteNameStartsWith('direct-personnel') ? 'mm-active' : '' }}">
                                                    <a href="{{t_route('direct-personnel') }}">@lang('Direct Personnel')</a>
                                                </li>
                                                <li class="{{ Route::currentRouteNameStartsWith('subcontract-personnel') ? 'mm-active' : '' }}">
                                                    <a href="{{t_route('subcontract-personnel') }}">@lang('Subcontract Personnel')</a>
                                                </li>
                                                <li class="{{ Route::currentRouteNameStartsWith('direct-vehicles-plants') ? 'mm-active' : '' }}">
                                                    <a href="{{t_route('direct-vehicles-plants') }}">@lang('Direct Vehicles &
                                                                                                                                                    Plants')</a>
                                                </li>
                                                <li
                                                    class="{{ Route::currentRouteNameStartsWith('subcontract_or_hired-vehicles-plants') ? 'mm-active' : '' }}">
                                                    <a href="{{t_route('subcontract_or_hired-vehicles-plants') }}">@lang('Subcontract/
                                                                                                                                                    Hired Vehiles & Plants')</a>
                                                </li>
                                                <li class="{{ Route::currentRouteNameStartsWith('materials') ? 'mm-active' : '' }}">
                                                    <a href="{{t_route('materials') }}">@lang('Materials')</a>
                                                </li>
                                                <li
                                                    class="{{ Route::currentRouteNameStartsWith('subcontract_or_client-operations') ? 'mm-active' : '' }}">
                                                    <a href="{{t_route('subcontract_or_client-operations') }}">@lang('Subcontract /
                                                                                                                                                    Client Operations')</a>
                                                </li>
                                            </ul>
                                        </li>
                                    @endt_can
                                    @t_can('rate-cards.read')
                                        <li class="{{ Route::currentRouteNameStartsWith('rate-cards') ? 'mm-active' : '' }}">
                                            <a href="{{t_route('rate-cards') }}">@lang('Rate Cards')</a>
                                        </li>
                                    @endt_can

                                    @t_can('rate-card-pins.read')
                                        <li class="{{ Route::currentRouteNameStartsWith('rate-card-pins') ? 'mm-active' : '' }}">
                                            <a href="{{t_route('rate-card-pins') }}">@lang('Rate Card Markers')</a>
                                        </li>
                                    @endt_can
                                </ul>
                            </li>

                            <!-- Start of upgrade call to action -->
                            @if (t_profile()->isAdmin())
                                @t_can('profiles.create')
                                    @if (t_profile()->registeredUsersLimitReached())
                                        <div class="alert alert-info alert-dismissible fade show p-3 mt-4 mx-2" style="border-radius: 0;"
                                            role="alert">
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="avatar-sm">
                                                        <i class="bx bx-user-plus display-4"></i>
                                                    </div>
                                                    <div class="px-3">
                                                        <p class="pt-2">Need more profiles?</p>
                                                        <button class="btn btn-sm btn-primary btn-rounded w-md waves-effect waves-light mb-2"
                                                            href="{{t_route('billing') }}"><i class="mdi mdi mdi-credit-card-outline me-1"></i>
                                                            Upgrade</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    @endif
                                @endt_can
                            @endif
                            <!-- End of upgrade call to action -->
                        @endt_can
                    @endif
                @endsubscription_paid
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
