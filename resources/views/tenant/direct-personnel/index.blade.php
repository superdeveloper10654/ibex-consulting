@extends('tenant.layouts.master')

@section('title') @lang('Direct Personnel list') @endsection

@section('content')

@component('components.breadcrumb')
@slot('li_1') Direct Personnel @endslot
@slot('title') Direct Personnel List @endslot

@t_can('resources.create')
    @slot('centered_items')
    <a href="{{ t_route('direct-personnel.create') }}" class="btn btn-primary btn-rounded btn-sm w-md waves-effect waves-light"><i class="mdi mdi-plus me-1"></i> Add New</a>
    @endslot
@endt_can
@endcomponent

@if ($directPersonnel->isNotEmpty())
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle table-nowrap table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Role</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($directPersonnel as $personnel)
                            <tr>
                                <td>{{ $personnel->id }}</td>
                                <td>{{ $personnel->name }}</td>
                                <td>{{ $personnel->role }}</td>
                                <td>
                                    <ul class="list-inline font-size-20 contact-links mb-0">
                                        <li class="list-inline-item px-2">
                                            <a href="{{ t_route('direct-personnel.show', $personnel->id) }}" title="Show details"><i class="mdi mdi-eye"></i></a>
                                        </li>
                                        @t_can('resources.update')
                                            <li class="list-inline-item px-2">
                                                <a href="{{ t_route('direct-personnel.edit', $personnel->id) }}" title="Edit details"><i class="mdi mdi-pencil"></i></a>
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
                    <div class="col-lg-12">{{ $directPersonnel->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
@lang('No records found')
@endif

@endsection