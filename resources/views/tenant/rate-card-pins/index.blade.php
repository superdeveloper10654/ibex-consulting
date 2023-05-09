@extends('tenant.layouts.master')

@section('title') @lang('Rate Card Markers') @endsection

@section('content')

@component('components.breadcrumb')
    @slot('li_1') Rate Cards @endslot
    @slot('title') Markers @endslot

    @t_can('rate-card-pins.create')
        @slot('centered_items')
        <a href="{{ t_route('rate-card-pins.create') }}" class="btn btn-primary btn-rounded w-md waves-effect waves-light"><i class="mdi mdi-map-marker-plus-outline me-1"></i>Add Marker </a>
        @endslot
    @endt_can
@endcomponent

@if ($pins->isNotEmpty())
<div class="row">
                            @foreach ($pins as $pin)
                            <div class="col-xl-3 col-sm-12">
        <div class="card">
            <div class="card-body">
              <div class="d-flex">
                                            <div class="avatar-md me-4">
                                                <span class="avatar-title rounded-circle bg-light text-danger font-size-16" style="height: 72px; width: 72px;">
                                                    {!! $pin->html !!}
                                                </span>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-dark" style="overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 2;">
                                                  {{ $pin->name }}
                                              </p>
                                                  <p class="text-muted m-0">
                                                    {{ $pin->unit->name }}
                                                  </p>
                                            </div>
                                        </div>
                </div>
<div class="card-footer bg-transparent border-top">
                            <div class="contact-links d-flex font-size-20 text-center">
                              @t_can('rate-card-pins.update')
                                <div class="flex-fill">
                                    <a href="{{ t_route('rate-card-pins.edit', $pin->id) }}" title="Edit"><i class="mdi mdi-pencil text-muted"></i></a>
                                </div>
                              @endt_can
                                        @t_can('rate-card-pins.delete')
                                <div class="flex-fill">
                                    <span type="button" onclick="removeItem('{{ t_route('rate-card-pins.delete', $pin->id) }}', this)" title="Remove"><i class="mdi mdi-trash-can-outline text-muted"></i></span>
                                </div>
                                      @endt_can
                            </div>
                        </div>


            </div>
        </div>
  @endforeach
    </div>

@else
    @lang('No records found')
@endif

@endsection