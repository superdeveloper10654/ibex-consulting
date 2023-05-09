@extends('tenant.layouts.master')

@section('title') @lang('Rate Cards') @endsection

@section('content')

@component('components.breadcrumb')
@slot('li_1') Settings @endslot
@slot('title') Rate Cards @endslot

@t_can('rate-cards.create')
@slot('centered_items')
<a href="{{ t_route('rate-cards.create') }}" class="btn btn-primary btn-rounded w-md waves-effect waves-light"><i class="mdi mdi-plus me-1"></i> Rate Card </a>
@endslot
@endt_can
@endcomponent

@if ($rateCards->isNotEmpty())
<div class="row">
    
      @foreach ($rateCards as $rateCard)
      
          <div class="col-xl-4 col-sm-12">
          <div class="card">
            <div class="card-body">
              <div class="d-flex">
                                            <div class="avatar-md me-4">
                                                <span class="avatar-title rounded-circle bg-light text-danger font-size-16" style="height: 72px; width: 72px;">
                                                    {!! $rateCard->pin_html !!}
                                                </span>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-dark" style="overflow: hidden; display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 2;">
                                                  {{ $rateCard->item_desc}}
                                              </p>
                                                  <p class="text-muted m-0">
                                                   
                                                  </p>
                                            </div>
                                        </div>
                </div>
<div class="card-footer bg-transparent border-top">
                            <div class="contact-links d-flex font-size-20 text-center">
                              {{--@t_can('rate-cards.update')--}}
                                <div class="flex-fill">
                                    <a href="{{ t_route('rate-cards.edit', $rateCard->id) }}" title="Edit"><i class="mdi mdi-pencil text-muted"></i></a>
                                </div>
                              {{--@endt_can--}}
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