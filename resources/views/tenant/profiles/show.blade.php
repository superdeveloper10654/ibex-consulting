@extends('tenant.layouts.master') 
    @section('title') @lang('Profile') @endsection
    
    @section('content') 
        @component('components.breadcrumb') 
            @slot('li_1') @endslot 
            @slot('title') Profile @endslot 
            
            @if(t_profile()->can('profiles.update') || t_profile()->id == $profile->id)
                @slot('centered_items')
                <a href="{{ t_route('profiles.edit', (t_profile()->id == $profile->id ? App\Models\Statical\Constant::ME : $profile->id)) }}" 
                    class="btn btn-primary btn-rounded btn-sm w-md waves-effect waves-light">Edit profile</a> 
                @endslot
            @endt_can
            
        @endcomponent

<div class="row animated-fast">
    <div class="col-md-4">
        <div class="card animated-fast">
            <div class="card-body">
                <img src="{{ $profile->avatar_url() }}" alt="" class="rounded-circle avatar-lg float-end">
                <h4>{{ $profile->full_name() }}</h4>
                <p>
                    <i class="bx bx-buildings me-2"></i></i>{{ $profile->organisation }}<br>
                    <i class="bx bx-buildings me-2" style="opacity:0;"></i>{{ $profile->department()->name }}
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="row animated-fast">
            <div class="col-md-4 animated-fast">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p><i class="bx bx-envelope me-2"></i>{{ $profile->email }}</p>
                                <p><i class="bx bx-phone me-2"></i>{{ $profile->phone }}</p>
                            </div>
                            <div class="align-self-center p-3">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 animated-fast">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p><i class="bx bx-user me-2"></i> {{ $profile->role()->name }}</p>
                            </div>
                            <div class="align-self-center p-3">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 animated-fast">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium"></p>
                                <h4 class="mb-0"></h4>
                            </div>
                            <div class="align-self-center p-3">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="card animated-fast">
            <div class="card-body">
                <div class="row animated-fast">
                    <h4 class="card-title mb-4"></h4>
                    <div class="ms-auto">
                        <ul class="nav nav-pills">
                            <li class="nav-item">
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row animated-fast">
                    <div class="col-md-4 animated-slow">
                        <p class="text-center"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('script')
<script src="{{ URL::asset('/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>

<script>
    jQuery(($) => {
        $('#update-profile').on('submit', function(e) {
            e.preventDefault();
            removeFormErrors(this);

            form_ajax('{{ t_route("profiles.update", t_profile()->id) }}', this);
        });
    });
</script>
@endsection