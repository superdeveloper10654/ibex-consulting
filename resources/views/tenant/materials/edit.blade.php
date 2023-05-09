@extends('tenant.layouts.master')

@section('title') @lang('Material') @endsection

@section('content')

@component('components.breadcrumb')
@slot('li_1') Material @endslot
@slot('title') Edit Material @endslot
@endcomponent

<div class="row justify-content-center">
    <div class="col-xl-9">
        <div class="card p-5">
            <div class="card-body">
                <p class="card-title-desc">Fill all information below</p>
                <form id="update-material" method="PUT" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="mb-3">
                            <x-form.input label="Name" name="name" value="{{$material->name}}" />
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
        $('#update-material').on('submit', function(e) {
            e.preventDefault();
            removeFormErrors(this);

            form_ajax('{{ t_route("materials.update",$material->id) }}', this, {
                redirect: "{{ t_route('materials') }}"
            });

        });

    });
</script>
@endsection