@extends('tenant.layouts.master')

@section('title') @lang('Profiles') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') @endslot
        @slot('title') Profiles @endslot

        @t_can('profiles.create')
            @slot('centered_items')
                @if (t_profile()->isAdmin())
                    @if (!admin_profile()->registeredUsersLimitReached())
                        <a href="{{ t_route('profiles.create') }}" class="btn btn-primary btn-rounded w-md waves-effect waves-light"><i class="bx bx-user-plus font-size-20 me-1" style="vertical-align: bottom"></i> Add profile </a>
                    @elseif (admin_profile()->registeredUsersLimitReached())
                        <!-- leave empty -->
                    @endif
                @endif
            @endslot
        @endt_can
    @endcomponent

    @if (t_profile()->isAdmin())
        @t_can('profiles.create')
            @if (admin_profile()->registeredUsersLimitReached())
                <div class="alert alert-info text-center pt-4 pb-4 mb-4" role="alert">
                    <p>Please upgrade your subcription to create more profiles</p>
                    <a class="btn btn-primary btn-rounded w-md waves-effect waves" href="{{ t_route('billing') }}"><i class="mdi mdi mdi-credit-card-outline me-1"></i> Upgrade</a>
                </div>
            @endif
        @endt_can
    @endif

    @if ($profiles->isNotEmpty())
        <div class="row">
            @foreach ($profiles as $profile)
                <div class="col-md-4">
                    <a href="{{ t_route('profiles.show', (t_profile()->id == $profile->id ? App\Models\Statical\Constant::ME : $profile->id)) }}" title="{{ $profile->full_name() }}">
                        <div class="card animated-fast">
                            <div class="card-body">
                                <img src="{{ $profile->avatar_url() }}" alt="" class="rounded-circle avatar-lg float-end">
                                <h4 class="card-title">{{ $profile->full_name() }}</h4>
                                <p class="text-muted">{{ $profile->organisation }}<br><small>{{ $profile->role()->name }}</small><br><small>{{ $profile->department()->name }}</small></p>
                            </div>
                            <div class="px-4 py-3 border-top text d-flex justify-content-end">
                                @if (t_profile()->can('profiles.create'))
                                    @if ($profile->isContractor() && !admin_profile()->registeredUsersLimitReached())
                                        <a class="mx-2"1
                                            style="color: var(--bs-body-color)"
                                            href="{{ t_route('profiles.create-subcontractor', $profile->id) }}"
                                            title="Add Subcontractor"
                                        >
                                            <i class="mdi mdi-account-plus font-size-20"></i>
                                        </a>
                                    @endif
                                @endif
                                @if (t_profile()->can('profiles.update') || t_profile()->id == $profile->id)
                                    <a class="mx-2" 
                                        style="color: var(--bs-body-color)" 
                                        href="{{ t_route('profiles.edit', (t_profile()->id == $profile->id ? \App\Models\Statical\Constant::ME : $profile->id)) }}"
                                        title="Edit profile"
                                    >
                                        <i class="mdi mdi-pencil font-size-20"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-lg-12">{{ $profiles->links() }}</div>
        </div>
    @else
        @lang('No records found')
    @endif
@endsection