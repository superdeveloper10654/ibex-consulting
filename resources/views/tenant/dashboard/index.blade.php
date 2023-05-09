@extends('tenant.layouts.master')

@section('css')
<link href="{{ URL::asset('/assets/css/dashboard/index.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('title')
@lang('Dashboard')
@endsection

@section('content')

<style>
.col-md-2.text-center {
    border-left: solid 1px #eee;
    border-right: solid 1px #eee;
}
  .card {
    margin-bottom: 12px;
  }
  .col {
    padding: 0 6px;
}
  .row .col:first-child {
    padding: 0 6px 0 12px;
}
</style>

<div class="animated-fast">
    <!-- start page title -->
    <div class="row">
        <div class="col">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Dashboard</h4>

                <div class="page-title-right d-none">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="d-flex">
                            <img src="{{ $profile->avatar_url() }}" alt="" class="rounded-circle avatar-lg border me-4">
                            <div>
                                <p class="text-muted fw-medium">Good morning</p>
                                <h5>{{ $profile->first_name }} {{ $profile->last_name }}</h5>
                                <p class="text-muted fw-medium">{{ $profile->organisation }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      <div class="col">
          
            <a href="{{t_route('early-warnings') }}" class="card">
                <div class="card-body">
                  <p class="text-muted">Risk</p>
                  <div class="row">
                  <div class="col-md-3">
                            <div class="col text-center">
                              <p class="m-0 text-dark me-3">Early Warnings</p>
                                <h4 class="m-0 ">{{ $early_warning_count }}</h4>
                                <span class="badge bg-warning">{{ $early_warning_open_count }} open</span>
                            <div id="early_warnings_sparkline" class="text-center text-warning"></div>
                          </div>

                    </div>
                     <div class="col-md-3">
                            <div class="col text-center">
                              <p class="m-0 text-dark me-3">Mitigation</p>
                                <h4 class="m-0 ">{{ $early_warning_count }}</h4>
                                <span class="badge bg-warning">{{ $early_warning_open_count }} open</span>
                            <div id="mitigations_sparkline" class="text-center text-warning"></div>
                          </div>

                    </div>
                  </div>
                </div>
            </a>
        </div>
    </div>

    <div class="row">
      <div class="col">
    <div class="card">
      <div class="card-body">
        <h5>Activity</h5>
        <ul class="list-group" data-simplebar="init" style="max-height: 390px;">
          <div class="simplebar-wrapper" style="margin: 0px;">
            <div class="simplebar-height-auto-observer-wrapper">
              <div class="simplebar-height-auto-observer"></div>
            </div>
            <div class="simplebar-mask">
              <div class="simplebar-offset" style="right: -16.8px; bottom: 0px;">
                <div class="simplebar-content-wrapper" style="height: auto; overflow: hidden scroll; padding-right: 20px; padding-bottom: 0px;">
                  <div class="simplebar-content" style="padding: 0px;">
                    @if ($activities->isEmpty()) Nothing yet @else @foreach ($activities as $activity)
                    <li class="list-group-item border-0 animated-activity">
                      <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                          <div class="avatar-xs">
                            <span class="avatar-title rounded-circle bg-light text-dark fs-6">
                                                                            {!! $activity->img !!}
                                                                        </span>
                          </div>
                        </div>
                        <div class="flex-grow-1">
                          <p>
                            {!! $activity->profile ? $activity->profile->full_name() . '&nbsp;' : '' !!}{!! $activity->text !!}
                          </p>
                          <p class="text-muted small">
                            {{ date('D jS M Y H:i', strtotime($activity->created_at)) }}
                          </p>
                        </div>
                      </div>
                    </li>
                    @endforeach @endif
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
    </div>
  </div>
       <div class="col">
    <div class="card" style="background: none">
      <div class="card-body">
        <h5>Reminders</h5>
    <ul class="nav nav-tabs d-print-none" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link activemployerontractor-reminders-tab" data-bs-toggle="tab" data-bs-target="#contractor-reminders" type="button" role="tab" aria-controls="contractor-reminders" aria-selected="true">Contractor's</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="employer-reminders-tab" data-bs-toggle="tab" data-bs-target="#employer-reminders" type="button" role="tab" aria-controls="employer-reminders" aria-selected="true">Employer's</button>
      </li>
    </ul>
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="contractor-reminders" role="tabpanel" aria-labelledby="contractor-reminders-tab">
        <div class="card">
          <div class="card-body">
            <div class="files-list-wrapper row">

              <div>
                <ul class="list-group" data-simplebar="init" style="max-height: 390px;">
          <div class="simplebar-wrapper" style="margin: 0px;">
            <div class="simplebar-height-auto-observer-wrapper">
              <div class="simplebar-height-auto-observer"></div>
            </div>
            <div class="simplebar-mask">
              <div class="simplebar-offset" style="right: -16.8px; bottom: 0px;">
                <div class="simplebar-content-wrapper" style="height: auto; overflow: hidden scroll; padding-right: 20px; padding-bottom: 0px;">
                  <div class="simplebar-content" style="padding: 0px;">
                    @if ($activities->isEmpty()) Nothing yet @else @foreach ($activities as $activity)
                    <li class="list-group-item border-0 animated-activity">
                      <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                          <div class="avatar-xs">
                            <span class="avatar-title rounded-circle bg-light text-dark fs-6">
                                                                            {!! $activity->img !!}
                                                                        </span>
                          </div>
                        </div>
                        <div class="flex-grow-1">
                          <p>
                            {!! $activity->profile ? $activity->profile->full_name() . '&nbsp;' : '' !!}{!! $activity->text !!}
                          </p>
                          <p class="text-muted small">
                            {{ date('D jS M Y H:i', strtotime($activity->created_at)) }}
                          </p>
                        </div>
                      </div>
                    </li>
                    @endforeach @endif
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
                      <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                        <div class="simplebar-content-wrapper" style="height: auto; overflow: hidden; padding-right: 20px; padding-bottom: 0px;">
                          <div class="simplebar-content" style="padding: 0px;">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="simplebar-placeholder" style="width: 347px; height: 0px;"></div>
                  </div>
                  <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                    <div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div>
                  </div>
                  <div class="simplebar-track simplebar-vertical" style="visibility: hidden;">
                    <div class="simplebar-scrollbar" style="height: 297px; transform: translate3d(0px, 0px, 0px); display: none;"></div>
                  </div>
                </ul>
              </div>

            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane fade show active" id="employer-reminders" role="tabpanel" aria-labelledby="employer-reminders-tab">
        <div class="card">
          <div class="card-body">
            <div class="files-list-wrapper row">

              <div>
                <ul class="list-group" data-simplebar="init" style="max-height: 390px;">
          <div class="simplebar-wrapper" style="margin: 0px;">
            <div class="simplebar-height-auto-observer-wrapper">
              <div class="simplebar-height-auto-observer"></div>
            </div>
            <div class="simplebar-mask">
              <div class="simplebar-offset" style="right: -16.8px; bottom: 0px;">
                <div class="simplebar-content-wrapper" style="height: auto; overflow: hidden scroll; padding-right: 20px; padding-bottom: 0px;">
                  <div class="simplebar-content" style="padding: 0px;">
                    @if ($activities->isEmpty()) Nothing yet @else @foreach ($activities as $activity)
                    <li class="list-group-item border-0 animated-activity">
                      <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                          <div class="avatar-xs">
                            <span class="avatar-title rounded-circle bg-light text-dark fs-6">
                                                                            {!! $activity->img !!}
                                                                        </span>
                          </div>
                        </div>
                        <div class="flex-grow-1">
                          <p>
                            {!! $activity->profile ? $activity->profile->full_name() . '&nbsp;' : '' !!}{!! $activity->text !!}
                          </p>
                          <p class="text-muted small">
                            {{ date('D jS M Y H:i', strtotime($activity->created_at)) }}
                          </p>
                        </div>
                      </div>
                    </li>
                    @endforeach @endif
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
                      <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                        <div class="simplebar-content-wrapper" style="height: auto; overflow: hidden; padding-right: 20px; padding-bottom: 0px;">
                          <div class="simplebar-content" style="padding: 0px;">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="simplebar-placeholder" style="width: 347px; height: 0px;"></div>
                  </div>
                  <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                    <div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div>
                  </div>
                  <div class="simplebar-track simplebar-vertical" style="visibility: hidden;">
                    <div class="simplebar-scrollbar" style="height: 297px; transform: translate3d(0px, 0px, 0px); display: none;"></div>
                  </div>
                </ul>
              </div>

            </div>
          </div>
        </div>
      </div>
      
    </div>
      </div>
    </div>
  </div>
    
        
        
  
    </div>

    <div class="row">
  
  <div class="col">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <h5>Projects</h5>
          <div class="input-group mb-3" style="width:150px">
            <select class="form-select" id="inputGroupSelect02">
                                    <option value="1" selected>Jan</option>
                                    <option value="2">Feb</option>
                                    <option value="3">Mar</option>
                                    <option value="4">Apr</option>
                                    <option value="5">May</option>
                                    <option value="6">June</option>
                                    <option value="7">July</option>
                                    <option value="8">Aug</option>
                                    <option value="9">Sep</option>
                                    <option value="10">Oct</option>
                                    <option value="11">Nov</option>
                                    <option value="12">Dec</option>
                                </select>
            <label class="input-group-text" for="inputGroupSelect02">Month</label>
          </div>
        </div>
        <div>
          @if (!$projects->isEmpty()) @foreach ($projects as $key => $project)
          <div class="d-flex justify-content-between">
            <div class="flex-grow">
              <p class="text-muted fw-medium">{{ $project->name }}</p>
              <p class="text-muted small">{{ date('D jS M Y', strtotime($project->created_at)) }}</p>
            </div>
            <div class="flex-grow">
              <p class="text-muted fw-medium">{{$project->contract ? $project->contract->contract_name:'' }}</p>
            </div>
            <div id="pie_chart{{ $key }}" class="me-4"></div>
          </div>

          @if (($key + 1) != $projects->count())
          <hr class="mt-2 mb-4" /> @endif @endforeach @else No records found @endif
        </div>
      </div>
    </div>
  </div>
<div class="col">
            <a href="#" class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="avatar-sm">
                            <span class="avatar-title rounded-circle border bg-light" style="">
                                <i class="mdi mdi-scale-balance display-4"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 text-center align-items-center justify-content-between">
                            <p class="text-muted">Compensation Events</p>
                            <div class="d-flex align-items-center justify-content-between">
                                <h4 class="m-0 flex-grow text-center">{{ $compensation_events_count }}</h4>
                                <span class="badge badge-soft-danger">{{ $compensation_events_open_count }} open</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
            <a href="{{t_route('snags-and-defects') }}" class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="avatar-sm">
                            <span class="avatar-title rounded-circle border bg-light" style="">
                                <i class="mdi mdi-diamond-stone display-4"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 text-center align-items-center justify-content-between">
                            <p class="text-muted">Snags / Defects</p>
                            <div class="d-flex align-items-center justify-content-between">
                                <h4 class="m-0 flex-grow text-center">{{ $snags_and_defects_count }}</h4>
                                <span class="badge badge-soft-danger">{{ $snags_and_defects_open_count }} open</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

   
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <h5>Contracts</h5>

                    </div>
                    <div>
                        @if (!$contracts->isEmpty()) @foreach ($contracts as $key => $contract)

                        <div class="d-flex">
                            <div class="avatar-md me-4">
                                <span class="avatar-title rounded-circle bg-light text-danger font-size-16">
                                    <img class="w-100 rounded-circle" src="{{ $contract->img_url() }}" alt="@lang('Contract icon')">
                                </span>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-truncate text-dark fw-medium mb-1">{{ $contract->contract_name }}</p>
                                <p>{{ $contract->contractor_profile->organisation }}</p>
                                <p class="text-muted m-0">
                                    {{ $contract->contract_type }} created on {{ date(AppTenant\Models\Statical\Format::DATE_READABLE, strtotime($contract->created_at)) }}
                                </p>
                            </div>
                            <div class="contact-links d-flex font-size-20 text-center">
                                @t_can('contracts.read')
                                <div class="flex-fill">
                                    <a href="{{t_route('contracts.show', $contract->id) }}" title="@lang('Show details')"><i class="mdi mdi-eye"></i></a>
                                </div>
                                @endt_can @t_can('contracts.update')
                                <div class="flex-fill">
                                    <a href="{{t_route('contracts.edit', $contract->id) }}" title="Edit"><i class="mdi mdi-pencil"></i></a>
                                </div>
                                @endt_can
                            </div>
                        </div>

                        @if (($key + 1) != $contracts->count())
                        <hr class="mt-2 mb-4" /> @endif @endforeach @else No records found @endif
                    </div>
                </div>
            </div>
        </div>
      
      <div class="col-md-3 d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted fw-medium text-center">Profiles</p>
                                <div>
                                    @if (!empty($team_accounts))
                                    <a href="{{t_route('profiles') }}">
                                        @foreach ($team_accounts as $account)
                                        <img src="{{ $account->avatar_url() }}" alt="Profile avatar" class="rounded-circle avatar-sm border me-n3 bg-white">
                                        @endforeach
                                    </a> @endif
                                </div>
                            </div>
                            <button type="button" class="btn btn-light">
                                    <i class="fa fa-wrench"></i>
                                </button>
                        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5>Early Warnings</h5>
                    <div class="table-responsive">
                        <table class="table align-middle table-nowrap table-hover">
                            @if ($early_warnings->isEmpty())
                                Nothing yet
                            @else
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Contract</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Risk Score</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">reminders</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($early_warnings as $early_warning)
                                        <tr>
                                            <td>{{ $early_warning->id }}</td>
                                            <td>{{ $early_warning->contract->contract_name }}</td>
                                            <td>{{ date(AppTenant\Models\Statical\Format::DATE_READABLE, strtotime($early_warning->created_at)) }}</td>
                                            <td>{{ $early_warning->risk_score }}</td>
                                            <td>{!! $early_warning->status()->icon !!} {{ $early_warning->status()->name }}</td>
                                            <td>
                                                <ul class="list-inline font-size-20 contact-links mb-0">
                                                    <li class="list-inline-item px-2">
                                                        <a href="{{t_route('early-warnings.show', $early_warning->id) }}" title="Show details"><i class="mdi mdi-eye"></i></a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

<script>
    jQuery(($) => {
        var EW_sparkline = new ApexCharts(document.querySelector("#early_warnings_sparkline"), {
            series: [{
                data: [{{implode(',', $risk_profiles_chart_arr)}}]
            }],
            chart: {
                type: 'area',
                width: 160,
                height: 35,
                sparkline: {
                    enabled: true
                }
            },
          colors: ['#f1b44c'],
          fill: {
          opacity: 0.3
        },
            stroke: {
                width: 2
            },
            tooltip: {
                fixed: {
                    enabled: false
                },
                x: {
                    show: false
                },
                y: {
                    title: {
                        formatter: function(seriesName) {
                            return ''
                        }
                    },
                    formatter: function(num) {
                        return num;
                    }
                },
                marker: {
                    show: false
                }
            },
            grid: {
                padding: {
                    top: 5,
                    bottom: 5
                }
            }
        });
        EW_sparkline.render();

        
    });
  
  
  jQuery(($) => {
        var mitigations_sparkline = new ApexCharts(document.querySelector("#mitigations_sparkline"), {
            series: [{
                data: [{{implode(',', $risk_profiles_chart_arr)}}]
            }],
            chart: {
                type: 'area',
                width: 160,
                height: 35,
                sparkline: {
                    enabled: true
                }
            },
          colors: ['#f1b44c'],
          fill: {
          opacity: 0.3
        },
            stroke: {
                width: 2
            },
            tooltip: {
                fixed: {
                    enabled: false
                },
                x: {
                    show: false
                },
                y: {
                    title: {
                        formatter: function(seriesName) {
                            return ''
                        }
                    },
                    formatter: function(num) {
                        return num;
                    }
                },
                marker: {
                    show: false
                }
            },
            grid: {
                padding: {
                    top: 5,
                    bottom: 5
                }
            }
        });
        mitigations_sparkline.render();

    });
  
  

    function createPieChart(selector, data) {
        if (!$(selector).length) {
            return false;
        }

      let pie_chart_0 = createPieChart('#pie_chart0', [35, 11, 7, 55]);
        let pie_chart_1 = createPieChart('#pie_chart1', [43, 32, 12, 9]);
        let pie_chart_2 = createPieChart('#pie_chart2', [5, 12, 72, 34]);
        let pie_chart_3 = createPieChart('#pie_chart3', [18, 6, 34, 54]);
      
        var pie_chart = new ApexCharts(document.querySelector(selector), {
            series: data,
            chart: {
                type: 'donut',
                width: 40,
                height: 40,
                sparkline: {
                    enabled: true
                }
            },
            stroke: {
                width: 1
            },
            tooltip: {
                fixed: {
                    enabled: false
                },
            }
        });
        pie_chart.render();
        return pie_chart;
    }
</script>
@endsection