@extends('tenant.layouts.master')

@section('title') @lang('Payments list') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Payments @endslot
        @slot('title') Payments List @endslot

        @t_can('payments.create')
            @slot('centered_items') 
                {{-- <a href="{{ t_route('payments.create') }}" class="btn btn-primary btn-rounded btn-sm w-md waves-effect waves-light"><i class="mdi mdi-plus me-1"></i> Add New</a>  --}}
            @endslot
        @endt_can
    @endcomponent

    @if ($payments->isNotEmpty())
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
                                    @foreach ($payments as $payment)
                                        <tr>
                                            <td>{{ $payment->id }}</td>
                                            <td>{{ date(AppTenant\Models\Statical\Format::DATE_READABLE, strtotime($payment->created_at)) }}</td>
                                            <td>{{ $payment->contract->contract_name }}</td>
                                            <td>{!! $payment->status()->badge !!}</td>
                                            <td>
                                                <ul class="list-inline font-size-20 contact-links mb-0">
                                                    <li class="list-inline-item px-2">
                                                        <a href="{{ t_route('payments.show', $payment->id) }}" title="Show details"><i class="mdi mdi-eye"></i></a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">{{ $payments->links() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        @lang('No records found')
    @endif

@endsection