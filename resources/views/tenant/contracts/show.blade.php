@extends('tenant.layouts.master')

@section('title')
    Contract #{{ $contract->id }} | {{ $contract->contract_type }}
@endsection
@section('css')
    <style>
      
        input[type=text] {
            /* min-width: 70px !important; */
            /* width: fit-content !important; */
            max-width: 100%;
        }

        input[type=number] {
            min-width: 50px !important;
            -moz-appearance: textfield;
        }

        .form-control:disabled {
            background-color: #f3f6ea !important;
            opacity: 1;
        }

        .underline {
            display: inline;
            width: 80px;
            text-decoration-line: underline;
            text-decoration-style: dotted;
            text-decoration-color: #c03;
            text-decoration-thickness: 0.1em;
        }
    </style>
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Contracts
        @endslot
        @slot('title')
            #{{ $contract->id }} | {{ $contract->contract_type }}
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-md-8 left-col">
            <div class="header-wrapper d-flex justify-content-between d-print-none">
                <x-resource-page.button.expand />
            </div>
            <div class="card p-5 data-wrapper">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6 mb-5">
                            @if (settingGetLink(AppTenant\Models\Setting::KEY_ORGANISATION_LOGO))
                                <img src="{{ settingGetLink(AppTenant\Models\Setting::KEY_ORGANISATION_LOGO) }}" alt="logo" height="50" />
                            @endif
                        </div>
                        <div class="col-sm-6" style="text-align: right">
                            <h4 class="font-size-18 fw-bold">
                                <span class="ps-3">Contract #{{ $contract->id }} | {{ $contract->contract_type }}</span>
                            </h4>
                            <p>{{ date(AppTenant\Models\Statical\Format::DATE_READABLE, strtotime($contract->created_at)) }}</p>
                        </div>
                    </div>
                    <div class="row pb-3">
                        <div class="col-sm-4">
                            <strong>Contractor</strong><br>
                            {{ $contract->contractor_profile->organisation }}
                        </div>
                        <div class="col-sm-8">
                            <strong>Title</strong><br>
                            {{ $contract->contract_name }}
                        </div>
                    </div>
                    <div class="row pb-3">
                        <div class="col-6">
                            <strong>Latitude</strong><br>
                            {{ $contract->latitude }}
                        </div>
                        <div class="col-6">
                            <strong>Longitude</strong><br>
                            {{ $contract->longitude }}
                        </div>
                        <div class="col-12 mb-3 print-no-break">
                            <label class="form-label">Map</label>
                            <div class="col-sm-12 mb-3">
                                <div id="map" class="form-control" style="height: 250px; width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-5 pb-3 mb-3">
                            <h4 class="contrast">{{ str_contains($contractType, 'TSC') ? 'Service' : 'Works' }} Information</h4><br>
                            {{ $contract->main_opt }}
                    </div>
                  
                    @include('tenant.contracts.contract-details.step2')
                    @include('tenant.contracts.contract-details.step3')
                    @include('tenant.contracts.contract-details.step4')
                    @include('tenant.contracts.contract-details.step5')
                    @include('tenant.contracts.contract-details.step6')
                    @include('tenant.contracts.contract-details.step7')
                    @include('tenant.contracts.contract-details.step8')
                    @include('tenant.contracts.contract-details.step9')

                    @if ($contractData2 && $nec4ContractData2)
                        <h5 class="pt-5 border-top">Part two - Data provided by the
                            @if (str_contains($contractType, 'ECS'))
                                <i>Subcontractor</i>
                            @else
                                <i>Contractor</i>
                            @endif
                        </h5>

                        @include('tenant.contracts.contract-details.step10')
                        @include('tenant.contracts.contract-details.step11')
                    @endif

                    @include('tenant.contracts.contract-details.step12')

                    <div class="d-print-none">
                        <div class="float-end">
                            <a href="javascript:window.print()" class="btn btn-secondary btn-rounded w-md waves-effect waves-light">
                                <i class="fa fa-print me-1"></i>&nbsp;Print
                            </a>
                            <a href="{{ t_route('contracts.edit', $contract->id) }}" 
                                class="btn btn-outline-secondary btn-rounded w-md waves-effect waves-light mx-1"
                            >
                                <i class="mdi mdi-book-edit-outline me-1"></i>&nbsp;Edit
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-resource-page.right-tabs
            :resource="$contract"
            :uploads-files="$files"
            :uploads-folder="AppTenant\Models\Statical\MediaCollection::COLLECTION_CONTRACTS"
            :comments-request-url="t_route('contracts.add-comment', $contract->id)"
        />
    </div>

@endsection
@section('script')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_KEY') }}&callback=initMap&libraries=&v=weekly" async></script>
    <script>
        let map;
        let lat = '<?php echo $contract->latitude; ?>';
        let lng = '<?php echo $contract->longitude; ?>';

        function initMap() {
            let conf = googleMapsNightConf();
            conf.center = new google.maps.LatLng(lat, lng);
            conf.zoom = 10;

            const map = new google.maps.Map(document.getElementById("map"), conf);

            myMarker = new google.maps.Marker({
                position: map.getCenter(),
                map: map,
                draggable: true
            });
        }
    </script>
    @include('tenant.contracts.except-reply-periods-dynamic')
    @include('tenant.contracts.access-dates-dynamic')
    @include('tenant.contracts.condition-key-dates-dynamic')
    @include('tenant.contracts.defect-except-periods-dynamic')
    @include('tenant.contracts.step8-dynamic')
    @include('tenant.contracts.senior-representatives-dynamic')
    @include('tenant.contracts.price-adjustment-factor-proportions-dynamic')
    @include('tenant.contracts.pay-item-activities-dynamic')
    @include('tenant.contracts.work-section-completion-dates-dynamic')
    @include('tenant.contracts.work-section-bonuses-dynamic')
    @include('tenant.contracts.work-section-delay-damages-dynamic')
    @include('tenant.contracts.undertakings-to-clients-dynamic')
    @include('tenant.contracts.undertakings-to-others-dynamic')
    @include('tenant.contracts.subcontractor-undertakings-to-others-dynamic')
    @include('tenant.contracts.low-performance-damage-amounts-dynamic')
    @include('tenant.contracts.extension-periods-dynamic')
    @include('tenant.contracts.extension-criteria-dynamic')
    @include('tenant.contracts.accounting-periods-dynamic')
    @include('tenant.contracts.benificiary-terms-dynamic')
    @include('tenant.contracts.step10-dynamic')
    @include('tenant.contracts.step11-dynamic')
    @include('tenant.contracts.dynamic-schedules-scripts')
    <script>
        jQuery(($) => {

            // var attrs = {};
            // $('input')[0].each(elem.attributes, function(idx, attr) {
            //     attrs[attr.nodeName] = attr.nodeValue;
            // });


            // $('input').replaceWith(function() {
            //     return $("<div />", attrs).append($(this).contents());
            // });

            $('.data-wrapper').find('input,textarea,select').prop('disabled', true)
            $('.data-wrapper').find('button').not('.nav-link, .file-upload,#vertical-menu-btn').parent().remove()
        });
    </script>
@endsection
