@extends('tenant.layouts.master')

@section('title') @lang('Edit Payment') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Payments @endslot
        @slot('title') Edit Payment {{$payment->id}} @endslot
    @endcomponent

    <div class="row justify-content-center">
        <div class="col-xl-9">
            <div class="card p-5">
                <div class="card-body">
                    <p class="card-title-desc">Fill all information below</p>
                    <form id="update-payment" method="POST" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <x-form.select label="Contract" name="contract" :options="$contracts->pluck('contract_name', 'id')" :selected="$payment->contract_id" disabled />
                            </div>
                            <div class="col-sm-6 mb-3">
                                <x-form.select label="Assessment" name="assessment" :options="$assessments->pluck('title', 'id')" :selected="$payment->assessment_id" disabled />
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
                                    @foreach ($payment->items as $i => $item)
                                        <tr>
                                            <td class="col-md-6">
                                                <select class="form-select item_select" name="items[{{ $i }}][rate_card_id]">
                                                    <option value=''>Select</option>
                                                    @foreach ($rate_cards as $index => $rate_card)
                                                    <option value="{{ $rate_card->id }}" data-index="{{ $index }}" {{ $rate_card->id == $item->rate_card_id ? 'selected' : '' }}>{{ $rate_card->item_desc }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="text-danger" data-error="measure"></div>
                                            </td>
                                            <td class="col-md-2">
                                                <x-form.input name="items[{{ $i }}][qty]" type="number" min="1" :value="$item->qty" />
                                            </td>
                                            <td class="col-md-2">
                                                <x-form.input name="items[{{ $i }}][rate]" type="number" :value="$item->rate" />
                                            </td>
                                            <td class="col-md-2">
                                                <x-form.input name="items[{{ $i }}][sum]" type="number" min="1" :value="number_format($item->sum, 2)" />
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row pb-3">
                            <div class="col-md-10">
                                <button type="button" class="btn btn-sm btn-secondary waves-effect waves-light add-row"><i class="mdi mdi-plus me-1"></i>Add row</button>
                            </div>
                            <div class="col-md-2">
                                <x-form.input name="payment_sub_total" type="number" :value="$payment->cuml_net" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <x-form.textarea label="Description" name="description" :value="$payment->description" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <x-form.datetime-local label="Start" name="start" :value="$payment->from_date" />
                            </div>
                            <div class="col-sm-6 mb-3">
                                <x-form.datetime-local label="Finish" name="finish" :value="$payment->due_date" />
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
    @include('tenant.payments.create-edit-scripts')
@endsection

@section('script')
    <script>
        jQuery(($) => {
            $('#update-payment').on('submit', function(e) {
                e.preventDefault();
                removeFormErrors(this);

                form_ajax('{{ t_route("payments.update", $payment->id) }}', this, {redirect: "{{ t_route('payments') }}"});
            });
        });
    </script>
@endsection