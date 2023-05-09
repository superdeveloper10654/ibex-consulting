@extends('tenant.layouts.master')

@section('title') @lang('Early Warnings list') @endsection

@section('content')
    <x-tenant::resource.breadcrumb-index :resource="\AppTenant\Models\EarlyWarning::class" />

    @if ($early_warnings->isNotEmpty())
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
                                        <th scope="col">Title</th>
                                        <th scope="col">Risk Score</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($early_warnings as $early_warning)
                                        <tr>
                                            <td>{{ $early_warning->id }}</td>
                                            <td>
                                                <x-resource.link-with-icon :name="$early_warning->contract->contract_name" :resource="$early_warning->contract" />
                                            </td>
                                            <td>{{ $early_warning->title }}</td>
                                            <td>
                                                <span class="badge fw-bold font-size-14" style="color: #fff; background-color: {{ $early_warning->risk_score_color }}">
                                                    {{ $early_warning->risk_score }}
                                                </span>
                                            </td>
                                            <td>{{ $early_warning->created_at->format(AppTenant\Models\Statical\Format::DATE_READABLE) }}</td>
                                            <td>
                                                <x-resource-page.status-label :resource="$early_warning" />
                                            </td>
                                            <td>
                                                <ul class="list-inline font-size-20 contact-links mb-0">
                                                    <li class="list-inline-item px-1">
                                                        <a href="{{ t_route('early-warnings.show', $early_warning->id) }}" title="Show details"><i class="mdi mdi-eye"></i></a>
                                                    </li>

                                                    @t_can('early-warnings.update')
                                                        @if ($early_warning->canBeUpdated())
                                                            <li class="list-inline-item px-1">
                                                                <a href="{{ t_route('early-warnings.edit', $early_warning->id) }}" title="Update details"><i class="mdi mdi-pencil"></i></a>
                                                            </li>
                                                        @endif
                                                    @endt_can

                                                    @if ($early_warning->isDraft() && $early_warning->hasAuthor(t_profile()))
                                                        <li class="list-inline-item px-1">
                                                            <a href="{{ t_route('early-warnings.delete-draft', $early_warning->id) }}" title="Delete"><i class="mdi mdi-delete"></i></a>
                                                        </li>
                                                    @else
                                                        @t_can('early-warnings.delete')
                                                            @if ($early_warning->canBeDeleted())
                                                                <li class="list-inline-item px-1">
                                                                    <x-swal.confirm callback-yes="window.location.href = '{{ t_route('early-warnings.delete', $early_warning->id) }}'"
                                                                        title="Are you sure want to delete the early warning?"
                                                                        class="mx-auto"
                                                                    >
                                                                        <a href="#" title="Delete"><i class="mdi mdi-delete"></i></a>
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
                        <x-resource-index.pagination :resources="$early_warnings" />
                    </div>
                </div>
            </div>
        </div>
    @else
        @lang('No records found')
    @endif

@endsection
