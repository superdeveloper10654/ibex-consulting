@extends('tenant.layouts.master')

@section('title') 
    @lang('Create User profile')
@endsection

@section('content')

@component('components.breadcrumb')
    @slot('li_1') Users @endslot
    @slot('title') Create User profile @endslot
@endcomponent

<div class="animated-fast">
    <form class="form-horizontal" method="POST" action="{{ t_route('users.store') }}" enctype="multipart/form-data" id="create-user-profile">
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
                                <x-form.input label="Organisation" name="organisation" :value="old('organisation')" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <x-form.select label="Department" name="department" :selected="old('department')" :options="$departments" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <x-form.select label="Role" name="role" :selected="old('role')" :options="$roles" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3">
                                <x-form.input-with-slot label="Password" name="password" type="password">
                                    <button class="btn btn-light password-addon" type="button"><i class="mdi mdi-eye-outline"></i></button>
                                </x-form.input-with-slot>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <x-form.input-with-slot label="Password Confirm" name="password_confirmation" type="password">
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