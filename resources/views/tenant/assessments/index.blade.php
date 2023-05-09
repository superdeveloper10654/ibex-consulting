@extends('tenant.layouts.master')

@section('title') @lang('Assessments list') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Assessments @endslot
        @slot('title') Assessments List @endslot

        @t_can('assessments.create')
            @slot('centered_items') 
                <a href="{{ t_route('assessments.create') }}" class="btn btn-primary btn-rounded btn-sm w-md waves-effect waves-light"><i class="mdi mdi-plus me-1"></i> Add New</a>      
            @endslot
        @endt_can
    @endcomponent

    @if ($assessments->isNotEmpty())
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Task order</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($assessments as $assessment)
                                        <tr>
                                            <td>{{ $assessment->id }}</td>
                                            <td>{{ date(AppTenant\Models\Statical\Format::DATE_READABLE, strtotime($assessment->created_at)) }}</td>
                                            <td>{{ $assessment->contract->contract_name }}</td>
                                            <td>{!! $assessment->status()->badge !!}</td>
                                            <td>
                                                <ul class="list-inline font-size-20 contact-links mb-0">
                                                    <li class="list-inline-item px-2">
                                                        <a href="{{ t_route('assessments.show', $assessment->id) }}" title="Show details"><i class="mdi mdi-eye"></i></a>
                                                    </li>
                                                    @t_can('assessments.update')
                                                        <li class="list-inline-item px-2">
                                                            <a href="{{ t_route('assessments.edit', $assessment->id) }}" title="Edit"><i class="mdi mdi-pencil"></i></a>
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
                            <div class="col-lg-12">{{ $assessments->links() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        @lang('No records found')
    @endif

@endsection