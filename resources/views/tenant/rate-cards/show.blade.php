@extends('tenant.layouts.master')

@section('title') @lang('Rate Card') #{{ $rateCard->id }} @endsection

@section('content')

@component('components.breadcrumb')
    @slot('li_1') Rate Cards @endslot
    @slot('title') View Details #{{ $rateCard->id }} @endslot
@endcomponent

<div class="row">
    <div class="col-md-8">
        <button type="button" class="d-print-none btn expand-toggle waves-effect mb-2">Expand<span class="expand_icon"> <i class="bx bx-expand"></i></span></button>
        <div class="card">
            <div class="card-body p-lg-5">
                <div class="row">
                    <div class="col-sm-6 mb-5">
                        @if ($rateCard->contract->profile)
                        <img src="{{ asset($rateCard->contract->contractor_profile->avatar_url())}}" alt="logo" height="50" />
                        @else
                        <img src="{{ asset('assets/images/companies/img-5.png')}}" alt="logo" height="50" />
                        @endif

                    </div>
                    <div class="col-sm-6" style="text-align: right">
                        <p>{{ date(AppTenant\Models\Statical\Format::DATE_READABLE, strtotime($rateCard->created_at)) }}</p>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-sm-4">
                        <strong>Contractor</strong><br>
                        {{ $rateCard->contract->contractor_profile->full_name() }}
                    </div>
                    <div class="col-sm-4">
                        <strong> Contract</strong><br>
                        {{ $rateCard->contract->contract_name}}
                    </div>
                    <div class="col-sm-4">
                        <strong> Reference</strong><br>
                        {{ $rateCard->ref}}
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-sm-4">
                        <strong> Pin</strong><br>
                        <div class="d-flex align-items-center">
                            <span class="me-2">{!! $rateCard->pin->html !!}</span>
                            {{ $rateCard->pin->name }}
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <strong> Unit</strong><br>
                        {{ $rateCard->unit}}
                    </div>
                    <div class="col-sm-4">
                        <strong> Rate</strong><br>
                        {{ $rateCard->rate}}
                    </div>
            </div>

            <div class="row border-bottom pb-3 mt-4">
                <div class="col-sm-12">
                    <strong>Description</strong><br>
                    {{ $rateCard->item_desc }}
                </div>
            </div>
            
            <div class="d-print-none mt-2">
                <div class="d-flex justify-content-end">
                    <a href="javascript:window.print()" class="btn btn-secondary btn-rounded w-md waves-effect waves-light"><i class="fa fa-print me-1"></i>&nbsp;Print</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
    jQuery(($) => {
        $('#update-status').on('submit', function(e) {
            e.preventDefault();

            form_ajax('{{ t_route("applications.update-status", $rateCard->id) }}', this);
        });
    });
</script>
@endpush