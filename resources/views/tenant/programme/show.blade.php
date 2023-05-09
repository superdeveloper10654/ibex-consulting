@extends('tenant.layouts.master')

@section('title') Programme {{ $programme->name }} @endsection

@section('content')
    <x-resource.breadcrumb :resource="$programme" :title="'Programme ' . $programme->name" />

    <div class="row">
        <div class="left-col col-md-8">
            <div class="header-wrapper d-flex justify-content-between">
                <x-resource-page.button.expand />
                <x-resource-page.status-label-alert :resource="$programme" />
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
                                <span class="ps-3">Programme #{{ $programme->id }}</span>
                            </h4>
                            <p></p>
                        </div>
                    </div>
                    <div class="row pb-3">
                        <div class="col-sm-6">
                            <label class="form-label m-0">Name</label><br>
                            {{ $programme->name  }}
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label m-0">Contract</label><br>
                            <x-resource.link-with-icon :name="$programme->contract->contract_name" :resource="$programme->contract" />
                        </div>
                    </div>
                    <div class="row border-top pt-3 pb-3">
                        <div class="col-sm-12">
                            <label class="form-label m-0">Created by</label><br>
                            {{ $programme->author->full_name() }} on {{ date(AppTenant\Models\Statical\Format::DATE_READABLE, strtotime($programme->created_at)) }}
                        </div>
                    </div>
                    <div class="d-print-none">
                        <x-resource-page.buttons.bottom :resource="$programme" />
                    </div>
                </div>
            </div>

            @if ($programme->isDraft())
                <x-resource-page.actions.draft-delete-submit
                    :resource="$programme"
                    deleteCallback="deleteProgramme"
                    submitCallback="submitProgramme"
                />
            @elseif ($programme->isSubmitted() && t_profile()->can('programmes.accept-reject'))
                <x-resource-page.actions.accept-reject
                    :resource="$programme"
                    acceptCallback="acceptProgramme"
                    rejectCallback="rejectProgramme"
                />
            @endif
        </div>
        <x-resource-page.right-tabs
            :resource="$programme"
            :uploads-files="$files"
            :uploads-folder="AppTenant\Models\Statical\MediaCollection::COLLECTION_PROGRAMMES"
            :comments-request-url="t_route('programmes.add-comment', $programme->id)"
        />
    </div>
@endsection

@push('script')
    <script>
        @if ($programme->isDraft())
            function deleteProgramme()
            {
                window.location.href = "{{ t_route('programmes.delete-draft', $programme->id) }}";
            }

            function submitProgramme()
            {
                window.location.href = "{{ t_route('programmes.submit', $programme->id) }}";
            }
        @endif

        @if ($programme->isSubmitted() && t_profile()->can('programmes.accept-reject'))
            function acceptProgramme() {
                window.location.href = "{{ t_route('programmes.accept', $programme->id) }}";
            }

            function rejectProgramme() {
                window.location.href = "{{ t_route('programmes.reject', $programme->id) }}";
            }
        @endif
    </script>
@endpush