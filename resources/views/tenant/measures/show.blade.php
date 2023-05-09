@extends('tenant.layouts.master')

@section('title') @lang('Measure') - {{ $measure->site_name }} @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Measures @endslot
        @slot('title') Measure - {{ $measure->site_name }} @endslot
    @endcomponent

    <div class="row">
        <div class="col-md-8">
          <button type="button" class="btn expand-toggle waves-effect mb-2">Expand<span class="expand_icon"> <i class="bx bx-expand"></i></span></button>
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
                                <span class="ps-3">Measure #{{ $measure->id }}</span>
                            </h4>
                            <p>{{ date(AppTenant\Models\Statical\Format::DATE_READABLE, strtotime($measure->created_at)) }}</p>
                        </div>
                    </div>
                    <div class="row pb-3">
                        <div class="col-sm-4">
                            <strong>Contractor</strong><br>
                            {{ $measure->contract->contractor_profile->organisation }}
                        </div>
                        <div class=" col-sm-4">
                            <strong>Contract name</strong><br>
                            <p>{{ $measure->contract->contract_name }}</p>
                        </div>
                        <div class=" col-sm-4">
                            <strong>Site name</strong><br>
                            <p>{{ $measure->site_name }}</p>
                        </div>
                    </div>

                    <div id="map" class="form-control mb-4" style="height: 400px; width: 100%;"></div>

                    @if (!empty($measure->quantified_items))
                        <div class="col-sm-12">
                            <strong>Quantities</strong><br><br>
                        </div>
                        <div class="col-md-12 pb-4">
                            <table class="table align-middle table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">Item</th>
                                        <th scope="col">Latitude</th>
                                        <th scope="col">Longitude</th>
                                        <th scope="col">Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($measure->quantified_items as $item)
                                    <tr>
                                        <td>
                                            {!! $item->rate_card->pin_html !!}
                                            {{ $item->item }}
                                        </td>
                                        <td>
                                            {{ number_format($item->lat, 8) }}
                                        </td>
                                        <td>
                                            {{ number_format($item->lng, 8) }}
                                        </td>
                                        <td>
                                            {{ number_format($item->qty, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    @if (!empty($measure->linear_items))
                        <div class="col-sm-12">
                            <strong>Dimensions</strong><br><br>
                        </div>
                        <div class="col-md-12">
                            <table class="table align-middle table-hover linear-items">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">Item</th>
                                        <th scope="col">Length</th>
                                        <th scope="col">Width</th>
                                        <th scope="col">Depth</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($measure->linear_items as $i => $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex justify-content-start align-items-center">
                                                {!! $item->rate_card->pin_html !!}

                                                <span class="ms-2">{{ $item->description }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            {{ number_format($item->length, 2) }}m
                                        </td>
                                        <td>
                                            {{ number_format($item->width, 2) }}m
                                        </td>
                                        <td>
                                            {{ number_format($item->depth, 2) }}m
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    <div class="row pt-3">
                        <div class="col-sm-12">
                            <strong>Measure by</strong><br>
                            {{ $measure->profile->full_name() }}
                        </div>
                    </div>


                    <div class="row d-print-none">
                        <div class="d-flex justify-content-end">
                            <a href="javascript:window.print()" class="btn btn-secondary btn-rounded w-md waves-effect waves-light"><i class="fa fa-print me-1"></i>&nbsp;Print</a>

                            @if ($measure->isDraft())
                                <form id="update-status" class="ms-2" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="status" value="{{ \AppTenant\Models\Status\MeasureStatus::SUBMITTED_ID }}">
                                    <button type="submit" class="btn btn-success btn-rounded w-md waves-effect waves-light">Submit&nbsp;<i class="bx bx-send ms-1"></i></button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 d-print-none">
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
                            <x-uploads.files-list :files="$files" :folder="AppTenant\Models\Statical\MediaCollection::COLLECTION_MEASURES" :resource-id="$measure->id" hide-empty-list="true">
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
                    <x-comments :comments="$measure->comments"
                                :request-url="t_route('measures.add-comment', $measure->id)"
                                :redirect-url="t_route('measures.show', $measure->id)" />
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_KEY') }}&callback=initMap&libraries=&v=weekly" async></script>

<script>
    let map;
    let quantified_items = @json($quantified_items_json);
    let linear_items = @json($linear_items_json);

    function initMap() {
        let conf = googleMapsDefaultConf();
        conf.center = {
            lat: {{ $measure->contract->latitude }},
            lng: {{ $measure->contract->longitude }}
        };
        map = new google.maps.Map(document.getElementById("map"), conf);

        if (quantified_items.length) {
            quantified_items.map((item) => {
                new google.maps.Marker({
                    position: {
                        lat: item.lat,
                        lng: item.lng
                    },
                    map: map,
                    icon: {
                        url: item.rate_card.pin.icon_src,
                        scaledSize: new google.maps.Size(18, 18)
                    },
                });
            });
        }

        if (linear_items.length) {
            linear_items.map((item) => {
                initLinearItem(item);
            });
        }
    }

    function initLinearItem(item) {
        debugger;
        if (item.rate_card.unit == 'line') {
            let icons = getPolylineIcons(item.rate_card.pin.line_type, item.rate_card.pin.line_color);

            if (item.rate_card.pin.line_type == 'solid') {
                new google.maps.Polyline({
                    strokeColor: item.rate_card.pin.line_color,
                    strokeOpacity: 1.0,
                    strokeWeight: 2,
                    path: item.coords,
                    map: map
                });

            } else if (['dotted', 'dashed'].includes(item.rate_card.pin.line_type)) {
                new google.maps.Polyline({
                    strokeOpacity: 0,
                    icons: icons,
                    path: item.coords,
                    map: map
                });
            }

        } else if (item.rate_card.unit == 'polygon' || item.rate_card.unit == 'm2') {
            new google.maps.Polygon({
                paths: item.coords,
                strokeWeight: 1,
                fillColor: item.rate_card.pin.fill_color,
                fillOpacity: 0.35,
                map: map,
            });
        }
    }

    jQuery(($) => {
        $('#update-status').on('submit', function(e) {
            e.preventDefault();

            form_ajax('{{ t_route("measures.update-status", $measure->id) }}', this);
        });
    });
</script>
@endpush
