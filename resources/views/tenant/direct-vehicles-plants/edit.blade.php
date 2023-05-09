@extends('tenant.layouts.master')

@section('title') @lang('Direct Vehicles & Plants') @endsection

@section('content')

@component('components.breadcrumb')
@slot('li_1') Direct Vehicles & Plants @endslot
@slot('title') Edit Direct Vehicles & Plants @endslot
@endcomponent

<div class="row justify-content-center">
    <div class="col-xl-9">
        <div class="card p-5">
            <div class="card-body">
                <p class="card-title-desc">Fill all information below</p>
                <form id="update-direct-vehicles-plants" method="PUT" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="mb-3">
                            <x-form.input label="vehicle / plant name" name="vehicle_or_plant_name" value="{{$directVehiclePlants->vehicle_or_plant_name}}" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3">
                            <x-form.input label="reference no" name="ref_no" value="{{$directVehiclePlants->ref_no}}" />
                        </div>
                    </div>
                    <div class="row float-end row mt-5 pb-3">
                        <button type="submit" class="btn btn-success btn-rounded w-md waves-effect waves-light">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    jQuery(($) => {
        $('#update-direct-vehicles-plants').on('submit', function(e) {
            e.preventDefault();
            removeFormErrors(this);

            form_ajax('{{ t_route("direct-vehicles-plants.update",$directVehiclePlants->id) }}', this, {
                redirect: "{{ t_route('direct-vehicles-plants') }}"
            });

        });

    });
</script>
@endsection