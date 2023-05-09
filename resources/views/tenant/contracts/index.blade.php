@extends('tenant.layouts.master')

@section('title') @lang('Contracts') @endsection

@section('css')
<style>

</style>
<!-- dragula css -->
<link href="{{ URL::asset('/assets/libs/dragula/dragula.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

@component('components.breadcrumb')
@slot('li_1') Contracts @endslot
@slot('title') Contracts @endslot

@t_can('contracts.create')
    @if (isPaidSubscription() || count($contracts) < env('DEMO_MAX_CONTRACTS'))
        @slot('centered_items')
            <a href="{{ t_route('contracts.create') }}" class="btn btn-primary btn-rounded w-md waves-effect waves-light"><i class="mdi mdi-plus me-1"></i> Contract</a>
        @endslot
    @endif
@endt_can
@endcomponent

@if ($contracts->isNotEmpty())

<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="dropdown float-end">
                    <a href="#" class="dropdown-toggle arrow-none" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-dots-vertical m-0 text-muted h5"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="#">Edit</a>
                        <a class="dropdown-item" href="#">Hide</a>
                    </div>
                </div> <!-- end dropdown -->

                <h4 class="card-title mb-4">Pending</h4>
            </div>
        </div>
    </div>
    <!-- end col -->

    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="dropdown float-end">
                    <a href="#" class="dropdown-toggle arrow-none" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-dots-vertical m-0 text-muted h5"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="#">Edit</a>
                        <a class="dropdown-item" href="#">Hide</a>
                    </div>
                </div> <!-- end dropdown -->

                <h4 class="card-title mb-4">Active</h4>
              @foreach ($contracts as $contract)
                <div id="">
                    <div id="" class="pb-1">

                        <div class="card contract-card" id="">
                            <div class="card-body">

                                <div class="float-end ml-2">
                                    <span class="badge bg-info font-size-12">{{ $contract->contract_type }}</span>
                                </div>
                                <div>
                                    <h5 class="mb-3"><a href="{{ t_route('contracts.show', $contract->id) }}" class="text-dark">{{ $contract->contract_name }}</a></h5>
                                    
                                </div>

                                <ul class="list-inine ps-0 text-center">
                                    <li class="list-inline-item">
                                        <div class="avatar-sm me-2">
                        <span class="avatar-title rounded-circle bg-light text-danger font-size-16">
                            <img class="w-100 rounded-circle" src="{{ $contract->img_url() }}" alt="@lang('Contract icon')">
                        </span>
                    </div>
                                    </li>
                                    <li class="list-inline-item">
                                        <div class="avatar-sm ms-2">
                        <span class="avatar-title rounded-circle bg-light text-danger font-size-16">
                            <img class="w-100 rounded-circle" src="{{ $contract->img_url() }}" alt="@lang('Contract icon')">
                        </span>
                    </div>
                                    </li>
                                </ul>

                                <div class="text-end">
                                  <p class="text-muted m-0">{{ date(AppTenant\Models\Statical\Format::DATE_READABLE, strtotime($contract->created_at)) }}</p>
                                    <p class="text-muted m-0">£2.37M</p>
                                </div>
                            </div>
<div class="card-footer bg-transparent border-top">
                <div class="contact-links d-flex font-size-20 text-center">
                    <div class="flex-fill" style="border-right: solid 1px #ddd;">
                        <a href="{{ t_route('contracts.show', $contract->id) }}" title="@lang('Show details')"><i class="mdi mdi-eye"></i></a>
                    </div>
                    @t_can('contracts.update')
                        <div class="flex-fill">
                            <a href="{{ t_route('contracts.edit', $contract->id) }}" title="Edit"><i class="mdi mdi-pencil"></i></a>
                        </div>
                    @endt_can
                </div>
            </div>
                        </div>
                        <!-- end task card -->
                      

                    </div>

                    <div class="text-center d-grid">
                        
                    </div>
                </div>
              @endforeach
            </div>
        </div>
    </div>
    <!-- end col -->

    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="dropdown float-end">
                    <a href="#" class="dropdown-toggle arrow-none" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-dots-vertical m-0 text-muted h5"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="#">Edit</a>
                        <a class="dropdown-item" href="#">Hide</a>
                    </div>
                </div> <!-- end dropdown -->

                <h4 class="card-title mb-4">Completed</h4>

            </div>
        </div>
    </div>
    <!-- end col -->
</div>


@else
@lang('No records found')
@endif

@endsection