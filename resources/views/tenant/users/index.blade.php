@extends('tenant.layouts.master')

@section('title') @lang('Profiles list') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') @endslot
        @slot('title') Users List @endslot

        @t_can('users.create')
            @slot('centered_items') 
                <a href="{{ t_route('users.create') }}" class="btn btn-primary btn-rounded btn-sm w-md waves-effect waves-light"><i class="mdi mdi-plus me-1"></i> Add New</a> 
            @endslot
        @endt_can
    @endcomponent


    @if ($profiles->isNotEmpty())
        <div class="row">
            @foreach ($profiles as $profile)
                <div class="col-md-3">
                  <a href="{{ t_route('users.show', $profile->id) }}" title="{{ $profile->full_name() }}">
                    <div class="card animated-fast">
                      <div class="card-body">
                          <img src="{{ $profile->avatar_url() }}" alt="" class="rounded-circle avatar-lg float-end">
                            <h4 class="card-title">{{ $profile->full_name() }}</h4>
                            <p class="text-muted"><i class="bx bx-buildings me-2"></i></i>{{ $profile->organisation }}<br><i class="me-4"></i><small>{{ $profile->department()->name }}</small></p>
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