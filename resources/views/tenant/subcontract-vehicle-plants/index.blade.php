@extends('tenant.layouts.master')

@section('title') @lang('Subcontract / Hired Vehicles & Plants list') @endsection

@section('content')

@component('components.breadcrumb')
@slot('li_1') Subcontract / Hired Vehicles & Plants @endslot
@slot('title') Subcontract / Hired Vehicles & Plants List @endslot

@t_can('resources.create')
    @slot('centered_items')
    <a href="{{ t_route('subcontract_or_hired-vehicles-plants.create') }}" class="btn btn-primary btn-rounded btn-sm w-md waves-effect waves-light"><i class="mdi mdi-plus me-1"></i> Add New</a>
    @endslot
@endt_can
@endcomponent

@if ($subcontractVehiclePlants->isNotEmpty())
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
                                <th scope="col">Supplier Name</th>
                                <th scope="col">Reference No</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subcontractVehiclePlants as $vehiclePlant)
                            <tr>
                                <td>{{ $vehiclePlant->id }}</td>
                                <td>{{ $vehiclePlant->vehicle_or_plant_name }}</td>
                                <td>{{ $vehiclePlant->supplier_name }}</td>
                                <td>{{ $vehiclePlant->ref_no }}</td>
                                <td>
                                    <ul class="list-inline font-size-20 contact-links mb-0">
                                        <li class="list-inline-item px-2">
                                            <a href="{{ t_route('subcontract_or_hired-vehicles-plants.show', $vehiclePlant->id) }}" title="Show details"><i class="mdi mdi-eye"></i></a>
                                        </li>
                                        @t_can('resources.update')
                                            <li class="list-inline-item px-2">
                                                <a href="{{ t_route('subcontract_or_hired-vehicles-plants.edit', $vehiclePlant->id) }}" title="Edit details"><i class="mdi mdi-pencil"></i></a>
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
                    <div class="col-lg-12">{{ $subcontractVehiclePlants->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
@lang('No records found')
@endif

@endsection