@extends('tenant.layouts.master')

@section('title') @lang('Direct Personnel') @endsection

@section('content')

@component('components.breadcrumb')
@slot('li_1') Direct Personnel @endslot
@slot('title') New Direct Personnel @endslot
@endcomponent

<div class="row justify-content-center">
    <div class="col-xl-9">
        <div class="card p-5">
            <div class="card-body">
                <p class="card-title-desc">Fill all information below</p>
                <form id="create-direct-personnel" method="POST" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="mb-3">
                            <x-form.input label="Name" name="name" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3">
                            <x-form.input label="Role" name="role" />
                        </div>
                    </div>
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
<script>
    jQuery(($) => {
        $('#create-direct-personnel').on('submit', function(e) {
            e.preventDefault();
            removeFormErrors(this);

            form_ajax('{{ t_route("direct-personnel.store") }}', this, {
                redirect: "{{ t_route('direct-personnel') }}"
            });
        });

    });
</script>
@endsection