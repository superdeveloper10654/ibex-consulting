@extends('tenant.layouts.master')

@section('title') 
    @lang('User profile') {{ ' ' . $profile->id }}
@endsection

@section('content')

@component('components.breadcrumb')
    @slot('li_1') Users @endslot
    @slot('title') User profile {{ $profile->id }} @endslot

    @t_can('users.delete')
        @slot('centered_items') 
            <a href="{{ t_route('users.delete', $profile->id) }}" class="btn btn-danger btn-rounded btn-sm w-md waves-effect waves-light" onclick="return confirm('Are you sure want to delete user profile?')">Delete profile</a> 
        @endslot
    @endt_can
@endcomponent

<div class="animated-fast">
    <form class="form-horizontal" method="POST" action="{{ t_route('users.update', $profile->id) }}" enctype="multipart/form-data" id="update-user-profile">
        <div class="row">
            <div class="col-md-5 border-end">
                <div class="card animated-fast">
                    <div class="card-body">
                        @csrf
                        <div class="row">
                            <div class="mb-3">
                                <img src="{{ $profile->avatar_url() }}" class="rounded-circle avatar-lg float-end my-3">
                                <x-form.input label="Profile image" name="avatar" type="file" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <x-form.input label="First name" name="first_name" :value="$profile->first_name" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <x-form.input label="Last name" name="last_name" :value="$profile->last_name" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <x-form.input label="Email" name="email" :value="$profile->email" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <x-form.input label="Organisation" name="organisation" :value="$profile->organisation" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <x-form.select label="Department" name="department" :selected="$profile->department()->id" :options="$departments" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <x-form.select label="Role" name="role" :selected="$profile->role" :options="$roles" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3">
                                <x-form.input-with-slot label="New Password" name="new_password" type="password" placeholder="**********">
                                    <button class="btn btn-light password-addon" type="button"><i class="mdi mdi-eye-outline"></i></button>
                                </x-form.input-with-slot>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <x-form.input-with-slot label="Password Confirm" name="new_password_confirmation" type="password" placeholder="**********">
                                    <button class="btn btn-light password-addon" type="button"><i class="mdi mdi-eye-outline"></i></button>
                                </x-form.input-with-slot>
                            </div>
                        </div>

                        <div class="mt-3 d-grid">
                            <button class="btn btn-primary waves-effect waves-light UpdateProfile" data-id="{{ t_profile()->id }}" type="submit">Update</button>
                        </div>
                    </div>
                </div>
            </div>
            @if ($profile->isAdmin())
                <div class="col-md-5">
                    <div class="card animated-fast">
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3">
                                    <label class="form-label">Subscription</label>
                                    
                                    <h3>
                                        @if ($profile->onTrial())
                                            <span class='badge bg-warning p-2 w-md'>Trial</span>
                                        @elseif (!$profile->subscribed())
                                            <span class='badge bg-dark p-2 w-md'>Not subscribed</span>
                                        @else
                                            <span class='badge bg-success p-2 w-md'>{{ $profile->sparkPlan() ? $profile->sparkPlan()->name : 'Unrecognized subscription' }}</span>
                                            <a href="{{ t_route('users.unsubscribe', $profile->id) }}" class="btn btn-secondary waves-effect waves-light ms-3" onclick="return confirm('Are you sure want to unsubscribe the user?')">Unsubscribe</a>
                                        @endif
                                    </h3>
                                </div>
                            </div>

                            @if ($profile->subscribed())
                                <div class="row">
                                    <div class="mb-3">
                                        <label class="form-label">Stripe id</label>
                                        <div>{{ $profile->stripe_id }}</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3">
                                        <label class="form-label">Subscribed</label>
                                        <div>{{ $profile->subscriptions->first()->created_at->toDayDateTimeString() }}</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3">
                                        <label class="form-label">Subscribed users</label>
                                        <div>{{ $profile->team_users_count }}</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </form>
</div>

@endsection