@extends('tenant.layouts.master')

@section('title') @lang('Settings list') @endsection

@section('content')

@component('components.breadcrumb')
@slot('li_1') Settings @endslot
@slot('title') Settings List @endslot
@endcomponent

@if ($settings->isNotEmpty())
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle table-hover">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Name</th>
                                <th scope="col" width="30%">Value</th>
                                <th scope="col">status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($settings as $index=> $setting)
                            <tr>
                                <td>{{ $index+1 }}</td>
                                <td>{{ $setting->name }}</td>
                                <td>
                                    <div stylle="max-width:200px">
                                        {{ $setting->value }}
                                    </div>
                                </td>
                                <td>
                                    @if( $setting->status == 1)
                                    <span class='badge rounded-pill bg-success p-2'>Enabled</span>
                                    @else
                                    <span class='badge rounded-pill bg-danger p-2'>Disabled</span>
                                    @endif
                                </td>
                                <td>
                                    <ul class="list-inline font-size-20 contact-links mb-0">
                                        @t_can('notification-settings.edit')
                                        <li class="list-inline-item px-2">
                                            <a href="{{ t_route('notification-settings.edit', $setting->id) }}" class='actions-button submit-button'><i class="mdi mdi-pencil"></i></a>
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
                    <div class="col-lg-12">{{ $settings->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
@lang('No records found')
@endif

@endsection