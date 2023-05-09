@extends('tenant.layouts.master')

@section('title') @lang('Daily work records list') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Daily Work Records @endslot
        @slot('title') Daily Work Records List @endslot

        @t_can('work-records.create')
            @slot('centered_items')
                <a href="{{ t_route('daily-work-records.create') }}" class="btn btn-primary btn-rounded btn-sm w-md waves-effect waves-light"><i class="mdi mdi-plus me-1"></i> Add New</a>
            @endslot
        @endt_can
    @endcomponent
    @if ($dailyWorkRecords->isNotEmpty())
        <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle table-nowrap table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Contract</th>
                                    <th scope="col"> Client Name</th>
                                    <th scope="col">Reference No</th>
                                    <th scope="col">Crew Name</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Site Name</th>
                                    <th scope="col">Supervisor</th>
                                    <th scope="col">Foreman</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dailyWorkRecords as $index=>$dailyWorkRecord)
                                <tr>
                                    <td>{{ $index + 1}}</td>
                                    <td>{{ $dailyWorkRecord->contract->contract_name }}</td>
                                    <td>{{ $dailyWorkRecord->client_profile->name }}</td>
                                    <td>{{ $dailyWorkRecord->reference_no }}</td>
                                    <td>{{ $dailyWorkRecord->crew_name }}</td>
                                    <td>{{ $dailyWorkRecord->date }}</td>
                                    <td>{{ $dailyWorkRecord->site_name }}</td>
                                    <td>{{ $dailyWorkRecord->supervisor_profile->name }}</td>
                                    <td>{{ $dailyWorkRecord->foreman }}</td>
                                    <td>
                                        <ul class="list-inline font-size-20 contact-links mb-0">
                                            <li class="list-inline-item px-2">
                                                <a href="{{ t_route('daily-work-records.show', $dailyWorkRecord->id) }}" title="Show details"><i class="mdi mdi-eye"></i></a>
                                            </li>
                                            <li class="list-inline-item px-2">
                                                <a href="{{ t_route('daily-work-records.edit', $dailyWorkRecord->id) }}" title="Edit details"><i class="mdi mdi-pencil"></i></a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">{{ $dailyWorkRecords->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
        @lang('No records found')
    @endif

@endsection
