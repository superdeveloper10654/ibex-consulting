@extends('tenant.layouts.master')

@section('title') @lang('Subcontract / Client Operation list') @endsection

@section('content')

@component('components.breadcrumb')
@slot('li_1') Subcontract / Client Operation @endslot
@slot('title') Subcontract / Client Operation List @endslot

@t_can('resources.create')
    @slot('centered_items')
    <a href="{{ t_route('subcontract_or_client-operations.create') }}" class="btn btn-primary btn-rounded btn-sm w-md waves-effect waves-light"><i class="mdi mdi-plus me-1"></i> Add New</a>
    @endslot
@endt_can
@endcomponent

@if ($subcontractOperations->isNotEmpty())
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle table-nowrap table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Operation Name</th>
                                <th scope="col">Subbie Name</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subcontractOperations as $operation)
                            <tr>
                                <td>{{ $operation->id }}</td>
                                <td>{{ $operation->operation_name }}</td>
                                <td>{{ $operation->subbie_name }}</td>
                                <td>
                                    <ul class="list-inline font-size-20 contact-links mb-0">
                                        <li class="list-inline-item px-2">
                                            <a href="{{ t_route('subcontract_or_client-operations.show', $operation->id) }}" title="Show details"><i class="mdi mdi-eye"></i></a>
                                        </li>
                                        @t_can('resources.update')
                                            <li class="list-inline-item px-2">
                                                <a href="{{ t_route('subcontract_or_client-operations.edit', $operation->id) }}" title="Edit details"><i class="mdi mdi-pencil"></i></a>
                                            </li>
                                        @endt_can
                                    </ul>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-12">{{ $subcontractOperations->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
@lang('No records found')
@endif

@endsection