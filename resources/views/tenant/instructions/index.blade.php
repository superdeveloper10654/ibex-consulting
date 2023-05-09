@extends('tenant.layouts.master')

@section('title') @lang('Instructions list') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Instructions @endslot
        @slot('title') Instructions List @endslot

        @t_can('instructions.create')
            @slot('centered_items') 
                <a href="{{ t_route('instructions.create') }}" class="btn btn-primary btn-rounded btn-sm w-md waves-effect waves-light"><i class="mdi mdi-plus me-1"></i> Add New</a> 
            @endslot
        @endt_can
    @endcomponent

    @if ($instructions->isNotEmpty())
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Contract</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Status</th>
                                        <th scope="col" width="10%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($instructions as $instruction)
                                        <tr>
                                            <td>{{ $instruction->contract->id }}</td>
                                            <td>{{ $instruction->contract->contract_name }}</td>
                                            <td>{{ $instruction->title }}</td>
                                            <td>{{ $instruction->status()->name }}</td>
                                            <td>
                                                <ul class="list-inline font-size-20 contact-links mb-0">
                                                    @t_can('instructions.read')
                                                        <li class="list-inline-item px-2">
                                                            <a href="{{ t_route('instructions.show', $instruction->id) }}" title="Show details"><i class="mdi mdi-eye"></i></a>
                                                        </li>
                                                    @endt_can

                                                    @t_can('instructions.update')
                                                        <li class="list-inline-item px-2">
                                                            <a href="{{ t_route('instructions.edit', $instruction->id) }}" class='actions-button submit-button'><i class="mdi mdi-pencil"></i></a>
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
                            <div class="col-lg-12">{{ $instructions->links() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        @lang('No records found')
    @endif

@endsection