@extends('tenant.layouts.master')

@section('title') @lang('Instruction') - {{ $instruction->title }} @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Instructions @endslot
        @slot('title') Instruction - {{ $instruction->title }} @endslot
    @endcomponent

    <div class="row">
        <div class="col-md-8">
            <div class="card p-5">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6 mb-5">
                            @if (settingGetLink(AppTenant\Models\Setting::KEY_ORGANISATION_LOGO))
                                <img src="{{ settingGetLink(AppTenant\Models\Setting::KEY_ORGANISATION_LOGO) }}" alt="logo" height="50" />
                            @endif
                        </div>
                        <div class="col-sm-6" style="text-align: right">
                            <h4 class="font-size-18 fw-bold">
                                <span class="ps-3">Instruction #{{ $instruction->id }}</span>
                            </h4>
                            <p>{{ date(AppTenant\Models\Statical\Format::DATE_READABLE, strtotime($instruction->created_at)) }}</p>
                        </div>
                    </div>
                    <div class="row pb-3">
                        <div class="col-sm-6">
                            <strong>Contract</strong><br>
                            {{ $instruction->contract->contract_name }}
                        </div>
                    </div>
                    <div class="row pb-3">
                        <div class="col-sm-12">
                            <strong>Title</strong><br>
                            {{ $instruction->title }}
                        </div>
                    </div>
                    <div class="row border-bottom pb-3">
                        <div class="col-sm-12">
                            <strong>Description</strong><br>
                            {{ $instruction->description }}
                        </div>
                    </div>
                    <div class="row pt-3 pb-3">
                        <div class="col-sm-6">
                            <strong>Location</strong><br>
                            {{ $instruction->location }}
                        </div>
                        <div class="col-sm-3">
                            <strong>Latitude</strong><br>
                            {{ $instruction->latitude }}
                        </div>
                        <div class="col-sm-3">
                            <strong>Longitude</strong><br>
                            {{ $instruction->longitude }}
                        </div>
                    </div>
                    <div class="row border-bottom pt-3 pb-3">
                        <div id="map" style="height: 250px; width: 100%;"></div>
                    </div>
                    <div class="row pt-3 pb-3">
                        <div class="col-sm-12">
                            <strong>Instructed by</strong><br>
                            {{ $instruction->profile->full_name() }}
                        </div>
                    </div>
                    <div class="d-print-none">
                        <div class="float-end">
                            @if ($instruction->quotation)
                                <a href="{{ t_route('quotations.show', $instruction->quotation->id) }}" class="btn btn-secondary btn-rounded w-md waves-effect waves-light me-2">Quotation</a>
                            @endif
                            <a href="javascript:window.print()" class="btn btn-secondary btn-rounded w-md waves-effect waves-light"><i class="fa fa-print me-1"></i>&nbsp;Print</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="uploads-tab" data-bs-toggle="tab" data-bs-target="#uploads" type="button" role="tab" aria-controls="uploads" aria-selected="true"><i class="mdi mdi-paperclip"></i> Uploads</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="comments-tab" data-bs-toggle="tab" data-bs-target="#comments" type="button" role="tab" aria-controls="comments" aria-selected="false"><i class="mdi mdi-chat-processing-outline"></i> Comments</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="uploads" role="tabpanel" aria-labelledby="uploads-tab">
                    <div class="card">
                        <div class="card-body p-4">
                            <x-uploads.files-list :files="$files" :folder="AppTenant\Models\Statical\MediaCollection::COLLECTION_INSTRUCTIONS" :resource-id="$instruction->id" hide-empty-list="true">
                                <div class="p-3 mb-4 text-center border-bottom d-print-none">
                                    <button type="button" class="btn btn-light btn-rounded w-md waves-effect waves-light" onclick="$('#new-files').click()">
                                        Choose
                                    </button>
                                </div>
                              <div>
                                    <ul class="list-group" data-simplebar="init" style="max-height: 350px;">
                                        <div class="simplebar-wrapper" style="margin: 0px;">
                                            <div class="simplebar-height-auto-observer-wrapper">
                                                <div class="simplebar-height-auto-observer"></div>
                                            </div>
                                            <div class="simplebar-mask">
                                                <div class="simplebar-offset" style="right: -16.8px; bottom: 0px;">
                                                    <div class="simplebar-content-wrapper" style="height: auto; overflow: hidden scroll; padding-right: 20px; padding-bottom: 0px;">
                                                        <div class="simplebar-content" style="padding: 0px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="simplebar-placeholder" style="width: 351px; height: 512px;"></div>
                                        </div>
                                        <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                            <div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div>
                                        </div>
                                        <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                                            <div class="simplebar-scrollbar" style="height: 297px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
                                        </div>
                                    </ul>
                                </div>
                            </x-uploads.files-list>
                        </div>
                    </div>
                </div>
              <div class="tab-pane fade" id="comments" role="tabpanel" aria-labelledby="comments-tab">
                    <x-comments :comments="$instruction->comments" 
                                :request-url="t_route('instructions.add-comment', $instruction->id)" 
                                :redirect-url="t_route('instructions.show', $instruction->id)" />
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_KEY') }}&callback=initMap&libraries=&v=weekly" async></script>

<script>
    let map;

    function initMap() {
        let conf = googleMapsNightConf();
        conf.center = {
            lat: {{ $instruction->latitude }},
            lng: {{ $instruction->longitude }}
        };
        const map = new google.maps.Map(document.getElementById("map"), conf);

        new google.maps.Marker({
            position: map.getCenter(),
            map: map,
        });
    }
</script>
@endsection