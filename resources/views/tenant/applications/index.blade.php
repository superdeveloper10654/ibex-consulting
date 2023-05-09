@extends('tenant.layouts.master')

@section('title') @lang('Applications list') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Applications @endslot
        @slot('title') Applications List @endslot

        @t_can('applications.create')
            @slot('centered_items')
                <a href="{{ t_route('applications.create') }}" class="btn btn-primary btn-rounded w-md waves-effect waves-light"><i class="mdi mdi-plus me-1"></i> Application</a>
            @endslot
        @endt_can
    @endcomponent

    @if ($applications->isNotEmpty())
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
                                        <th scope="col">Contract</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($applications as $application)
                                        <tr>
                                            <td>{{ $application->id }}</td>
                                            <td>{{ date(AppTenant\Models\Statical\Format::DATE_READABLE, strtotime($application->created_at)) }}</td>
                                            <td>{{ $application->contract->contract_name}}</td>
                                            <td>{!! $application->status()->badge !!}</td>
                                            <td>
                                                <ul class="list-inline font-size-20 contact-links mb-0">
                                                    <li class="list-inline-item px-2">
                                                        <a href="{{ t_route('applications.show', $application->id) }}" title="Show details"><i class="mdi mdi-eye"></i></a>
                                                    </li>
                                                    @t_can('applications.read')
                                                        @if ($application->isDraft())
                                                            <li class="list-inline-item px-2">
                                                                <a href="{{ t_route('applications.edit', $application->id) }}" title="Edit"><i class="mdi mdi-pencil"></i></a>
                                                            </li>
                                                        @endif
                                                    @endt_can
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">{{ $applications->links() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        @lang('No records found')
    @endif

@endsection
