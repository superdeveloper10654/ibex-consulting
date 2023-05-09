@extends('tenant.layouts.master')

@section('title')
    @lang('Workflows list')
@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1_link') {{ t_route($route_prefix) }} @endslot
        @slot('li_1') Workflows @endslot
        @slot('title') Workflows List @endslot

        @t_can('workflow.create')
            @slot('centered_items')
                <a href="{{ t_route("$route_prefix.create") }}" class="btn btn-primary btn-rounded w-md waves-effect waves-light">
                    <i class="mdi mdi-plus me-1"></i> Add New
                </a>
            @endslot
        @endt_can
    @endcomponent

    @if ($workflows->isNotEmpty())
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
                                        <th scope="col" width="10%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($workflows as $workflow)
                                        <tr>
                                            <td>{{ $workflow->id }}</td>
                                            <td>{{ $workflow->name }}</td>
                                            <td>
                                                <ul class="list-inline font-size-20 contact-links mb-0">
                                                    @t_can('workflow.show')
                                                        <li class="list-inline-item px-2" title="Show details">
                                                            <a href='{{ t_route("$route_prefix.show", $workflow->id) }}'><i class="mdi mdi-eye"></i></a>
                                                        </li>
                                                    @endt_can
                                                    @t_can('workflow.edit')
                                                        <li class="list-inline-item px-2" title="Edit">
                                                            <a href='{{ t_route("$route_prefix.edit", $workflow->id) }}'
                                                                class='actions-button submit-button'><i
                                                                    class="mdi mdi-pencil"></i></a>
                                                        </li>
                                                    @endt_can
                                                    @t_can('workflow.delete')
                                                        <li class="list-inline-item px-2" title="Delete">
                                                            @php $delete_link = t_route("$route_prefix.delete", $workflow->id) @endphp
                                                            <x-swal.confirm callback-yes='window.location.href="{{ $delete_link }}"'
                                                                title="Are you sure want to delete the workflow?"
                                                                class="mx-auto">
                                                                <a href="#" class='actions-button submit-button'>
                                                                    <i class="mdi mdi-close"></i>
                                                                </a>
                                                            </x-swal.confirm>
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
                            {{-- <div class="col-lg-12">{{ $instructions->links() }}</div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        @lang('No records found')
    @endif

@endsection
