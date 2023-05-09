@extends('tenant.layouts.master')
@section('title') @lang('Programmes list') @endsection

@section('content')
    <x-tenant::resource.breadcrumb-index :resource="\AppTenant\Models\Programme::class" />

    @if ($programmes->isNotEmpty())
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
                                        <th scope="col">Contract</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Updated</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($programmes as $programme)
                                    <tr>
                                        <td>{{ $programme->id }}</td>
                                        <td>{{ $programme->name }}</td>
                                        <td>
                                            <x-resource.link-with-icon :name="$programme->contract->contract_name" :resource="$programme->contract" />
                                        </td>
                                        <td>
                                            <x-resource-page.status-label :resource="$programme" />
                                        </td>
                                        <td>{{ date(AppTenant\Models\Statical\Format::DATE_READABLE, strtotime($programme->updated_at)) }}</td>
                                        <td>
                                            <ul class="list-inline font-size-20 contact-links mb-0">
                                                <li class="list-inline-item px-2">
                                                    <a href="{{ t_route('gantt', Crypt::encryptString($programme->id)) }}" title="Show tasks"><i class="mdi mdi-chart-gantt"></i></a>
                                                </li>
                                                <li class="list-inline-item px-2">
                                                    <a href="{{ t_route('programmes.show', $programme->id) }}" title="Show tasks"><i class="mdi mdi-eye"></i></a>
                                                </li>
                                                @t_can('programmes.update')
                                                    @if ($programme->canBeUpdated())
                                                        <li class="list-inline-item px-2">
                                                            <a href="{{ t_route('programmes.edit', Crypt::encryptString($programme->id)) }}" title="Edit programme details"><i class="mdi mdi-pencil"></i></a>
                                                        </li>
                                                    @endif

                                                    @subscription_paid
                                                        <li class="list-inline-item px-2">
                                                            <a href="{{ t_route('addkanbantask', Crypt::encryptString($programme->id)) }}" title="Show kanban details" target="_blank"><i class="fa fa-sm fa-server"></i></a>
                                                        </li>
                                                    @endsubscription_paid
                                                @endt_can

                                                @if ($programme->isDraft() && $programme->hasAuthor(t_profile()))
                                                    <li class="list-inline-item px-1">
                                                        <a href="{{ t_route('programmes.delete-draft', $programme->id) }}" title="Delete"><i class="mdi mdi-delete"></i></a>
                                                    </li>
                                                @else
                                                    @t_can('programmes.delete')
                                                        @if ($programme->canBeDeleted())
                                                            <li class="list-inline-item px-1">
                                                                <x-swal.confirm callback-yes="window.location.href = '{{ t_route('programmes.delete', $programme->id) }}'"
                                                                    title="Are you sure want to delete the programme?"
                                                                    class="mx-auto"
                                                                >
                                                                    <a href="{{ t_route('programmes.delete', $programme->id) }}" title="Delete"><i class="mdi mdi-delete"></i></a>
                                                                </x-swal.confirm>
                                                            </li>
                                                        @endif
                                                    @endt_can
                                                @endif
                                            </ul>
                                        </td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <x-resource-index.pagination :resources="$programmes" />
                    </div>
                </div>
            </div>
        </div>
    @else
        @lang('No records found')
    @endif
@endsection