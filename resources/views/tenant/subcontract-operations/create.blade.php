@extends('tenant.layouts.master')

@section('title') @lang('Subcontract / Client Operation') @endsection

@section('content')

@component('components.breadcrumb')
@slot('li_1') Subcontract / Client Operation @endslot
@slot('title') New Subcontract / Client Operation @endslot
@endcomponent

<div class="row justify-content-center">
    <div class="col-xl-9">
        <div class="card p-5">
            <div class="card-body">
                <p class="card-title-desc">Fill all information below</p>
                <form id="create-operation" method="POST" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="mb-3">
                            <x-form.input label="Operation Name" name="operation_name" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3">
                            <x-form.input label="Subbie Name" name="subbie_name" />
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
        $('#create-operation').on('submit', function(e) {
            e.preventDefault();
            removeFormErrors(this);

            form_ajax('{{ t_route("subcontract_or_client-operations.store") }}', this, {
                redirect: "{{ t_route('subcontract_or_client-operations') }}"
            });
        });

    });
</script>
@endsection