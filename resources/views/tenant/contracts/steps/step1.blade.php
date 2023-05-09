@extends('tenant.contracts.create-layout')
@section('step-form-section')
<div class="card p-md-5">
    <div class="card-body">
        <h4>Form of Agreement</h4>
        <p class="card-title-desc">Please complete all fields below</p>
        <form id="" action="{{t_route('contracts.store')}}" method="post" autocomplete="off">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-12 mb-3">
                        <x-form.input label="Contract title" name="contract_name" :value="old('contract_name')" />
                </div>
          </div>
          <div class="row">
                <div class="col-md-6 mb-3">
                    <x-form.select label="Contractor" name="contractor_profile_id" :options="$contractor_profiles->pluck('name', 'id')" :selected="old('contractor_profile_id')" />
                </div>
                <div class="col-md-6">
                    <x-form.select label="Subcontractor" name="subcontractor_profile_id" :options="$subcontractor_profiles" :selected="old('subcontractor_profile_id')" />
                </div>
            </div>
            <div class="row mt">
                <div class="col-12 mb-3">
                    <label for="" class="form-label">Site map</label>
                        <div id="map" class="form-control" style="height: 250px; width: 100%;"></div>
                </div>
                <div class="col-md-6 mb-3">
                    <x-form.input label="Latitude" name="lat" :value="old('lat', 50.67577881920257)" />
                </div>
                <div class="col-md-6 mb-3">
                    <x-form.input label="Longitude" name="lng" :value="old('lng', -1.2834913927579148)" />
                </div>
            </div>
            <div class="row">
                <div class="mb-3">
                    <x-form.textarea id="works_or_service" label="Works Information" name="order_ref" :value="old('order_ref')" />
                </div>
            </div>
            <div class="row">
                <div class="mb-3">
                    <x-form.textarea label="Additional documents" name="additional_documents" :value="old('additional_documents')" />
                    <input id="contract_type" name="contract_type" value="{{ old('contract_type') }}" hidden />
                </div>
            </div>
            <div style="overflow:auto;">
                <div style="float:right; margin-top: 5px;">
                    <!-- <button type="button" class="btn btn-success btn-rounded w-md waves-effect waves-light">Previous</button> -->
                    <button type="submit" class="btn btn-success btn-rounded w-md waves-effect waves-light">Save & Continue&nbsp;<i class="bx bx-send ms-1"></i></button>
                </div>

        </form>
    </div>
</div>
@endsection

@section('script')
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_KEY') }}&callback=initMap&libraries=&v=weekly" async></script>

<script>
    let map, myMarker;
    let $lat = $('#lat');
    let $lng = $('#lng');

    $lat.on('change', function() {
        updateMarkerPos();
    });
    $lng.on('change', function() {
        updateMarkerPos();
    });

    function initMap() {
        let conf = googleMapsNightConf();
        conf.center = new google.maps.LatLng(51.510357, -0.116773);
        conf.zoom = 2;

        map = new google.maps.Map(document.getElementById("map"), conf);

        myMarker = new google.maps.Marker({
            position: map.getCenter(),
            map: map,
            draggable: true
        });
        google.maps.event.addListener(myMarker, 'dragend', function(evt) {
            $lat.val(evt.latLng.lat().toFixed(10));
            $lng.val(evt.latLng.lng().toFixed(10));
        });
    }

    function updateMarkerPos() {
        let pos = new google.maps.LatLng($lat.val(), $lng.val());
        myMarker.setPosition(pos);
    }
</script>
@endsection