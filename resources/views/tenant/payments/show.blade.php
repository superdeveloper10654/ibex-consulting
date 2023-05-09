@extends('tenant.layouts.master')

@section('title') Payment #{{ $payment->id }} @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Payments @endslot
        @slot('title') Payment #{{ $payment->id }} @endslot
    @endcomponent

<div class="row">
    <div class="col-md-8">
        <button type="button" class="d-print-none btn expand-toggle waves-effect mb-2">Expand<span class="expand_icon"> <i class="bx bx-expand"></i></span></button>
        <div class="card">
            <div class="card-body p-lg-5">
                <div class="row">
                    <div class="col-sm-6 mb-5">
                        @if ($payment->contract->contractor_profile)
                            <img class="rounded-circle" src="{{ asset($payment->contract->contractor_profile->avatar_url())}}" alt="logo" height="75" width="75" />
                        @else
                            <img class="rounded-circle" src="{{ asset('assets/images/companies/img-5.png')}}" alt="logo" height="75" width="75" />
                        @endif
                    </div>
                    <div class="col-sm-6 mb-5 d-flex justify-content-center align-items-center">
                        {!! $payment->status()->badge !!}
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Contractor</strong><br>
                            {{ $payment->contract->contractor_profile->organisation }}
                        </div>
                        <div class="col-sm-4">
                            <strong> Contract</strong><br>
                            {{ $payment->contract->contract_name}}
                        </div>
                        <div class="col-sm-4">
                            <strong>Assessment</strong><br>
                            {{ $payment->assessment->title }}
                        </div>
                    </div>
                </div>

                <div class="row my-4">
                    <div class="col-md-12 table-responsive pt-3">
                        <table class="table align-middle table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Item</th>
                                    <th scope="col">Qty</th>
                                    <th scope="col">Rate £</th>
                                    <th scope="col">Sum £</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payment->items as $item)
                                <tr>
                                    <td>{{ $item->rate_card->item_desc }}</td>
                                    <td>{{number_format($item->qty, 2)}}</td>
                                    <td>{{number_format($item->rate, 2)}}</td>
                                    <td>{{number_format($item->sum, 2)}}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td style="text-align: right; border: none" colspan="3">Net £</td>
                                    <td style="border: none">{{number_format($payment->cuml_net, 2)}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row border-bottom pb-3">
                    <div class="col-sm-12">
                        <strong>Notes / Comments</strong><br>
                        {{ $payment->description }}
                    </div>
                </div>
                <div class="d-print-none mt-3">
                    <div class="d-flex justify-content-end">
                        <a href="javascript:window.print()" class="btn btn-secondary btn-rounded w-md waves-effect waves-light"><i class="fa fa-print me-1"></i>&nbsp;Print</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 d-print-none">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="uploads-tab" data-bs-toggle="tab" data-bs-target="#uploads" type="button" role="tab" aria-controls="uploads" aria-selected="true"><i class="mdi mdi-paperclip"></i> Uploads</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="uploads" role="tabpanel" aria-labelledby="uploads-tab">
                <div class="card">
                    <div class="card-body p-4">
                        <x-uploads.files-list :files="$files" :folder="AppTenant\Models\Statical\MediaCollection::COLLECTION_PAYMENTS" :resource-id="$payment->id" hide-empty-list="true">
                            <div>
                                <ul class="list-group d-print-none" data-simplebar="init" style="max-height: 350px;">
                                    <div class="simplebar-wrapper" style="margin: 0px;">
                                        <div class="simplebar-height-auto-observer-wrapper">
                                            <div class="simplebar-height-auto-observer"></div>
                                        </div>
                                        <div class="simplebar-mask">
                                            <div class="simplebar-offset" style="right: -16.8px; bottom: 0px;">
                                                <div class="simplebar-content-wrapper" style="height: auto; overflow: hidden scroll; padding-right: 20px; padding-bottom: 0px;">
                                                    <div class="simplebar-content" style="padding: 0px;">
                                                        <div class="mb-3">
                                                            <p class="text-muted text-center"><i class="bx bx-info-circle"></i>&nbsp;<small>Upload any related files here</small></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="simplebar-placeholder" style="width: 351px; height: 512px;"></div>
                                    </div>
                                    <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                        <div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div>
                                    </div>
                                    <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                                        <div class="simplebar-scrollbar" style="height: 297px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
                                    </div>
                                </ul>
                            </div>
                            <div>
                                <ul class="list-group" data-simplebar="init" style="max-height: 350px;">
                                    <div class="simplebar-wrapper" style="margin: 0px;">
                                        <div class="simplebar-height-auto-observer-wrapper">
                                            <div class="simplebar-height-auto-observer"></div>
                                        </div>
                                        <div class="simplebar-mask">
                                            <div class="simplebar-offset" style="right: -16.8px; bottom: 0px;">
                                                <div class="simplebar-content-wrapper" style="height: auto; overflow: hidden scroll; padding-right: 20px; padding-bottom: 0px;">
                                                    <div class="simplebar-content" style="padding: 0px;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="simplebar-placeholder" style="width: 351px; height: 512px;"></div>
                                    </div>
                                    <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                        <div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div>
                                    </div>
                                    <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                                        <div class="simplebar-scrollbar" style="height: 297px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
                                    </div>
                                </ul>
                            </div>
                            <div class="mb-3 text-center d-print-none">
                                <button type="button" class="btn btn-secondary btn-rounded w-md waves-effect waves-light" onclick="$('#new-files').click()">
                                    <i class="mdi mdi-upload me-1"></i>&nbsp;Upload
                                </button>
                            </div>
                        </x-uploads.files-list>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection