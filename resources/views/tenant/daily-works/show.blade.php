@extends('tenant.layouts.master')

@section('title') Daily Work Record #{{ $dailyWorkRecord->id }} @endsection

@section('content')

@component('components.breadcrumb')
    @slot('li_1') Daily Work Records @endslot
    @slot('title') Daily Work Record #{{ $dailyWorkRecord->id }} @endslot
@endcomponent

<div class="row">
        <div class="col-md-8">
          <button type="button" class="d-print-none btn expand-toggle waves-effect mb-2">Expand<span class="expand_icon"> <i class="bx bx-expand"></i></span></button>
            <div class="card">
                <div class="card-body p-lg-5">
                <div class="row">
                    <div class="col-md-6 mb-5" style="padding-left: 0;">
                        <img src="{{ asset('assets/images/eurovia-logo.png') }}" height="50" style="margin-top: -10px;"/>
                    </div>
                    <div class="col-md-6" style="text-align: right">
                        <h4 class="font-size-18 fw-bold">
                            <span class="ps-3"> Daily Work Record  #{{ $dailyWorkRecord->id }}</span>
                        </h4>
                      <p>{{ date(AppTenant\Models\Statical\Format::DATE_READABLE, strtotime($dailyWorkRecord->date)) }}</p>
                    </div>
                </div>

                  <div class="row pb-3">
                        <div class="col-md-4">
                            <strong>Contract</strong><br>{{$dailyWorkRecord->contract->contract_name}}
                        </div>
                        <div class="col-md-4">
                            <strong>Client Name</strong><br>{{$dailyWorkRecord->client_profile->name}}
                        </div>
                        <div class="col-md-4">
                            <strong>Site Name</strong><br>{{$dailyWorkRecord->site_name}}
                        </div>
                  </div>

                  <div class="row pb-3 mb-3">
                        <div class="col-md-4">
                            <strong>Reference No</strong><br>{{$dailyWorkRecord->reference_no}}
                        </div>
                        <div class="col-md-4">
                            <strong>Supervisor</strong><br>{{$dailyWorkRecord->supervisor_profile->name}}
                        </div>
                        <div class="col-md-4">
                            <strong>Foreman</strong><br>{{$dailyWorkRecord->foreman}}
                        </div>
                  </div>

                  <hr>

                <div class="row border-bottom pt-3">
                    <div class="col-md-6">
                        <strong>Direct Personnel</strong><br><br>
                    @if ($dailyDirectPessonels->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table table-sm align-middle table-borderless">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th style="table-layout:fixed; width:250px;">Name, Role</th>
                                            <th>Hours</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dailyDirectPessonels as $index=>$dailyDirectPessonel)
                                        <tr>
                                            <td>{{ $index + 1}}</td>
                                            <td>{{ $dailyDirectPessonel->directPersonnel->name .', '.$dailyDirectPessonel->directPersonnel->role }}</td>
                                            <td>{{ $dailyDirectPessonel->worked_hours }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                    @else
                        Not recorded
                    @endif
                    </div>
                     <div class="col-md-6">
                        <strong>Direct Vehicles & Plant</strong><br><br>
                    @if ($dailyDirectVehiclesAndPlants->isNotEmpty())
                            <div class="table-responsive">
                                    <table class="table table-sm align-middle table-borderless">
                                        <thead class="table-light">
                                        <tr>
                                        <th>#</th>
                                            <th style="table-layout:fixed; width:250px;">Name, Reference No</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dailyDirectVehiclesAndPlants as $index=>$dailyDirectVehiclesAndPlant)
                                        <tr>
                                            <td>{{ $index + 1}}</td>
                                            <td>{{ $dailyDirectVehiclesAndPlant->directVehicleAndPlant->vehicle_or_plant_name .', '.$dailyDirectVehiclesAndPlant->directVehicleAndPlant->ref_no }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                    @else
                        Not recorded
                    @endif
                    </div>
                </div>

                <div class="row border-bottom pt-3">
                    <strong>Subcontract Personnel</strong><br><br>
                        @if ($dailySubContractPessonels->isNotEmpty())
                                <div class="table-responsive">
                                    <table class="table table-sm align-middle table-borderless">
                                    <thead class="table-light">
                                            <tr>
                                                <th>#</th>
                                                <th style="table-layout:fixed; width:250px;">Name, Role, Company</th>
                                                <th>Hours</th>
                                                <th>Comments</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($dailySubContractPessonels as $index=>$dailySubContractPessonel)
                                            <tr>
                                                <td>{{ $index + 1}}</td>
                                                <td>{{ $dailySubContractPessonel->subContractPersonnel->name . ', '.$dailySubContractPessonel->subContractPersonnel->role . ', '.$dailySubContractPessonel->subContractPersonnel->subbie_name }}</td>
                                                <td>{{ $dailySubContractPessonel->worked_hours }}</td>
                                                <td>{{ $dailySubContractPessonel->comments }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                        @else
                            Not recorded
                        @endif
                </div>

                  <div class="row border-bottom pt-3">
                    <strong>Subcontract / Hired Vehicles & Plant</strong><br><br>
                        @if ($dailySubcontractOrHiredVehiclesAndPlants->isNotEmpty())
                                <div class="table-responsive">
                                    <table class="table table-sm align-middle table-borderless">
                                    <thead class="table-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Name, Company, Reference No</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($dailySubcontractOrHiredVehiclesAndPlants as $index=>$dailySubcontractOrHiredVehiclesAndPlant)
                                            <tr>
                                                <td>{{ $index + 1}}</td>
                                                <td>{{ $dailySubcontractOrHiredVehiclesAndPlant->subcontractOrHiredVehicleAndPlant->vehicle_or_plant_name . ', '.$dailySubcontractOrHiredVehiclesAndPlant->subcontractOrHiredVehicleAndPlant->supplier_name . ', '.$dailySubcontractOrHiredVehiclesAndPlant->subcontractOrHiredVehicleAndPlant->ref_no }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                        @else
                            Not recorded
                        @endif
                    </div>

                <div class="row border-bottom pt-3">
                        <strong>Subcontract / Client Operations</strong><br><br>
                    @if ($dailySubcontractOrClientOperations->isNotEmpty())

                            <div class="table-responsive">
                                <table class="table table-sm align-middle table-borderless">
                                    <thead class="table-light">
                                        <tr>
                                        <th>#</th>
                                            <th style="table-layout:fixed; width:250px;">Company Name</th>
                                            <th>Operation</th>
                                            <th>Comments</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dailySubcontractOrClientOperations as $index=>$dailySubcontractOrClientOperation)
                                        <tr>
                                            <td>{{ $index + 1}}</td>
                                            <td>{{ $dailySubcontractOrClientOperation->subcontractOrClientOperation->subbie_name }}</td>
                                            <td>{{ $dailySubcontractOrClientOperation->operation->name }}</td>
                                            <td>{{ $dailySubcontractOrClientOperation->comments }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                    @else
                        Not recorded
                    @endif
                    </div>

                <div class="row border-bottom pt-3">
                        <strong>Materials Ordered / Supplied</strong><br><br>
                    @if ($dailyOrderedSuppliedMaterials->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table table-sm align-middle table-borderless">
                                    <thead class="table-light">
                                        <tr>
                                        <th>#</th>
                                            <th style="table-layout:fixed; width:250px;">Name / Description</th>
                                            <th>Ordered</th>
                                            <th>Supplied</th>
                                            <th>Comments</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dailyOrderedSuppliedMaterials as $index=>$dailyOrderedSuppliedMaterial)
                                        <tr>
                                            <td>{{ $index + 1}}</td>
                                            <td>{{ $dailyOrderedSuppliedMaterial->Material->name }}</td>

                                            <td>{{ $dailyOrderedSuppliedMaterial->comments }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                    @else
                        Not recorded
                    @endif
                    </div>

                <div class="row border-bottom pt-3">
                        <strong>Weather Conditions</strong><br><br>
                    @if ($dailyWeatherConditions->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table table-sm align-middle table-borderless">
                                    <thead class="table-light">
                                        <tr>
                                        <th>#</th>
                                            <th>Time</th>
                                            <th style="table-layout:fixed; width:250px;">Observation</th>
                                            <th>Air (°C)</th>
                                            <th>Ground (°C)</th>
                                            <th>Wind (Km/h)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dailyWeatherConditions as $index=>$dailyWeatherCondition)
                                        <tr>
                                            <td>{{ $index + 1}}</td>
                                            <td>{{ $dailyWeatherCondition->time }}</td>
                                            <td>{{ $dailyWeatherCondition->observation }}</td>
                                            <td>{{ $dailyWeatherCondition->air }}</td>
                                            <td>{{ $dailyWeatherCondition->ground }}</td>
                                            <td>{{ $dailyWeatherCondition->wind }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                    @else
                        Not recorded
                    @endif
                    </div>

                <div class="row border-bottom pt-3">
                        <strong>Operational Timings</strong><br><br>
                    @if ($dailyOperationalTimingOperations->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table table-sm align-middle table-borderless">
                                    <thead class="table-light">
                                        <tr>
                                        <th>#</th>
                                            <th style="table-layout:fixed; width:250px;">Operation</th>
                                            <th>Started</th>
                                            <th>Completed</th>
                                            <th>Comments</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dailyOperationalTimingOperations as $index=>$dailyOperationalTimingOperation)
                                        <tr>
                                            <td>{{ $index + 1}}</td>
                                            <td>{{ $dailyOperationalTimingOperation->operation->name }}</td>
                                            <td>{{ $dailyOperationalTimingOperation->started }}</td>
                                            <td>{{ $dailyOperationalTimingOperation->completed }}</td>
                                            <td>{{ $dailyOperationalTimingOperation->comments }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                    @else
                        Not recorded
                    @endif

                    @if ($dailyOperationalTimingSuppliedMaterials->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table table-sm align-middle table-borderless">
                                    <thead class="table-light">
                                        <tr>
                                        <th>#</th>
                                            <th style="table-layout:fixed; width:250px;">Material</th>
                                            <th>Started</th>
                                            <th>Completed</th>
                                            <th>Comments</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dailyOperationalTimingSuppliedMaterials as $index=>$dailyOperationalTimingSuppliedMaterial)
                                        <tr>
                                            <td>{{ $index + 1}}</td>
                                            <td>{{ $dailyOperationalTimingSuppliedMaterial->material->name }}</td>
                                            <td>{{ $dailyOperationalTimingSuppliedMaterial->started }}</td>
                                            <td>{{ $dailyOperationalTimingSuppliedMaterial->completed }}</td>
                                            <td>{{ $dailyOperationalTimingSuppliedMaterial->comments }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                    @else
                        Not recorded
                    @endif

                    @if ($dailyOperationalTimingPlantHaulages->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table table-sm align-middle table-borderless">
                                    <thead class="table-light">
                                        <tr>
                                        <th>#</th>
                                            <th style="table-layout:fixed; width:250px;">Plant Haulage</th>
                                            <th>Started</th>
                                            <th>Completed</th>
                                            <th>Comments</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dailyOperationalTimingPlantHaulages as $index=>$dailyOperationalTimingPlantHaulage)
                                        <tr>
                                            <td>{{ $index + 1}}</td>
                                            <td>{{ $dailyOperationalTimingPlantHaulage->plant_haulage }}</td>
                                            <td>{{ $dailyOperationalTimingPlantHaulage->started }}</td>
                                            <td>{{ $dailyOperationalTimingPlantHaulage->completed }}</td>
                                            <td>{{ $dailyOperationalTimingPlantHaulage->comments }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                    @else
                        Not recorded
                    @endif

                    @if ($dailyOperationalTimingToClientInfos->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table table-sm align-middle table-borderless">
                                    <thead class="table-light">
                                        <tr>
                                        <th>#</th>
                                            <th>Demobilised/ Off-Site</th>
                                            <th>Comments</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dailyOperationalTimingToClientInfos as $index=>$dailyOperationalTimingToClientInfo)
                                        <tr>
                                            <td>{{ $index + 1}}</td>
                                            <td>{{ $dailyOperationalTimingToClientInfo->demoblished_or_offsite }}</td>
                                            <td>Informed the client at {{ $dailyOperationalTimingToClientInfo->informed_client }}. {{ $dailyOperationalTimingToClientInfo->comments }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                    @else
                        Not recorded
                    @endif
                  </div>

                    @if ($dailySiteRisks->isNotEmpty())
                    <div class="row pt-3 pb-3">
                        <strong>Risks / Issues / Narrative of completed works</strong><br><br>
                        <div class="col-md-12">
                          @foreach ($dailySiteRisks as $index=>$dailySiteRisk)
                           {{$index + 1}}.&nbsp; <span> {{ $dailySiteRisk->description_of_issue }}</span><br>
                        @endforeach
                    @else
                        Not recorded
                    @endif
                        </div>
                    </div>
                  <hr>

                <div class="d-print-none">
                    <div class="float-end">
                        <a href="javascript:window.print()" class="btn btn-secondary btn-rounded w-md waves-effect waves-light"><i class="fa fa-print me-1"></i>&nbsp;Print</a>
                    </div>
                </div>
              </div>

            </div>
        </div>


    <div class="col-md-4">
                <ul class="nav nav-tabs d-print-none" id="myTab" role="tablist" >
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="uploads-tab" data-bs-toggle="tab" data-bs-target="#uploads" type="button" role="tab" aria-controls="uploads" aria-selected="true">Evidence</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="uploads" role="tabpanel" aria-labelledby="uploads-tab">
                <div class="card">
                <div class="card-body p-4" >
                <x-uploads.files-list :files="$files" :folder="AppTenant\Models\Statical\MediaCollection::COLLECTION_DAILY_WORK_RECORD" :resource-id="$dailyWorkRecord->id" hide-empty-list="true">
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
                        <div class="mb-3 text-center d-print-none">
                            <button type="button" class="btn btn-secondary btn-rounded w-md waves-effect waves-light" onclick="$('#new-files').click()">
                                <i class="mdi mdi-upload me-1"></i>&nbsp;Upload
                            </button>
                        </div>
                  <div class="pagebreak"> </div>
                  <strong class="printonly">Uploads</strong>
                    </x-uploads.files-list>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>


@endsection
