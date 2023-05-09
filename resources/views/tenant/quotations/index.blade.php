@extends('tenant.layouts.master')

@section('title') Quotations list @endsection

@section('content')
    <x-tenant::resource.breadcrumb-index :resource="\AppTenant\Models\Quotation::class" />

    @if ($quotations->isNotEmpty())
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Contract</th>
                                        <th scope="col">Programme</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($quotations as $quotation)
                                        <tr>
                                            <td>{{ $quotation->id }}</td>
                                            <td>{{ $quotation->title }}</td>
                                            <td>
                                                <x-resource.link-with-icon :name="$quotation->contract->contract_name" :resource="$quotation->contract" />
                                            </td>
                                            <td>
                                                <x-resource.link-with-icon :name="$quotation->programme->name"
                                                    :link="t_route('gantt', Illuminate\Support\Facades\Crypt::encryptString($quotation->programme->id))"
                                                />
                                            </td>
                                            <td>{!! $quotation->status()->icon !!} {{ $quotation->status()->name }}</td>
                                            <td>{{ date(AppTenant\Models\Statical\Format::DATE_READABLE, strtotime($quotation->created_at)) }}</td>
                                            <td>
                                                <ul class="list-inline font-size-20 contact-links mb-0">
                                                    <li class="list-inline-item px-2">
                                                        <a href="{{ t_route('quotations.show', $quotation->id) }}" title="Show details"><i class="mdi mdi-eye"></i></a>
                                                    </li>
                                                    @t_can('quotations.update')
                                                        @if ($quotation->canBeUpdated())
                                                            <li class="list-inline-item px-2">
                                                                <a href="{{ t_route('quotations.edit', $quotation->id) }}" title="Update details"><i class="mdi mdi-pencil"></i></a>
                                                            </li>
                                                        @endif
                                                    @endt_can

                                                    @if ($quotation->isDraft() && $quotation->created_by == t_profile()->id)
                                                        <li class="list-inline-item px-2">
                                                            <a href="{{ t_route('quotations.delete-draft', $quotation->id) }}" title="Delete"><i class="mdi mdi-delete"></i></a>
                                                        </li>
                                                    @else
                                                        @if ($quotation->canBeDeleted())
                                                            @t_can('quotations.delete')
                                                                <li class="list-inline-item px-2">
                                                                    <a href="{{ t_route('quotations.delete', $quotation->id) }}" title="Delete"><i class="mdi mdi-delete"></i></a>
                                                                </li>
                                                            @endt_can
                                                        @endif
                                                    @endif
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <x-resource-index.pagination :resources="$quotations" />
                    </div>
                </div>
            </div>
        </div>
    @else
        @lang('No records found')
    @endif

@endsection