@extends('tenant.layouts.master')

@section('title') Compensation Event {{ $event->title }} @endsection

@section('content')
    <x-resource.breadcrumb :resource="$event" :title="'Compensation Event ' . $event->title" />

    <div class="row">
        <div class="left-col col-md-8">
            <div class="header-wrapper d-flex justify-content-between">
                <x-resource-page.button.expand />
                <x-resource-page.status-label-alert :resource="$event" />
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
                                <span class="ps-3">Compensation Event<br>#{{ $event->id }}</span>
                            </h4>
                            <p></p>
                        </div>
                    </div>
                    <div class="row py-2 border-bottom">
                        <div class="col-sm-6">
                            <label class="form-label fw-bold m-0">Contract</label><br>
                            <x-resource.link-with-icon :name="$event->contract->contract_name" :resource="$event->contract" />
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label fw-bold m-0">Programme</label><br>
                            <x-resource.link-with-icon :name="$event->contract->contract_name"
                                :link="t_route('gantt', Illuminate\Support\Facades\Crypt::encryptString($event->programme->id))"
                            />
                        </div>
                    </div>

                    <div class="row py-2 border-bottom">
                        <div class="col-12">
                            <label class="form-label fw-bold m-0">Title</label><br>
                            {{ $event->title }}
                        </div>
                    </div>

                    <div class="row border-bottom py-2 mb-3">
                        <div class="col-sm-12">
                            <label class="form-label fw-bold m-0">Description</label><br>
                            {{ $event->description }}
                        </div>
                    </div>

                    <div class="row py-2 border-bottom">
                        <div class="col-12 mb-3">
                            @if ($event->early_warning)
                                <label class="form-label fw-bold m-0">Early Warning</label><br>
                                {{ $event->early_warning->title }}
                                <a href="{{ t_route('early-warnings.show', $event->early_warning_id) }}"><i class="mdi mdi-link-variant"></i></a>
                            @elseif ($event->early_warning_id == App\Models\Statical\Constant::OPTION_NO_EARLY_WARNING_ID)
                                <label class="form-label fw-bold mb-3">{{ App\Models\Statical\Constant::OPTION_NO_EARLY_WARNING }}</label>
                                <x-form.checkbox-customized label="the Contractor should have notified an Early Warning" name="ev_notified" :checked="$event->early_warning_notified == 1" disabled />
                            @endif
                        </div>
                    </div>
                  
                    <div class="row py-3">
                        <div class="col-sm-12">
                            <label class="form-label fw-bold m-0">Created by</label><br>
                            {{ $event->author->full_name() }} on {{ date(AppTenant\Models\Statical\Format::DATE_READABLE, strtotime($event->created_at)) }}
                        </div>
                    </div>

                    <div class="d-print-none">
                        <x-resource-page.buttons.bottom :resource="$event" />
                    </div>
                </div>
            </div>
           
            @if ($event->isDraft())
                <x-resource-page.actions.draft-delete-notify
                    :resource="$event"
                    deleteCallback="deleteCE"
                    notifyCallback="notifyCE"
                />
            @endif
        </div>
        <x-resource-page.right-tabs
            :resource="$event"
            :uploads-files="$files"
            :uploads-folder="AppTenant\Models\Statical\MediaCollection::COLLECTION_COMPENSATION_EVENTS"
        />
    </div>
@endsection
@push('script')
    <script>
        function deleteCE() {
            window.location.href = "{{ t_route('compensation-events.delete-draft', $event->id) }}";
        }

        function notifyCE() {
            window.location.href = "{{ t_route('compensation-events.notify', $event->id) }}";
        }
    </script>
@endpush