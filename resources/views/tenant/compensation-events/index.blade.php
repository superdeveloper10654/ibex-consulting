@extends('tenant.layouts.master')

@section('title') @lang('Compensation Events list') @endsection

@section('content')
    <x-tenant::resource.breadcrumb-index :resource="\AppTenant\Models\CompensationEvent::class" />

    @if ($events->isNotEmpty())
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
                                        <th scope="col">Programme</th>
                                        <th scope="col">Early Warning</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($events as $event)
                                        <tr>
                                            <td>{{ $event->id }}</td>
                                            <td>{{ $event->title }}</td>
                                            <td>
                                                <x-resource.link-with-icon :name="$event->contract->contract_name" :resource="$event->contract" />
                                            </td>
                                            <td>
                                                <x-resource.link-with-icon :name="$event->programme->name" :resource="$event->programme" />
                                            </td>
                                            <td>
                                                @if (!empty($event->early_warning))
                                                    <x-resource.link-with-icon :name="$event->early_warning->title" :resource="$event->early_warning" />
                                                @elseif ($event->early_warning_id == App\Models\Statical\Constant::OPTION_NO_EARLY_WARNING_ID)
                                                    {{ App\Models\Statical\Constant::OPTION_NO_EARLY_WARNING }} 
                                                @endif
                                            </td>
                                            <td>
                                                <x-resource-page.status-label :resource="$event" /> 
                                            </td>
                                            <td>{{ date(AppTenant\Models\Statical\Format::DATE_READABLE, strtotime($event->created_at)) }}</td>
                                            <td>
                                                <ul class="list-inline font-size-20 contact-links mb-0">
                                                    <li class="list-inline-item px-2">
                                                        <a href="{{ t_route('compensation-events.show', $event->id) }}" title="Show details"><i class="mdi mdi-eye"></i></a>
                                                    </li>
                                                    @t_can('compensation-events.update')
                                                        @if ($event->canBeUpdated())
                                                            <li class="list-inline-item px-2">
                                                                <a href="{{ t_route('compensation-events.edit', $event->id) }}" title="Update details"><i class="mdi mdi-pencil"></i></a>
                                                            </li>
                                                        @endif
                                                    @endt_can

                                                    @if ($event->isDraft() && $event->hasAuthor(t_profile()))
                                                        <li class="list-inline-item px-2">
                                                            <a href="{{ t_route('compensation-events.delete-draft', $event->id) }}" title="Delete"><i class="mdi mdi-delete"></i></a>
                                                        </li>
                                                    @else
                                                        @t_can('compensation-events.delete')
                                                            @if ($event->canBeDeleted())
                                                                <li class="list-inline-item px-2">
                                                                    <a href="{{ t_route('compensation-events.delete', $event->id) }}" title="Delete"><i class="mdi mdi-delete"></i></a>
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
                        <x-resource-index.pagination :resources="$events" />
                    </div>
                </div>
            </div>
        </div>
    @else
        @lang('No records found')
    @endif
@endsection