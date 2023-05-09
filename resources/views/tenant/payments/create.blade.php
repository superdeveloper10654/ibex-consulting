@extends('tenant.layouts.master')

@section('title') @lang('New Payment') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Payments @endslot
        @slot('title') New Payment @endslot
    @endcomponent

    <div class="row justify-content-center">
        <div class="col-xl-9">
            <div class="card p-5">
                <div class="card-body">
                    <p class="card-title-desc">Fill all information below</p>
                    <form id="create-payment" method="POST" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <x-form.select label="Contract" name="contract" :options="$contracts->pluck('contract_name', 'id')" />
                            </div>
                            <div class="col-sm-6 mb-3">
                                <x-form.select label="Assessment" name="assessment" :options="$assessments->pluck('name', 'id')" />
                            </div>
                        </div>

                        <div class="row">
                            <table class="table table-hover table-nowrap" id="payment_table">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Qty</th>
                                        <th>Rate £</th>
                                        <th>Sum £</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="col-md-6">
                                            <x-form.select name="items[0][rate_card_id]" :options="$rate_cards->pluck('item_desc', 'id')" />
                                        </td>
                                        <td class="col-md-2">
                                            <x-form.input name="items[0][qty]" type="number" min="1" value="0" />
                                        </td>
                                        <td class="col-md-2">
                                            <x-form.input name="items[0][rate]" type="number" value="0" />
                                        </td>
                                        <td class="col-md-2">
                                            <x-form.input name="items[0][sum]" type="number" min="1" value="0" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row pb-3">
                            <div class="col-md-10">
                                <button type="button" class="btn btn-sm btn-secondary waves-effect waves-light add-row"><i class="mdi mdi-plus me-1"></i>Add row</button>
                            </div>
                            <div class="col-md-2">
                                <x-form.input name="payment_sub_total" type="number" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <x-form.textarea label="Description" name="description" />
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
                        <div class="row float-end row mt-5 pb-3">
                            <button type="submit" class="btn btn-success btn-rounded w-md waves-effect waves-light">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('tenant.applications.create-edit-scripts')
@endsection

@push('script')
    <script>
        jQuery(($) => {
            $('#create-payment').on('submit', function(e) {
                e.preventDefault();
                removeFormErrors(this);

                form_ajax('{{ t_route("payments.store") }}', this, {redirect: "{{ t_route('payments') }}"});
            });
        });
    </script>
@endpush