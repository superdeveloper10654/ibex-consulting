@extends('tenant.layouts.master')

@section('title') 
    @lang('Create User profile')
@endsection

@section('content')

@component('components.breadcrumb')
    @slot('li_1') Profiles @endslot
    @slot('title') Create User profile @endslot
@endcomponent

<div class="animated-fast">
    <form class="form-horizontal" method="POST" action="{{ t_route('profiles.store') }}" enctype="multipart/form-data" id="create-user-profile">
        <div class="row">
            <div class="col-md-5">
                <div class="card animated-fast">
                    <div class="card-body">
                        @csrf
                        <div class="row">
                            <div class="mb-3">
                                <x-form.input label="Profile image" name="avatar" type="file" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <x-form.input label="First name" name="first_name" :value="old('first_name')" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <x-form.input label="Last name" name="last_name" :value="old('last_name')" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <x-form.input label="Email" name="email" :value="old('email')" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <x-form.input label="Organisation" name="organisation" :value="old('organisation', $contractor_profile->organisation ?? '')" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <x-form.select label="Department" 
                                    name="department"
                                    :selected="old('department', isPaidSubscription() ? ($contractor_profile->department ?? '') : AppTenant\Models\Statical\Department::COMMERCIAL_ID)"
                                    :options="$departments"
                                    :disabled="!isPaidSubscription()"
                                />
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <x-form.select label="Role" 
                                    name="role" 
                                    :selected="old('role', !empty($contractor_profile) ? AppTenant\Models\Statical\Role::SUBCONTRACTOR_ID : '')" 
                                    :options="$roles"
                                />
                            </div>
                        </div>
                        <div class="row contractor-parent-id" style="{{ empty($contractor_profile) ? 'display:none' : '' }}">
                            <div class="mb-3">
                                <x-form.select label="Contractor" name="parent_id" :selected="old('contractor', $contractor_profile->id ?? '')" :options="$contractors->pluck('name', 'id')" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3">
                                <x-form.input-with-slot label="Password" name="password" type="password" placeholder="**********">
                                    <button class="btn btn-light password-addon" type="button"><i class="mdi mdi-eye-outline"></i></button>
                                </x-form.input-with-slot>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <x-form.input-with-slot label="Password Confirm" name="password_confirmation" type="password" placeholder="**********">
                                    <button class="btn btn-light password-addon" type="button"><i class="mdi mdi-eye-outline"></i></button>
                                </x-form.input-with-slot>
                            </div>
                        </div>

                        <div class="mt-3 d-grid">
                            <button class="btn btn-primary waves-effect waves-light" data-id="{{ t_profile()->id }}" type="submit">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@include('tenant.profiles.create-edit-scripts')