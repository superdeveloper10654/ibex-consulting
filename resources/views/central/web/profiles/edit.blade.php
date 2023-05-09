@extends('central.web.layouts.master')

@section('title')
    @lang('User profile') {{ ' ' . $profile_id }}
@endsection

@section('content')

@component('components.breadcrumb')
    @slot('li_1') User profiles @endslot
    @slot('title') Edit profile {{ $profile_id }} @endslot

    {{-- @t_can('profiles.delete')
        @if ($profile_id !== App\Models\Statical\Constant::ME)
            @slot('centered_items')
                <x-swal.confirm callback-yes="window.location.href = '{{ route('profiles.delete', $profile_id) }}'"
                    title="Are you sure want to delete user profile?"
                    :text="$profile->isContractor() ? 'Subcontractor profiles will be deleted either.' : ''"
                    class="mx-auto"
                >
                    <a href="javascript:void(0)" class="btn btn-danger btn-rounded w-md waves-effect waves-light">
                        <i class="bx bx-user-x font-size-20 me-1" style="vertical-align: bottom"></i> Delete profile
                    </a>
                </x-swal.confirm>
            @endslot
        @endif
    @endt_can --}}
@endcomponent

<div class="animated-fast">
    <form class="form-horizontal" method="POST" action="{{ route('profiles.update', $profile_id) }}" enctype="multipart/form-data" id="update-user-profile">
        <div class="row animated-fast">
            @method('PUT')
            @csrf
            <div class="col-md-6">
                <div class="card animated-fast">
                    <div class="card-body">
                        <div class="row animated-fast">
                            <div class="mb-3">
                                <img src="{{ $profile->avatar_url() }}" class="rounded-circle avatar-lg my-3 me-3">
                                <x-form.input label="Profile image" name="avatar" type="file" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card animated-fast">
                    <div class="card-body">
                        <div class="row animated-fast">
                            <div class="mb-3">
                                <x-form.input label="First name" name="first_name" :value="$profile->first_name" />
                            </div>
                        </div>
                        <div class="row animated-fast">
                            <div class="mb-3">
                                <x-form.input label="Last name" name="last_name" :value="$profile->last_name" />
                            </div>
                        </div>
                        <div class="row animated-fast">
                            <div class="mb-3">
                                <x-form.input label="Email" name="email" :value="$profile->email" />
                            </div>
                        </div>
                        <div class="row animated-fast">
                            <div class="mb-3">
                                <x-form.input label="Organisation" name="organisation" :value="$profile->organisation" />
                            </div>
                        </div>

                        <div class="row animated-fast">
                            <div class="mb-3">
                                <x-form.input-with-slot label="New Password" name="password" type="password" placeholder="**********">
                                    <button class="btn btn-light password-addon" type="button"><i class="mdi mdi-eye-outline"></i></button>
                                </x-form.input-with-slot>
                            </div>
                        </div>
                        <div class="row animated-fast">
                            <div class="mb-3">
                                <x-form.input-with-slot label="New Password" name="password_confirmation" type="password" placeholder="**********">
                                    <button class="btn btn-light password-addon" type="button"><i class="mdi mdi-eye-outline"></i></button>
                                </x-form.input-with-slot>
                            </div>
                        </div>

                        <div class="mt-3 d-grid">
                            <button class="btn btn-primary waves-effect waves-light UpdateProfile" type="submit">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('script')
    <script>
        jQuery(($) => {
            $('#update-user-profile').on('submit', function(e) {
                e.preventDefault();
                removeFormErrors(this);

                form_ajax('{{ route("profiles.update", $profile_id) }}', this, {
                    redirect: "{{ route('profiles.edit', $profile_id) }}"
                });
            });
        });
    </script>
@endpush