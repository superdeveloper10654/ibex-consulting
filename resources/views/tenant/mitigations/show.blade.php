@extends('tenant.layouts.master')

@section('title') Mitigation {{ $mitigation->name }} @endsection

@section('content')
    <x-resource.breadcrumb :resource="$mitigation" :title="'Mitigation ' . $mitigation->name" />

    <div class="row">
         <div class="left-col col-md-8">
            <div class="header-wrapper d-flex justify-content-between">
                <x-resource-page.button.expand />
                <x-resource-page.status-label-alert :resource="$mitigation" />
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
                                <span class="ps-3">Mitigation #{{ $mitigation->id }}</span>
                            </h4>
                            <p></p>
                        </div>
                    </div>
                    <div class="row pb-3">
                        <div class="col-sm-6">
                            <label class="form-label fw-bold m-0">Name</label><br>
                            {{ $mitigation->name  }}
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label fw-bold m-0">Contract</label><br>
                            <x-resource.link-with-icon :name="$mitigation->early_warning->contract->contract_name" :resource="$mitigation->early_warning->contract" />
                        </div>
                    </div>
                    <div class="row pb-3">
                        <div class="col-sm-6">
                            <label class="form-label fw-bold m-0">Early Warning</label><br>
                            <x-resource.link-with-icon :name="$mitigation->early_warning->title" :resource="$mitigation->early_warning" />
                        </div>
                    </div>
                    <div class="row border-top pt-3 pb-3">
                        <div class="col-sm-12">
                            <label class="form-label fw-bold m-0">Description</label><br>
                            {{ $mitigation->description }}
                        </div>
                    </div>               
                  
                    <div class="row border-top pt-3 pb-3">
                        <div class="col-sm-12">
                            <label class="form-label fw-bold m-0">Created by</label><br>
                            {{ $mitigation->author->full_name() }} on {{ date(AppTenant\Models\Statical\Format::DATE_READABLE, strtotime($mitigation->created_at)) }}
                        </div>
                    </div>

                    <div class="d-print-none">
                        <x-resource-page.buttons.bottom :resource="$mitigation" />
                    </div>
                </div>
            </div>
           
           
            @if ($mitigation->isDraft())
                <x-resource-page.actions.draft-delete-notify
                    :resource="$mitigation"
                    deleteCallback="deleteMitigation"
                    notifyCallback="notifyMitigation"
                />
            @elseif ($mitigation->isNotified() && empty($mitigation->early_warning->compensation_event))
                <div class="card p-lg-3 d-print-none">
                    <div class="card-body">
                        <div class="row">
                            <p class="text-muted mb-3 text-center">
                                <i class="bx bx-info-circle"></i>&nbsp;
                                <small>You may close this Mitigation or Notify a Compensation Event</small>
                            </p>
                            <div class="actions-wrapper d-flex align-items-center mx-auto" style="max-width: 600px">
                                <x-swal.confirm callback-yes="closeMitigation"
                                    class="mx-auto"
                                    title="Are you sure want to Close the {{ $mitigation->resourceName() }}?"
                                >
                                    <button class="btn btn-outline-dark btn-rounded w-md waves-effect waves-light">
                                        <i class="mdi mdi-alert-remove-outline font-size-14 me-1" style="vertical-align: middle;"></i>Close
                                    </button>
                                </x-swal.confirm>
                                <x-swal.confirm callback-yes="notifyCE"
                                    class="mx-auto"
                                    title="Are you sure want to Notify the Compensation Event?"
                                >
                                    <button class="btn btn-outline-dark btn-rounded w-md waves-effect waves-light">
                                        <i class="mdi mdi-scale-balance font-size-14 me-1" style="vertical-align: middle;"></i>Notify CE
                                    </button>
                                </x-swal.confirm>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <x-resource-page.right-tabs
            :resource="$mitigation"
            :uploads-files="$files"
            :uploads-folder="AppTenant\Models\Statical\MediaCollection::COLLECTION_MITIGATIONS"
            :comments-request-url="t_route('early-warnings.add-comment', $mitigation->id)"
        />
    </div>
@endsection

@push('script')
    <script>
        @if ($mitigation->isDraft())
            function deleteMitigation() {
                window.location.href = "{{ t_route('mitigations.delete-draft', $mitigation->id) }}";
            }

            function notifyMitigation() {
                window.location.href = "{{ t_route('mitigations.notify', $mitigation->id) }}";
            }
        @endif

        @empty($mitigation->early_warning->compensation_event)
            function closeMitigation() {
                window.location.href = "{{ t_route('mitigations.close', $mitigation->id) }}";
            }

            function notifyCE() {
                window.location.href = "{{ t_route('compensation-events.create') . '?mitigation_id=' . $mitigation->id }}";
            }
        @endempty
    </script>
@endpush