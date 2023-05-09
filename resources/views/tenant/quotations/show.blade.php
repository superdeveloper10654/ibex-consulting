@extends('tenant.layouts.master')

@section('title') Quotation {{ $quotation->title }} @endsection

@section('content')
    <x-resource.breadcrumb :resource="$quotation" :title="'Quotation ' . $quotation->title" />

    <div class="row">
        <div class="left-col col-md-8">
            <div class="header-wrapper d-flex justify-content-between">
                <x-resource-page.button.expand />
                <x-resource-page.status-label-alert :resource="$quotation" />
            </div>
            <div class="card">
                <div class="card-body p-lg-5">
                    <div class="row">
                        <div class="col-sm-6 mb-5">
                            @if (settingGetLink(AppTenant\Models\Setting::KEY_ORGANISATION_LOGO))
                                <img src="{{ settingGetLink(AppTenant\Models\Setting::KEY_ORGANISATION_LOGO) }}" alt="logo" height="50" />
                            @endif
                        </div>
                        <div class="col-sm-6" style="text-align: right">
                            <h4 class="font-size-18 fw-bold">
                                <span class="ps-3">Compensation Event Quotation<br>#{{ $quotation->id }}</span>
                            </h4>
                            <p></p>
                        </div>
                    </div>
                    <div class="row pb-3">
                        <div class="col-sm-4">
                            <label class="form-label fw-bold m-0">Contractor</label><br>
                            <x-resource.link-with-icon :name="$quotation->contract->contractor_profile->organisation"
                                :link="t_route('profiles.show', $quotation->contract->contractor_profile->id)"
                            />
                        </div>
                        <div class="col-sm-4">
                            <label class="form-label fw-bold m-0">Contract</label><br>
                            <x-resource.link-with-icon :name="$quotation->contract->contract_name" :resource="$quotation->contract" />
                        </div>
                        <div class="col-sm-4">
                            <label class="form-label fw-bold m-0">Programme</label><br>
                            <x-resource.link-with-icon :name="$quotation->programme->name" :resource="$quotation->programme" />
                        </div>
                    </div>
                    <div class="row pb-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold m-0">Title</label><br>
                            {{ $quotation->title }}
                        </div>
                    </div>
                    <div class="row border-top border-bottom pt-3 pb-3 mb-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold m-0">Description</label><br>
                            {{ $quotation->description }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">Change to the total of the Prices</label><br>
                            {{ ($quotation->price_effect > 0 ? ' + £' : '') . $quotation->price_effect }} proposed
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">Changes to Completion Date</label><br>
                            {{ $quotation->contract_completion_date_effect }} days
                            @if (!empty($contract_completion_date))
                                {{ $contract_completion_date->format(AppTenant\Models\Statical\Format::DATE_READABLE) }}
                            @endif
                        </div>
                        @if (!empty($contract_key_date_1))
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold mb-1">Key Date 1</label><br>
                                {{ $quotation->contract_key_date_1_effect }}
                                {{ $contract_key_date_1 ? $contract_key_date_1->format(AppTenant\Models\Statical\Format::DATE_READABLE) : '' }}
                            </div>
                        @endif
                        @if (!empty($contract_key_date_2))    
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold mb-1">Key Date 2</label><br>
                                {{ $quotation->contract_key_date_2_effect }}
                                {{ $contract_key_date_2 ? $contract_key_date_2->format(AppTenant\Models\Statical\Format::DATE_READABLE) : '' }}
                            </div>
                        @endif
                        @if (!empty($contract_key_date_3))
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold mb-1">Key Date 3</label><br>
                                {{ $quotation->contract_key_date_3_effect }}
                                {{ $contract_key_date_3 ? $contract_key_date_3->format(AppTenant\Models\Statical\Format::DATE_READABLE) : '' }}
                            </div>
                        @endif
                    </div>

                    <div class="row py-3 border-top">
                        <div class="col-md-12">
                            <label class="form-label fw-bold m-0">Created by</label><br>
                            {{ $quotation->author->full_name() }} on
                            {{ date(AppTenant\Models\Statical\Format::DATE_READABLE, strtotime($quotation->created_at)) }}
                        </div>
                    </div>

                    <div class="d-print-none">
                        <x-resource-page.buttons.bottom :resource="$quotation" />
                    </div>
                </div>
            </div>

            @if ($quotation->isDraft())
                <x-resource-page.actions.draft-delete-notify
                    :resource="$quotation"
                    deleteCallback="deleteQuotation"
                    notifyCallback="notifyQuotation"
                />
            @elseif ($quotation->isNotified() && t_profile()->can('quotations.accept-reject'))
                <x-resource-page.actions.accept-reject
                    :resource="$quotation"
                    acceptCallback="acceptQuotation"
                    rejectCallback="rejectQuotation"
                />
            @endif
        </div>
        <x-resource-page.right-tabs 
            :resource="$quotation"
            :uploads-files="$files"
            :uploads-folder="AppTenant\Models\Statical\MediaCollection::COLLECTION_QUOTATIONS"
            :comments-request-url="t_route('quotations.add-comment', $quotation->id)"
        />
    </div>
@endsection

@push('script')
    <script>
        function deleteQuotation() {
            window.location.href = "{{ t_route('quotations.delete-draft', $quotation->id) }}";
        }

        function notifyQuotation() {
            window.location.href = "{{ t_route('quotations.notify', $quotation->id) }}";
        }

        @if ($quotation->isNotified() && t_profile()->can('quotations.accept-reject'))
            function acceptQuotation() {
                window.location.href = "{{ t_route('quotations.accept', $quotation->id) }}";
            }

            function rejectQuotation() {
                Swal.fire({
                    title: "Please create Application or Instruction to Reject the Quotation:",
                    html: (
                        `<div class="mt-3">` +
                        `<a href="{{ t_route('assessments.create') . '?quotation_id=' . $quotation->id }}" class="btn btn-primary me-5">Assessment</a>` +
                        `<a href="{{ t_route('instructions.create') . '?quotation_id=' . $quotation->id }}" class="btn btn-primary">Instruction</a>` +
                        `</div>`
                    ),
                    showCancelButton: true,
                    showConfirmButton: false,

                });
            }
        @endif
    </script>
@endpush
