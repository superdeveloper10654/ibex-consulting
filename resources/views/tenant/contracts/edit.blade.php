@extends('tenant.contracts.create-layout')
@section('step-form-section')
<div class="card p-md-5">
    <div class="card-body">
        <h4>Form of Agreement</h4>
        <p class="card-title-desc">Please complete all fields below</p>
        {!! Form::open(array('route' => ['contracts.update', $contract->id], 'method' => 'PUT', 'role' => 'form', 'class' => 'needs-validation')) !!}
        {!! csrf_field() !!}
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label">Contract title</label>
                    <input class="form-control" type="text" name="contract_name" value="{{$contract->contract_name}}" required>
                    @error('contract_name')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <x-form.select label="Contractor" name="contractor_profile_id" :options="$contractor_profiles->pluck('organisation', 'id')" :selected="old('contractor_profile_id', $contract->profile_id)" disabled />
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <x-form.select label="Subcontractor" name="subcontractor_profile_id" :options="$subcontractor_profiles" :selected="old('subcontractor_profile_id', $contract->subcontractor_profile_id)" disabled />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mb-3">
                <label class="form-label">Location</label>
                <div class="col-sm-12 form-control">
                    <div id="map" style="height: 250px; width: 100%;"></div>
                </div>
            </div>
            <div class="col-sm-6 mb-3">
                <x-form.input label="Latitude" name="lat" value="{{$contract->latitude}}" />
            </div>
            <div class="col-sm-6 mb-3">
                <x-form.input label="Longitude" name="lng" value="{{$contract->longitude}}" />
            </div>
        </div>
        <div class="row">
            <div class="mb-3">
                <label class="form-label works_or_service works_or_service_label">{{str_ends_with($contract->contract_type,'TSC') ? 'Service' : 'Works'}} Information</label>
                <textarea name="order_ref" id="works_or_service" class="form-control" rows="3" placeholder="Provide a brief one-paragraph outline" required>{{$contract->order_ref}}</textarea>
            </div>
            @error('order_ref')
            <p class="text-danger text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>
        <div class="row">
            <div class="mb-3">
                <label class="form-label">Additional documents</label>
                <textarea name="additional_documents" class="form-control" rows="3" required>{{$contract->kml_filepath}}</textarea>
                <input id="contract_type" name="contract_type" hidden />
            </div>
            @error('additional_documents')
            <p class="text-danger text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>
            <div class="border-top mt-5 pt-4">
                <button type="submit" class="btn btn-success btn-rounded w-md waves-effect waves-light float-end">Continue<i class="mdi mdi-chevron-right ms-1"></i></button>
            <p class="text-muted mb-3 text-center"><i class="bx bx-info-circle ms-1"></i>
                                <small>
                                    Your changes are automagically saved
                                </small>
                            </p>
      </div>

            {!! Form::close() !!}

    </div>


    @endsection
    @section('script')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_KEY') }}&callback=initMap&libraries=&v=weekly" async></script>

    <script>
        let map;
        let lat = <?php echo $contract->latitude; ?>;
        let lng = <?php echo $contract->longitude; ?>;

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
            google.maps.event.addListener(myMarker, 'dragend', function(evt) {
                document.getElementById('lat').value = evt.latLng.lat().toFixed(10);
                document.getElementById('lng').value = evt.latLng.lng().toFixed(10);
            });
        }
    </script>
    @endsection