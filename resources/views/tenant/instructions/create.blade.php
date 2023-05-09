@extends('tenant.layouts.master')

@section('title') @lang('New Instruction') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Instructions @endslot
        @slot('title') New Instruction @endslot
    @endcomponent

    <div class="row justify-content-center">
        <div class="col-xl-9 col-lg-8">
            <div class="card p-5">
                <div class="card-body">
                    <p class="card-title-desc">Please complete all fields below</p>
                    <form id="create-instruction" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden" name="quotation_id" value="{{ request()->get('quotation_id') }}" />
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <x-form.select label="Contract" name="contract" 
                                    :options="$contracts->pluck('contract_name', 'id')" 
                                    :selected="$selected_contract_id ?? ''"
                                />
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <x-form.input label="Title" name="title" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <label class="form-label">Map</label>
                                <div class="col-sm-12 mb-3">
                                    <div id="map" class="form-control" style="height: 250px; width: 100%;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <x-form.input label="Latitude" name="latitude" :value="App\Models\Statical\Constant::DEFAULTS_MAP_MARKER_LAT" />
                            </div>
                            <div class="col-sm-6 mb-3">
                                <x-form.input label="Longitude" name="longitude" :value="App\Models\Statical\Constant::DEFAULTS_MAP_MARKER_LNG" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <x-form.textarea label="Description of the task" name="description" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <x-form.datetime-local label="Start" name="start" />
                            </div>
                            <div class="col-sm-6 mb-3">
                                <x-form.datetime-local label="Finish" name="finish" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <x-form.input label="Duration" name="duration" />
                            </div>
                            <div class="col-sm-6 mb-3">
                                <x-form.select label="Pattern" name="pattern" :options="$patterns" />
                            </div>
                        </div>
                        <hr>
                        <div class="row float-end row mt-5 pb-3">
                            <button type="submit" class="btn btn-success btn-rounded w-md waves-effect waves-light">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_KEY') }}&callback=initMap&libraries=&v=weekly" async></script>

    <script>
        jQuery(($) => {
            $('#create-instruction').on('submit', function(e) {
                e.preventDefault();
                removeFormErrors(this);

                form_ajax('{{ t_route("instructions.store") }}', this, {redirect: "{{ t_route('instructions') }}"});
            });
        });
    </script>

    <script>
        let map;

        function initMap() {
            let conf = googleMapsNightConf();
            conf.center = new google.maps.LatLng({{ App\Models\Statical\Constant::DEFAULTS_MAP_MARKER_LAT }}, {{ App\Models\Statical\Constant::DEFAULTS_MAP_MARKER_LNG }});
            conf.zoom = 10;

            const map = new google.maps.Map(document.getElementById("map"), conf);

            myMarker = new google.maps.Marker({
                position: map.getCenter(),
                map: map,
                draggable: true
            });
            google.maps.event.addListener(myMarker, 'dragend', function(evt) {
                document.getElementById('latitude').value = evt.latLng.lat().toFixed(10);
                document.getElementById('longitude').value = evt.latLng.lng().toFixed(10);
            });
        }
    </script>
@endsection