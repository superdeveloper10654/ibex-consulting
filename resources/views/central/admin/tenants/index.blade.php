@extends('central.admin.layouts.master')

@section('title') Tenants list @endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Tenants @endslot
        @slot('title') Tenants list @endslot

        @slot('centered_items')
            <a href="{{ ca_route('tenants.create') }}" class="btn btn-primary btn-rounded w-md waves-effect waves-light">
                <i class="mdi mdi-alert-plus-outline font-size-20 me-1" style="vertical-align: middle"></i> Create tenant
            </a>
        @endslot
    @endcomponent

    @if ($tenants->isNotEmpty())
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Id</th>
                                        <th scope="col">Subscription</th>
                                        <th scope="col">Team count</th>
                                        <th scope="col">Projects</th>
                                        <th scope="col">Last activity</th>
                                        <th scope="col">Created</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tenants as $tenant)
                                        <tr>
                                            <td>{{ $tenant->id }}</td>
                                            <td>
                                                @if ($tenant->has_demo_subscription)
                                                    <span class="alert alert-dark py-1 px-3">Demo</span>
                                                @elseif ($tenant->has_paid_subscription)
                                                    <span class="alert alert-success py-1 px-3">Paid</span>
                                                @else
                                                    <span class="alert py-1 px-3">No subscription</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $tenant->team_users_count }}
                                            </td>
                                            <td>
                                                {{ $tenant->projects_count }}
                                            </td>
                                            <td>
                                                @if (!empty($tenant->last_activity_created_at))
                                                    {{ $tenant->last_activity_created_at }} 
                                                @else
                                                    No activities
                                                @endif
                                            </td>
                                            <td>
                                                {{ $tenant->created_at->format(AppTenant\Models\Statical\Format::DATE_READABLE) }}
                                            </td>
                                            <td>
                                                <ul class="list-inline font-size-20 contact-links mb-0">
                                                    <li class="list-inline-item px-2">
                                                        <a href="javascript:void(0)" onclick="loginOnTenant('{{ $tenant->id }}')" title="Login as Admin">
                                                            <i class="mdi mdi-login"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item px-2">
                                                        <x-swal.confirm 
                                                            callback-yes="deleteTenant('{{ $tenant->id }}')"
                                                            title="Are you sure want to delete tenant?"
                                                            text="All the files and database data will be deleted without ability to restore."
                                                            class="mx-auto"
                                                        >
                                                            <a href="javascript:void(0)" title="Delete tenant"><i class="mdi mdi-delete"></i></a>
                                                        </x-swal.confirm>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <x-resource-index.pagination :resources="$tenants" />
                    </div>
                </div>
            </div>
        </div>
    @else
        @lang('No records found')
    @endif
@endsection

@push('script')
    <script>
        function deleteTenant(id) {
            let url = "{{ ca_route('tenants.delete', '_id_') }}".replace('_id_', id);

            myAjax(url)
                .then(() => {
                    successMsg('Deleted');
                    window.location.reload();
                });
        }

        function loginOnTenant(id) {
            let url = "{{ ca_route('tenants.login-as-admin', '_id_') }}".replace('_id_', id);

            myAjax(url)
                .then((res) => {
                    successMsg('Logged in');
                    window.open(res.data.redirect, '_blank').focus();
                });
        }
    </script>
@endpush