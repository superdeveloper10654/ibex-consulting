@extends('tenant.layouts.master')

@section('title') @lang('Mitigations list') @endsection

@section('content')
    <x-tenant::resource.breadcrumb-index :resource="\AppTenant\Models\Mitigation::class" />

    @if ($mitigations->isNotEmpty())
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
                                        <th scope="col">Early Warning</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mitigations as $mitigation)
                                        <tr>
                                            <td>{{ $mitigation->id }}</td>
                                            <td>{{ $mitigation->name }}</td>
                                            <td>
                                                {{ $mitigation->early_warning->title }} 
                                                <a href="{{ t_route('early-warnings.show', $mitigation->early_warning->id) }}"><i class="mdi mdi-link-variant"></i></a>
                                            </td>
                                            <td>
                                                <x-resource-page.status-label :resource="$mitigation" />    
                                            </td>
                                            <td>{{ date(AppTenant\Models\Statical\Format::DATE_READABLE, strtotime($mitigation->created_at)) }}</td>
                                            <td>
                                                <ul class="list-inline font-size-20 contact-links mb-0">
                                                    <li class="list-inline-item px-1">
                                                        <a href="{{ t_route('mitigations.show', $mitigation->id) }}" title="Show details"><i class="mdi mdi-eye"></i></a>
                                                    </li>
                                                    @t_can('mitigations.update')
                                                        @if ($mitigation->isNotified())
                                                            <li class="list-inline-item px-1">
                                                                @empty($mitigation->early_warning->compensation_event)
                                                                    <a href="{{ t_route('compensation-events.create') . '?mitigation_id=' . $mitigation->id }}" title="Notify a CE">
                                                                        <i class="mdi mdi-scale-balance"></i>
                                                                    </a>
                                                                @else
                                                                    <a href="{{ t_route('compensation-events.show', $mitigation->early_warning->compensation_event->id) }}" title="Show CE">
                                                                        <i class="mdi mdi-scale-balance" style="color: #556ee6"></i>
                                                                    </a>
                                                                @endempty
                                                            </li>
                                                        @endif

                                                        @if ($mitigation->canBeUpdated())
                                                            <li class="list-inline-item px-1">
                                                                <a href="{{ t_route('mitigations.edit', $mitigation->id) }}" title="Update details"><i class="mdi mdi-pencil"></i></a>
                                                            </li>
                                                        @endif
                                                    @endt_can

                                                    @if ($mitigation->isDraft() && $mitigation->created_by == t_profile()->id)
                                                        <li class="list-inline-item px-1">
                                                            <a href="{{ t_route('mitigations.delete-draft', $mitigation->id) }}" title="Delete"><i class="mdi mdi-delete"></i></a>
                                                        </li>
                                                    @else
                                                        @t_can('mitigations.delete')
                                                            @if ($mitigation->canBeDeleted())
                                                                <li class="list-inline-item px-1">
                                                                    <a href="{{ t_route('mitigations.delete', $mitigation->id) }}" title="Delete"><i class="mdi mdi-delete"></i></a>
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
                        <x-resource-index.pagination :resources="$mitigations" />
                    </div>
                </div>
            </div>
        </div>
    @else
        @lang('No records found')
    @endif

@endsection