@extends('tenant.layouts.master')

@section('title')
    Early Warning {{ $early_warning->name }}
@endsection

@section('content')
    <x-resource.breadcrumb :resource="$early_warning" :title="'Early Warning ' . $early_warning->name" />

    <div class="row">
        <div class="left-col col-md-8">
            <div class="header-wrapper d-flex justify-content-between">
                <x-resource-page.button.expand />
                <x-resource-page.status-label-alert :resource="$early_warning" />
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
                                <span class="ps-3">Early Warning Notification<br>#{{ $early_warning->id }}</span>
                            </h4>
                            <p></p>
                        </div>
                    </div>
                    <div class="row pb-3">
                        <div class="col-sm-4">
                            <label class="form-label fw-bold m-0">Contractor</label><br>
                            <x-resource.link-with-icon :name="$early_warning->contract->contractor_profile->organisation"
                                :link="t_route('profiles.show',$early_warning->contract->contractor_profile->id )"
                            />
                        </div>
                        <div class="col-sm-4">
                            <label class="form-label fw-bold m-0">Contract</label><br>
                            <x-resource.link-with-icon :name="$early_warning->contract->contract_name" :resource="$early_warning->contract" />
                        </div>
                        <div class="col-sm-4">
                            <label class="form-label fw-bold m-0">Programme</label><br>
                            <x-resource.link-with-icon :name="$early_warning->programme->name" :resource="$early_warning->programme" />
                        </div>
                    </div>
                    <div class="row pb-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold m-0">Title</label><br>
                            {{ $early_warning->title }}
                        </div>
                    </div>
                    <div class="row border-top border-bottom pt-3 pb-3 mb-3">
                        <div class="col-sm-12">
                            <label class="form-label fw-bold m-0">Description of the matter</label><br>
                            {{ $early_warning->description }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3">
                            <label class="form-label fw-bold pb-1">This matter could</label>
                            <div class="row">
                                <x-form.checkbox-customized label="increase the total of the Prices" name="effect1" :checked="$early_warning->effect1 == 1"
                                    disabled />
                            </div>
                            <div class="row">
                                <x-form.checkbox-customized label="delay Completion" name="effect2" :checked="$early_warning->effect2 == 1" disabled />
                            </div>
                            <div class="row">
                                <x-form.checkbox-customized label="delay meeting a Key Date" name="effect3" :checked="$early_warning->effect3 == 1" disabled />
                            </div>
                            <div class="row">
                                <x-form.checkbox-customized label="impair the performance of the works in use" name="effect4" :checked="$early_warning->effect4 == 1"
                                    disabled />
                            </div>
                        </div>
                    </div>

                    <div class="row pb-5">
                        <label class="form-label pt-3 border-top ">Risk score</label>

                        <table class="score-table col-md-6">
                            <tr id="consequence">
                                <td style="color: var(--bs-body-color);" colspan="6">Consequence</td>
                            </tr>
                            <tr id="likelihood">
                                <td style="color: var(--bs-body-color); transform: rotate(270deg);" rowspan="6">Likelihood</td>
                            </tr>
                            @foreach ($table['table'] as $rowKey => $tableRow)
                                <tr>
                                    @foreach ($tableRow as $cellKey => $risk_score)
                                        <td class="@if ($early_warning->risk_score == $risk_score && $early_warning->score_order == $rowKey) selected @endif"
                                            style="background-color: {{ $table['colors'][$risk_score] }}">{{ $risk_score }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </table>
                        <div class="col-md-6 p-5">
                            <div class="p-2">
                                <span class="legend-colour slight"></span><span>Slight</span>
                            </div>
                            <div class="p-2">
                                <span class="legend-colour trivial"></span><span>Trivial</span>
                            </div>
                            <div class="p-2">
                                <span class="legend-colour minor"></span><span>Minor</span>
                            </div>
                            <div class="p-2">
                                <span class="legend-colour modest"></span><span>Modest</span>
                            </div>
                            <div class="p-2">
                                <span class="legend-colour major"></span><span>Major</span>
                            </div>
                            <div class="p-2">
                                <span class="legend-colour critical"></span><span>Critical</span>
                            </div>
                        </div>
                    </div>

                    <div class="row border-top pt-3 pb-3">
                        <div class="col-sm-12">
                            <label class="form-label fw-bold m-0">Notified by</label><br>
                            {{ $early_warning->author_profile->full_name() }} on
                            {{ date(AppTenant\Models\Statical\Format::DATE_READABLE, strtotime($early_warning->date_notified)) }}
                        </div>
                    </div>

                    <div class="d-print-none">
                        <x-resource-page.buttons.bottom :resource="$early_warning" />
                        
                        <div class="float-end">
                            @if (!$early_warning->isDraft())
                                @if ($early_warning->mitigation)
                                    <a href="{{ t_route('mitigations.show', $early_warning->mitigation->id) }}"
                                        class="btn btn-secondary btn-rounded w-md waves-effect waves-light">
                                        <span class="me-1">{!! AppTenant\Models\Mitigation::$activity_icon !!}</span> Mitigation
                                    </a>
                                @else
                                    <a href="{{ t_route('mitigations.create') . '?early_warning_id=' . $early_warning->id }}"
                                        class="btn btn-primary btn-rounded w-md waves-effect waves-light">
                                        <span class="me-1">{!! AppTenant\Models\Mitigation::$activity_icon !!}</span> Mitigate
                                    </a>
                                @endif

                                @if ($early_warning->compensation_event)
                                    <a href="{{ t_route('compensation-events.show', $early_warning->compensation_event->id) }}"
                                        class="btn btn-secondary btn-rounded w-md waves-effect waves-light">
                                        <span class="me-1">{!! AppTenant\Models\CompensationEvent::$activity_icon !!}</span> Show CE
                                    </a>
                                @else
                                    <a href="{{ t_route('compensation-events.create') . '?early_warning_id=' . $early_warning->id }}"
                                        class="btn btn-primary btn-rounded w-md waves-effect waves-light">
                                        <span class="me-1">{!! AppTenant\Models\CompensationEvent::$activity_icon !!}</span> Notify CE
                                    </a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if ($early_warning->isDraft())
                <x-resource-page.actions.draft-delete-notify
                    :resource="$early_warning"
                    deleteCallback="closeEW"
                    notifyCallback="notifyEW"
                />
            @elseif ($early_warning->isNotified())
                <div class="card p-lg-3 d-print-none">
                    <div class="card-body ">
                        <div class="row">
                            <p class="text-muted mb-3 text-center"><i class="bx bx-info-circle"></i>&nbsp;
                                <small>
                                    You may close this Early Warning or escalate it to a Compensation Event
                                </small>
                            </p>
                            <div class="actions-wrapper d-flex align-items-center mx-auto" style="max-width: 600px">
                                <x-swal.confirm callback-yes="closeEW"
                                    class="mx-auto"
                                    title="Are you sure want to Close the {{ $early_warning->resourceName() }}?"
                                >
                                    <button class="btn btn-outline-dark btn-rounded w-md waves-effect waves-light">
                                        <i class="mdi mdi-alert-remove-outline font-size-14 me-1" style="vertical-align: middle;"></i>Close
                                    </button>
                                </x-swal.confirm>
                                <x-swal.confirm callback-yes="escalateEW"
                                    class="mx-auto"
                                    title="Are you sure want to Escalate the {{ $early_warning->resourceName() }}?"
                                >
                                    <button class="btn btn-outline-dark btn-rounded w-md waves-effect waves-light">
                                        <i class="mdi mdi-scale-balance font-size-14 me-1" style="vertical-align: middle;"></i>Escalate
                                    </button>
                                </x-swal.confirm>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <x-resource-page.right-tabs
            :resource="$early_warning"
            :uploads-files="$files"
            :uploads-folder="AppTenant\Models\Statical\MediaCollection::COLLECTION_EARLY_WARNINGS"
            :comments-request-url="t_route('early-warnings.add-comment', $early_warning->id)"
        />
    </div>
@endsection

@push('script')
    <script>
        function closeEW() {
            window.location.href = "{{ t_route('early-warnings.close', $early_warning->id) }}";
        }

        function escalateEW() {
            window.location.href = "{{ t_route('early-warnings.escalate', $early_warning->id) }}";
        }

        function notifyEW() {
            window.location.href = "{{ t_route('early-warnings.notify', $early_warning->id) }}";
        }
    </script>
@endpush
