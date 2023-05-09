@extends('tenant.layouts.master')

@section('title') @lang('Measures list') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Measures @endslot
        @slot('title') Measures List @endslot

        @t_can('measures.create')
            @slot('centered_items')
                <a href="{{ t_route('measures.create') }}" class="btn btn-primary btn-rounded w-md waves-effect waves-light"><i class="mdi mdi-plus me-1"></i> Measure</a>
            @endslot
        @endt_can
    @endcomponent

    @if ($measures->isNotEmpty())
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap table-hover">
                                <thead>
                                    <tr>
                                        {{-- <th scope="col">Task Order</th> --}}
                                        <th scope="col">Contract</th>
                                        <th scope="col">Site name</th>
                                        <th scope="col">Measured by</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Status</th>
                                        <th scope="col" width="10%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($measures as $measure)
                                        <tr>
                                            <td>{{ $measure->contract->contract_name }}</td>
                                            <td>{{ $measure->site_name }}</td>
                                            <td>{{ $measure->profile->full_name() }}</td>
                                            <td>{{ date(AppTenant\Models\Statical\Format::DATE_READABLE, strtotime($measure->created_at)) }}</td>
                                            <td>{!! $measure->status()->badge !!}</td>
                                            <td>
                                                <ul class="list-inline font-size-20 contact-links mb-0">
                                                    <li class="list-inline-item px-2">
                                                        <a href="{{ t_route('measures.show', $measure->id) }}" title="Show details"><i class="mdi mdi-eye"></i></a>
                                                    </li>
                                                    @t_can('measures.delete')
                                                    <li class="list-inline-item">
                                                        <span type="button" onclick="removeItem('{{ t_route('measures.delete', $measure->id) }}', this)" title="Remove"><i class="mdi mdi-close-box"></i></span>
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
                            <div class="col-lg-12">{{ $measures->links() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        @lang('No records found')
    @endif

@endsection
