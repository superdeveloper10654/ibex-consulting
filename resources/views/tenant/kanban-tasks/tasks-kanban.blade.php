@extends('tenant.layouts.master')

@section('title') Kanban Board @endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script> -->

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script>
    window.jQuery ||
        document.write(
            '<script src="js/jquery-2.1.4.min.js" type="text/javascript"><\/script>'
        );
</script>

<link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css">
<script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500,700" rel="stylesheet" />
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
<!-- .caleran includes -->
<link href="{{ URL::asset('assets/css/caleran.min.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('assets/css/suite.css') }}" rel="stylesheet" />
<script src="{{ URL::asset('assets/js/caleran.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/suite.min.js') }}"></script>
<!-- .end caleran includes -->

<style type="text/css">
    button.btn.dropdown-toggle.btn-light {
        background: transparent;
        border: 0;
    }

    .dropdown.bootstrap-select.show-tick.form-control.border-0 button {
        margin-top: -50px;
        background: transparent;
    }

    .dropdown .dropdown.bootstrap-select.show-tick.form-control.border-0 button {
        margin-top: 0px;
        background: transparent;
        color: transparent;
        z-index: 10000;
    }

    .sub-task-actions {
        opacity: 0;
    }

    .subtask-name:hover .sub-task-actions {
        opacity: 1;
        transition: opacity 500ms;
    }

    .main-task-assignee {
        /* visibility: hidden; */
    }

    .main-task-assignee-label {
        /* z-index: 10002 */
    }

    /* .main-task-assignee-label:hover+select {
        visibility: visible;
    } */

    .spanner {
        position: absolute;
        top: 0;
        left: 0;
        /* background: #2a2a2a55; */
        width: 100%;
        display: block;
        text-align: center;
        height: 100%;
        color: #FFF;
        transform: translateY(35%);
        z-index: 1001;
        visibility: hidden;
    }

    .overlay {
        position: fixed;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        visibility: hidden;
    }

    .loader,
    .loader:before,
    .loader:after {
        border-radius: 50%;
        width: 2.5em;
        height: 2.5em;
        -webkit-animation-fill-mode: both;
        animation-fill-mode: both;
        -webkit-animation: load7 1.8s infinite ease-in-out;
        animation: load7 1.8s infinite ease-in-out;
    }

    .loader {
        color: #ffffff;
        font-size: 10px;
        margin: 80px auto;
        position: relative;
        text-indent: -9999em;
        -webkit-transform: translateZ(0);
        -ms-transform: translateZ(0);
        transform: translateZ(0);
        -webkit-animation-delay: -0.16s;
        animation-delay: -0.16s;
    }

    .loader:before,
    .loader:after {
        content: '';
        position: absolute;
        top: 0;
    }

    .loader:before {
        left: -3.5em;
        -webkit-animation-delay: -0.32s;
        animation-delay: -0.32s;
    }

    .loader:after {
        left: 3.5em;
    }

    @-webkit-keyframes load7 {

        0%,
        80%,
        100% {
            box-shadow: 0 2.5em 0 -1.3em;
        }

        40% {
            box-shadow: 0 2.5em 0 0;
        }
    }

    @keyframes load7 {

        0%,
        80%,
        100% {
            box-shadow: 0 2.5em 0 -1.3em;
        }

        40% {
            box-shadow: 0 2.5em 0 0;
        }
    }

    .show {
        visibility: visible;
    }

    .spanner,
    .overlay {
        opacity: 0;
        -webkit-transition: all 0.3s;
        -moz-transition: all 0.3s;
        transition: all 0.3s;
    }

    .spanner.show,
    .overlay.show {
        opacity: 1
    }

    /* .overlay {
        position: absolute;
        width: 100%;
        height: 100%;
        z-index: 1000;
        top: 40%;
        left: 0px;
        opacity: 0.5;
        filter: alpha(opacity=50);

    } */

    .task-details {
        overflow-x: hidden;
    }

    @media only screen and (max-width: 585px) {
        .row.fixed-top.fixed-content {
            width: 585px;
        }

    }

    @media only screen and (min-width: 586px) {
        .row.fixed-top.fixed-content {
            max-width: 585px;
        }

    }

    .glyphicon-calendar {
        font-size: 15pt;
    }

    .input-group {
        width: 180px;
        margin-top: 30px;
    }

    .datepicker.dropdown-menu {
        z-index: 9999 !important;
    }


    svg {
        width: 15px;
    }

    /* transition: all 0.4s ease 0s; */
    .action-icons {
        width: 25px;
        border: 1px dotted gray;
        padding: 3px;
        border-radius: 50%;
    }

    /* select {
        margin: 50px;
        border: 1px solid #111;
        background: transparent;
        width: 150px;
        padding: 5px;
        font-size: 16px;
        border: 1px solid #ccc;
        height: 34px;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    } */
</style>
<!-- dragula css -->
<link href="{{ URL::asset('/assets/libs/dragula/dragula.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

@component('components.breadcrumb')
@slot('li_1') Tasks @endslot
@slot('title') {{$programme_data}} <a href="{{ t_route('gantt', Crypt::encryptString($programId)) }}"><i class="fa fa-retweet mx-2 text-black" data-toggle="tooltip" title="Switch to Gantt Tasks"></i></a>@endslot
@endcomponent

<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <!-- <div class="dropdown float-end">
                    <a href="#" class="dropdown-toggle arrow-none" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-dots-vertical m-0 text-muted h5"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="#">Edit</a>
                        <a class="dropdown-item" href="#">Delete</a>
                    </div>
                </div>  -->
                <!-- end dropdown -->

                <h4 class="card-title mb-4">Upcoming</h4>
                <div id="task-1">
                    <div id="upcoming-task" class="pb-1 task-list">
                        @foreach ($upcomingTasks as $upcomingTask)
                        <div class="task" id="task-cards-{{$upcomingTask->id}}">
                            <div class="card task-box" id="{{$upcomingTask->id}}" onclick="showFixedContent(event,'{{ json_encode($upcomingTask)}}')">
                                <div class="card-body">
                                    <div class="mb-2 actions">
                                        <div class="dropdown float-end">
                                            <a href="#" class="dropdown-toggle arrow-none" data-bs-toggle="dropdown" aria-expanded="false" onclick="stopPropagation(event)">
                                                <i class="mdi mdi-dots-vertical m-0 text-muted h5"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item edittask-details" href="#" id="taskedit" data-id="#cmptask-1" data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg">Edit</a>
                                                <a class="dropdown-item deletetask" href="#" data-id="#cmptask-1" onclick='deleteTask(event,"{{$upcomingTask->id}}")'>Delete</a>
                                            </div>
                                        </div> <!-- end dropdown -->
                                        <div class="float-end ml-2">
                                            <span class="badge rounded-pill badge-soft-secondary font-size-12">Waiting</span>
                                        </div>
                                        <div>
                                            <h5 class="font-size-15"><a href="javascript: void(0);" class="text-dark">{{$upcomingTask->text}}</a></h5>
                                            <p class="text-muted mb-4">{{$upcomingTask->baseline_start}}</p>
                                        </div>

                                        <div class="row justify-content-between align-items-center overflow-hidden">
                                            <div class="avatar-group col-auto task-assigne align-items-center text-nowrap " style="flex-wrap: unset;">
                                                {{--@forelse ($upcomingTask->assignees as $assignee)
                                                <div class="avatar-group-item">
                                                    <a href="javascript: void(0);" class="d-inline-block" value="member-1">
                                                        <img src="{{ $assignee->avatar_url()}}" alt="" class="rounded-circle avatar-xs">
                                                </a>
                                            </div>
                                            @empty
                                            <div class="mx-n2" role="button">
                                                <svg class="action-icons" style="width: 32px;padding:5px" viewBox="0 0 32 32" aria-hidden="true" focusable="false">
                                                    <path d="M16,18c-4.4,0-8-3.6-8-8s3.6-8,8-8s8,3.6,8,8S20.4,18,16,18z M16,4c-3.3,0-6,2.7-6,6s2.7,6,6,6s6-2.7,6-6S19.3,4,16,4z M29,32c-0.6,0-1-0.4-1-1v-4.2c0-2.6-2.2-4.8-4.8-4.8H8.8C6.2,22,4,24.2,4,26.8V31c0,0.6-0.4,1-1,1s-1-0.4-1-1v-4.2C2,23,5,20,8.8,20h14.4c3.7,0,6.8,3,6.8,6.8V31C30,31.6,29.6,32,29,32z"></path>
                                                </svg>
                                            </div>

                                            @endforelse--}}

                                            <label class="input-group-btn mb-0 main-task-date-label mx-2" style="visibility: {{$upcomingTask->deadline ? 'hidden':'visible'}}" onclick="clickDate(event)">
                                                <div role=" button" tabindex="0" class="mx-1" aria-disabled="false" aria-pressed="false">
                                                    <svg class="action-icons" style="width: 32px;padding:7px" viewBox="0 0 32 32" aria-hidden="true" focusable="false">
                                                        <path d="M24,2V1c0-0.6-0.4-1-1-1s-1,0.4-1,1v1H10V1c0-0.6-0.4-1-1-1S8,0.4,8,1v1C4.7,2,2,4.7,2,8v16c0,3.3,2.7,6,6,6h16c3.3,0,6-2.7,6-6V8C30,4.7,27.3,2,24,2z M8,4v1c0,0.6,0.4,1,1,1s1-0.4,1-1V4h12v1c0,0.6,0.4,1,1,1s1-0.4,1-1V4c2.2,0,4,1.8,4,4v2H4V8C4,5.8,5.8,4,8,4z M24,28H8c-2.2,0-4-1.8-4-4V12h24v12C28,26.2,26.2,28,24,28z"></path>
                                                    </svg>
                                                </div>
                                            </label>
                                            <input type="text" class="date-input bg-transparent border-0 main-task-date-input mx-n5" name="deadline" data-taskid="{{$upcomingTask->id}}" readonly="readonly" role="button" onclick="stopPropagation(event)" onchange="updateAttribute(event)" @if($upcomingTask->deadline) value="{{date('D, d F Y',strtotime($upcomingTask->deadline))}}" @endif />

                                        </div>

                                        @if(count($upcomingTask->subTasks))
                                        <div class="col-auto p-0 mt-1 toggle-sub-task" onclick="showSubTask(event)">
                                            <span class="btn btn-outline-light btn-sm rounded-3 p-1 border-none" role="button" aria-label="Expand" tabindex="0">
                                                <span class="mx-1">{{count($upcomingTask->subTasks)}}</span>
                                                <svg class="" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                                    <path d="M20,15c-1.9,0-3.4,1.3-3.9,3H7c-2.8,0-5-2.2-5-5v-3h14.1c0.4,1.7,2,3,3.9,3c2.2,0,4-1.8,4-4s-1.8-4-4-4 c-1.9,0-3.4,1.3-3.9,3H2V3c0-0.6-0.4-1-1-1S0,2.4,0,3v10c0,3.9,3.1,7,7,7h9.1c0.4,1.7,2,3,3.9,3c2.2,0,4-1.8,4-4S22.2,15,20,15z M20,7c1.1,0,2,0.9,2,2s-0.9,2-2,2s-2-0.9-2-2S18.9,7,20,7z M20,21c-1.1,0-2-0.9-2-2s0.9-2,2-2s2,0.9,2,2S21.1,21,20,21z"></path>
                                                </svg>
                                                <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                                    <path class="arrow arrow-left" d="M17.5,10.7l-7.1-7.1C10,3.2,9.4,3,8.8,3.3c-0.6,0.2-1,0.8-1,1.4v14.9c0,0.6,0.4,1.2,1,1.4c0.2,0.1,0.4,0.1,0.6,0.1c0.4,0,0.8-0.2,1.1-0.5l7.1-7.1c0.4-0.4,0.6-0.9,0.6-1.5S17.9,11.1,17.5,10.7z"></path>
                                                    <path class="arrow arrow-down" style="display: none;" d="M20.9,9c-0.2-0.6-0.8-1-1.4-1h-15C3.9,8,3.4,8.4,3.1,9C2.9,9.5,3,10.2,3.5,10.6l7.1,7.1c0.4,0.4,0.9,0.6,1.5,0.6c0.5,0,1.1-0.2,1.5-0.6l7.1-7.1C21,10.2,21.1,9.5,20.9,9z"></path>
                                                </svg>
                                            </span>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="subtasks mt-2 col-md-12 overflow-hidden" style="max-height:0;">
                                    @foreach ($upcomingTask->subTasks as $subTask)
                                    <div class="subtask-name d-flex justify-content-between align-items-center p-0">
                                        <div class="d-flex align-items-center" role="button" style="max-width:60%;">
                                            <div class="">
                                                <svg style="width:14px" class="border border-dark rounded-circle bg-transparent" viewBox="0 0 32 32" aria-hidden="true" focusable="false">
                                                    <path style="fill:transparent" d="M31,16c0,8.3-6.7,15-15,15S1,24.3,1,16S7.7,1,16,1S31,7.7,31,16z"></path>
                                                    <path d="M13.4,22.1c-0.3,0-0.5-0.1-0.7-0.3l-3.9-3.9c-0.4-0.4-0.4-1,0-1.4s1-0.4,1.4,0l3.1,3.1l8.1-8.1c0.4-0.4,1-0.4,1.4,0   s0.4,1,0,1.4l-8.9,8.9C13.9,22,13.7,22.1,13.4,22.1z"></path>
                                                </svg>
                                            </div>
                                            <div class="" style="margin-left: 4px;z-index:1">
                                                <div class="" onclick="showFixedContent(event,'{{ json_encode($subTask)}}')" style="white-space: nowrap;text-overflow:ellipsis;overflow:hidden;">{{$subTask->text}}</div>
                                            </div>
                                        </div>
                                        <div class="sub-task-actions">
                                            <div class="d-flex bg-white" style="z-index:2;margin-left:2px;white-space: nowrap;">
                                                <div class="" style="margin-right:;">
                                                    <div role="button" tabindex="0" class="DeprecatedCircularButton DeprecatedCircularButton--enabled DeprecatedCircularButton--small DueDateContainer-button DueDateContainer-button--circular" aria-disabled="false" aria-pressed="false">
                                                        <svg class="action-icons" viewBox="0 0 32 32" aria-hidden="true" focusable="false">
                                                            <path d="M24,2V1c0-0.6-0.4-1-1-1s-1,0.4-1,1v1H10V1c0-0.6-0.4-1-1-1S8,0.4,8,1v1C4.7,2,2,4.7,2,8v16c0,3.3,2.7,6,6,6h16c3.3,0,6-2.7,6-6V8C30,4.7,27.3,2,24,2z M8,4v1c0,0.6,0.4,1,1,1s1-0.4,1-1V4h12v1c0,0.6,0.4,1,1,1s1-0.4,1-1V4c2.2,0,4,1.8,4,4v2H4V8C4,5.8,5.8,4,8,4z M24,28H8c-2.2,0-4-1.8-4-4V12h24v12C28,26.2,26.2,28,24,28z"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <!-- <div class="ml-2" role="button">
                                                    <svg class="action-icons" viewBox="0 0 32 32" aria-hidden="true" focusable="false">
                                                        <path d="M16,18c-4.4,0-8-3.6-8-8s3.6-8,8-8s8,3.6,8,8S20.4,18,16,18z M16,4c-3.3,0-6,2.7-6,6s2.7,6,6,6s6-2.7,6-6S19.3,4,16,4z M29,32c-0.6,0-1-0.4-1-1v-4.2c0-2.6-2.2-4.8-4.8-4.8H8.8C6.2,22,4,24.2,4,26.8V31c0,0.6-0.4,1-1,1s-1-0.4-1-1v-4.2C2,23,5,20,8.8,20h14.4c3.7,0,6.8,3,6.8,6.8V31C30,31.6,29.6,32,29,32z"></path>
                                                    </svg>
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach

                                    <div class="mt-2 addsubtask" data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg" data-id="{{$upcomingTask->id}}" onclick="addSubTask(event)">
                                        <button data-id="{{$upcomingTask->id}}" class="btn btn-outline-light btn-md p-1 px-2 rounded-3" style="border:none ;color:#495057">
                                            <span data-id="{{$upcomingTask->id}}" class=""><i class="fa fa-plus" style="color:#495057"></i></span>
                                            <span data-id="{{$upcomingTask->id}}" class="">
                                                &nbsp;Add subtask
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="text-center d-grid">
                    <a href="javascript: void(0);" class="btn btn-primary waves-effect waves-light addtask-btn" data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg"><i class="mdi mdi-plus me-1"></i> Add New</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end col -->

<div class="col-lg-4">
    <div class="card">
        <div class="card-body">
            <!-- <div class="dropdown float-end">
                    <a href="#" class="dropdown-toggle arrow-none" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-dots-vertical m-0 text-muted h5"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="#">Edit</a>
                        <a class="dropdown-item" href="#">Delete</a>
                    </div>
                </div>  -->
            <!-- end dropdown -->

            <h4 class="card-title mb-4">In Progress</h4>
            <div id="task-2">
                <div id="inprogress-task" class="pb-1 task-list">
                    @foreach ($ongoingTasks as $ongoingTask)
                    <div class="task" id="task-cards-{{$ongoingTask->id}}">
                        <div class="card task-box" id="{{$ongoingTask->id}}" onclick="showFixedContent(event,'{{ json_encode($ongoingTask)}}')">
                            <div class="card-body">
                                <div class="mb-2 actions">
                                    <div class="dropdown float-end">
                                        <a href="#" class="dropdown-toggle arrow-none" data-bs-toggle="dropdown" aria-expanded="false" onclick="stopPropagation(event)">
                                            <i class="mdi mdi-dots-vertical m-0 text-muted h5"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item edittask-details" href="#" id="taskedit" data-id="#cmptask-1" data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg">Edit</a>
                                            <a class="dropdown-item deletetask" href="#" data-id="#cmptask-1" onclick='deleteTask(event,"{{$ongoingTask->id}}")'>Delete</a>
                                        </div>
                                    </div> <!-- end dropdown -->
                                    <div class="float-end ml-2">
                                        <span class="badge rounded-pill badge-soft-warning font-size-12">In Progress</span>
                                    </div>
                                    <div>
                                        <h5 class="font-size-15"><a href="javascript: void(0);" class="text-dark">{{$ongoingTask->text}}</a></h5>
                                        <p class="text-muted mb-4">{{$ongoingTask->baseline_start}}</p>
                                    </div>

                                    <div class="row justify-content-between align-items-center overflow-hidden main-task-actions">
                                        <div class="avatar-group col-auto task-assigne align-items-center text-nowrap " style="flex-wrap: unset;">
                                            {{--@forelse ($ongoingTask->assignees as $assignee)
                                                <div class="avatar-group-item">
                                                    <a href="javascript: void(0);" class="d-inline-block" value="member-1">
                                                        <img src="{{ $assignee->avatar_url()}}" alt="" class="rounded-circle avatar-xs">
                                            </a>
                                        </div>
                                        @empty
                                        <div class="mx-n2" role="button">
                                            <svg class="action-icons" style="width: 32px;padding:5px" viewBox="0 0 32 32" aria-hidden="true" focusable="false">
                                                <path d="M16,18c-4.4,0-8-3.6-8-8s3.6-8,8-8s8,3.6,8,8S20.4,18,16,18z M16,4c-3.3,0-6,2.7-6,6s2.7,6,6,6s6-2.7,6-6S19.3,4,16,4z M29,32c-0.6,0-1-0.4-1-1v-4.2c0-2.6-2.2-4.8-4.8-4.8H8.8C6.2,22,4,24.2,4,26.8V31c0,0.6-0.4,1-1,1s-1-0.4-1-1v-4.2C2,23,5,20,8.8,20h14.4c3.7,0,6.8,3,6.8,6.8V31C30,31.6,29.6,32,29,32z"></path>
                                            </svg>
                                        </div>
                                        @endforelse--}}

                                        <label class="input-group-btn mb-0 main-task-date-label" style="visibility: {{$ongoingTask->deadline ? 'hidden':'visible'}}" onclick="clickDate(event)">
                                            <div role=" button" tabindex="0" class="mx-1" aria-disabled="false" aria-pressed="false">
                                                <svg class="action-icons" style="width: 32px;padding:7px" viewBox="0 0 32 32" aria-hidden="true" focusable="false">
                                                    <path d="M24,2V1c0-0.6-0.4-1-1-1s-1,0.4-1,1v1H10V1c0-0.6-0.4-1-1-1S8,0.4,8,1v1C4.7,2,2,4.7,2,8v16c0,3.3,2.7,6,6,6h16c3.3,0,6-2.7,6-6V8C30,4.7,27.3,2,24,2z M8,4v1c0,0.6,0.4,1,1,1s1-0.4,1-1V4h12v1c0,0.6,0.4,1,1,1s1-0.4,1-1V4c2.2,0,4,1.8,4,4v2H4V8C4,5.8,5.8,4,8,4z M24,28H8c-2.2,0-4-1.8-4-4V12h24v12C28,26.2,26.2,28,24,28z"></path>
                                                </svg>
                                            </div>
                                        </label>
                                        <input value="{{$ongoingTask->deadline}}" type="text" class="date-input bg-transparent border-0 main-task-date-input mx-n5" name="deadline" data-taskid="{{$ongoingTask->id}}" readonly="readonly" role="button" onclick="stopPropagation(event)" onchange="updateAttribute(event)" @if($ongoingTask->deadline) value="{{date('D, d F Y',strtotime($ongoingTask->deadline))}}" @endif/>
                                        <!-- <div role="button" tabindex="0" class="mx-1" aria-disabled="false" aria-pressed="false">
                                                <svg class="action-icons" style="width: 32px;padding:7px" viewBox="0 0 32 32" aria-hidden="true" focusable="false">
                                                    <path d="M24,2V1c0-0.6-0.4-1-1-1s-1,0.4-1,1v1H10V1c0-0.6-0.4-1-1-1S8,0.4,8,1v1C4.7,2,2,4.7,2,8v16c0,3.3,2.7,6,6,6h16c3.3,0,6-2.7,6-6V8C30,4.7,27.3,2,24,2z M8,4v1c0,0.6,0.4,1,1,1s1-0.4,1-1V4h12v1c0,0.6,0.4,1,1,1s1-0.4,1-1V4c2.2,0,4,1.8,4,4v2H4V8C4,5.8,5.8,4,8,4z M24,28H8c-2.2,0-4-1.8-4-4V12h24v12C28,26.2,26.2,28,24,28z"></path>
                                                </svg>
                                            </div> -->
                                    </div>

                                    @if(count($ongoingTask->subTasks))
                                    <div class="col-auto p-0 mt-1 toggle-sub-task" onclick="showSubTask(event)">
                                        <span class="btn btn-outline-light btn-sm rounded-3 p-1 border-none" role="button" aria-label="Expand" tabindex="0">
                                            <span class="mx-1">{{count($ongoingTask->subTasks)}}</span>
                                            <svg class="" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                                <path d="M20,15c-1.9,0-3.4,1.3-3.9,3H7c-2.8,0-5-2.2-5-5v-3h14.1c0.4,1.7,2,3,3.9,3c2.2,0,4-1.8,4-4s-1.8-4-4-4 c-1.9,0-3.4,1.3-3.9,3H2V3c0-0.6-0.4-1-1-1S0,2.4,0,3v10c0,3.9,3.1,7,7,7h9.1c0.4,1.7,2,3,3.9,3c2.2,0,4-1.8,4-4S22.2,15,20,15z M20,7c1.1,0,2,0.9,2,2s-0.9,2-2,2s-2-0.9-2-2S18.9,7,20,7z M20,21c-1.1,0-2-0.9-2-2s0.9-2,2-2s2,0.9,2,2S21.1,21,20,21z"></path>
                                            </svg>
                                            <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                                <path class="arrow arrow-left" d="M17.5,10.7l-7.1-7.1C10,3.2,9.4,3,8.8,3.3c-0.6,0.2-1,0.8-1,1.4v14.9c0,0.6,0.4,1.2,1,1.4c0.2,0.1,0.4,0.1,0.6,0.1c0.4,0,0.8-0.2,1.1-0.5l7.1-7.1c0.4-0.4,0.6-0.9,0.6-1.5S17.9,11.1,17.5,10.7z"></path>
                                                <path class="arrow arrow-down" style="display: none;" d="M20.9,9c-0.2-0.6-0.8-1-1.4-1h-15C3.9,8,3.4,8.4,3.1,9C2.9,9.5,3,10.2,3.5,10.6l7.1,7.1c0.4,0.4,0.9,0.6,1.5,0.6c0.5,0,1.1-0.2,1.5-0.6l7.1-7.1C21,10.2,21.1,9.5,20.9,9z"></path>
                                            </svg>
                                        </span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="subtasks mt-2 col-md-12 overflow-hidden" style="max-height:0;">
                                @foreach ($ongoingTask->subTasks as $subTask)
                                <div class="subtask-name d-flex justify-content-between align-items-center p-0">
                                    <div class="d-flex align-items-center" role="button" style="max-width:60%;">
                                        <div class="">
                                            <svg style="width:14px" class="border border-dark rounded-circle bg-transparent" viewBox="0 0 32 32" aria-hidden="true" focusable="false">
                                                <path style="fill:transparent" d="M31,16c0,8.3-6.7,15-15,15S1,24.3,1,16S7.7,1,16,1S31,7.7,31,16z"></path>
                                                <path d="M13.4,22.1c-0.3,0-0.5-0.1-0.7-0.3l-3.9-3.9c-0.4-0.4-0.4-1,0-1.4s1-0.4,1.4,0l3.1,3.1l8.1-8.1c0.4-0.4,1-0.4,1.4,0   s0.4,1,0,1.4l-8.9,8.9C13.9,22,13.7,22.1,13.4,22.1z"></path>
                                            </svg>
                                        </div>
                                        <div class="" style="margin-left: 4px;z-index:1">
                                            <div class="" onclick="showFixedContent(event,'{{ json_encode($subTask)}}')" style="white-space: nowrap;text-overflow:ellipsis;overflow:hidden;">{{$subTask->text}}</div>
                                        </div>
                                    </div>
                                    <div class="sub-task-actions">
                                        <div class="d-flex bg-white" style="z-index:2;margin-left:2px;white-space: nowrap;">
                                            <div class="" style="margin-right: ;">
                                                <div role="button" tabindex="0" class="DeprecatedCircularButton DeprecatedCircularButton--enabled DeprecatedCircularButton--small DueDateContainer-button DueDateContainer-button--circular" aria-disabled="false" aria-pressed="false">
                                                    <svg class="action-icons" viewBox="0 0 32 32" aria-hidden="true" focusable="false">
                                                        <path d="M24,2V1c0-0.6-0.4-1-1-1s-1,0.4-1,1v1H10V1c0-0.6-0.4-1-1-1S8,0.4,8,1v1C4.7,2,2,4.7,2,8v16c0,3.3,2.7,6,6,6h16c3.3,0,6-2.7,6-6V8C30,4.7,27.3,2,24,2z M8,4v1c0,0.6,0.4,1,1,1s1-0.4,1-1V4h12v1c0,0.6,0.4,1,1,1s1-0.4,1-1V4c2.2,0,4,1.8,4,4v2H4V8C4,5.8,5.8,4,8,4z M24,28H8c-2.2,0-4-1.8-4-4V12h24v12C28,26.2,26.2,28,24,28z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <!-- <div class="ml-2" role="button">
                                                <svg class="action-icons" viewBox="0 0 32 32" aria-hidden="true" focusable="false">
                                                    <path d="M16,18c-4.4,0-8-3.6-8-8s3.6-8,8-8s8,3.6,8,8S20.4,18,16,18z M16,4c-3.3,0-6,2.7-6,6s2.7,6,6,6s6-2.7,6-6S19.3,4,16,4z M29,32c-0.6,0-1-0.4-1-1v-4.2c0-2.6-2.2-4.8-4.8-4.8H8.8C6.2,22,4,24.2,4,26.8V31c0,0.6-0.4,1-1,1s-1-0.4-1-1v-4.2C2,23,5,20,8.8,20h14.4c3.7,0,6.8,3,6.8,6.8V31C30,31.6,29.6,32,29,32z"></path>
                                                </svg>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                                <div class="mt-2 addsubtask" data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg" data-id="{{$ongoingTask->id}}" onclick="addSubTask(this)">
                                    <button data-id="{{$ongoingTask->id}}" class="btn btn-outline-light btn-md p-1 px-2 rounded-3" style="border:none ;color:#495057">
                                        <span data-id="{{$ongoingTask->id}}" class=""><i class="fa fa-plus" style="color:#495057"></i></span>
                                        <span data-id="{{$ongoingTask->id}}" class="">
                                            &nbsp;Add subtask
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- end task card -->
                @endforeach

            </div>

            <div class="text-center d-grid">
                <a href="javascript: void(0);" class="btn btn-primary waves-effect waves-light addtask-btn" data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg" data-id="#inprogress-task"><i class="mdi mdi-plus me-1"></i> Add New</a>
            </div>
        </div>
    </div>
</div>
</div>
<!-- end col -->

<div class="col-lg-4">
    <div class="card">
        <div class="card-body">
            <!-- <div class="dropdown float-end">
                    <a href="#" class="dropdown-toggle arrow-none" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-dots-vertical m-0 text-muted h5"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="#">Edit</a>
                        <a class="dropdown-item" href="#">Delete</a>
                    </div>
                </div>  -->
            <!-- end dropdown -->

            <h4 class="card-title mb-4">Completed</h4>
            <div id="task-3">
                <div id="complete-task" class="pb-1 task-list">
                    @foreach ($completedTasks as $completedTask)
                    <div class="task" id="task-cards-{{$completedTask->id}}">
                        <div class="card task-box" id="{{$completedTask->id}}" onclick="showFixedContent(event,'{{ json_encode($completedTask)}}')">
                            <div class="card-body">
                                <div class="mb-2 actions">
                                    <div class="dropdown float-end">
                                        <a href="#" class="dropdown-toggle arrow-none" data-bs-toggle="dropdown" aria-expanded="false" onclick="stopPropagation(event)">
                                            <i class="mdi mdi-dots-vertical m-0 text-muted h5"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item edittask-details" href="#" id="taskedit" data-id="#cmptask-1" data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg">Edit</a>
                                            <a class="dropdown-item deletetask" href="#" data-id="#cmptask-1" onclick='deleteTask(event,"{{$completedTask->id}}")'>Delete</a>
                                        </div>
                                    </div> <!-- end dropdown -->
                                    <div class="float-end ml-2">
                                        <span class="badge rounded-pill badge-soft-success font-size-12">Complete</span>
                                    </div>
                                    <div>
                                        <h5 class="font-size-15"><a href="javascript: void(0);" class="text-dark">{{$completedTask->text}}</a></h5>
                                        <p class="text-muted mb-4">{{$completedTask->baseline_start}}</p>
                                    </div>

                                    <div class="row justify-content-between align-items-center overflow-hidden">
                                        <div class="avatar-group col-auto task-assigne align-items-center text-nowrap " style="flex-wrap: unset;">
                                            {{--@forelse ($completedTask->assignees as $assignee)
                                            <div class="avatar-group-item">
                                                <a href="javascript: void(0);" class="d-inline-block" value="member-1">
                                                    <img src="{{ $assignee->avatar_url()}}" alt="" class="rounded-circle avatar-xs">
                                            </a>
                                        </div>
                                        @empty
                                        <div class="mx-n2" role="button">
                                            <svg class="action-icons" style="width: 32px;padding:5px" viewBox="0 0 32 32" aria-hidden="true" focusable="false">
                                                <path d="M16,18c-4.4,0-8-3.6-8-8s3.6-8,8-8s8,3.6,8,8S20.4,18,16,18z M16,4c-3.3,0-6,2.7-6,6s2.7,6,6,6s6-2.7,6-6S19.3,4,16,4z M29,32c-0.6,0-1-0.4-1-1v-4.2c0-2.6-2.2-4.8-4.8-4.8H8.8C6.2,22,4,24.2,4,26.8V31c0,0.6-0.4,1-1,1s-1-0.4-1-1v-4.2C2,23,5,20,8.8,20h14.4c3.7,0,6.8,3,6.8,6.8V31C30,31.6,29.6,32,29,32z"></path>
                                            </svg>
                                        </div>
                                        @endforelse--}}

                                        <label class="input-group-btn mb-0 main-task-date-label mx-2" style="visibility: {{$completedTask->deadline ? 'hidden':'visible'}}" onclick="clickDate(event)">
                                            <div role=" button" tabindex="0" class="mx-1" aria-disabled="false" aria-pressed="false">
                                                <svg class="action-icons" style="width: 32px;padding:7px" viewBox="0 0 32 32" aria-hidden="true" focusable="false">
                                                    <path d="M24,2V1c0-0.6-0.4-1-1-1s-1,0.4-1,1v1H10V1c0-0.6-0.4-1-1-1S8,0.4,8,1v1C4.7,2,2,4.7,2,8v16c0,3.3,2.7,6,6,6h16c3.3,0,6-2.7,6-6V8C30,4.7,27.3,2,24,2z M8,4v1c0,0.6,0.4,1,1,1s1-0.4,1-1V4h12v1c0,0.6,0.4,1,1,1s1-0.4,1-1V4c2.2,0,4,1.8,4,4v2H4V8C4,5.8,5.8,4,8,4z M24,28H8c-2.2,0-4-1.8-4-4V12h24v12C28,26.2,26.2,28,24,28z"></path>
                                                </svg>
                                            </div>
                                        </label>
                                        <input value="{{$completedTask->deadline}}" type="text" class="date-input bg-transparent border-0 main-task-date-input mx-n5" name="deadline" data-taskid="{{$completedTask->id}}" readonly="readonly" role="button" onclick="stopPropagation(event)" onchange="updateAttribute(event)" @if($completedTask->deadline) value="{{date('D, d F Y',strtotime($completedTask->deadline))}}" @endif/>
                                    </div>

                                    @if(count($completedTask->subTasks))
                                    <div class="col-auto p-0 mt-1 toggle-sub-task" onclick="showSubTask(event)">
                                        <span class="btn btn-outline-light btn-sm rounded-3 p-1 border-none" role="button" aria-label="Expand" tabindex="0">
                                            <span class="mx-1">{{count($completedTask->subTasks)}}</span>
                                            <svg class="" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                                <path d="M20,15c-1.9,0-3.4,1.3-3.9,3H7c-2.8,0-5-2.2-5-5v-3h14.1c0.4,1.7,2,3,3.9,3c2.2,0,4-1.8,4-4s-1.8-4-4-4 c-1.9,0-3.4,1.3-3.9,3H2V3c0-0.6-0.4-1-1-1S0,2.4,0,3v10c0,3.9,3.1,7,7,7h9.1c0.4,1.7,2,3,3.9,3c2.2,0,4-1.8,4-4S22.2,15,20,15z M20,7c1.1,0,2,0.9,2,2s-0.9,2-2,2s-2-0.9-2-2S18.9,7,20,7z M20,21c-1.1,0-2-0.9-2-2s0.9-2,2-2s2,0.9,2,2S21.1,21,20,21z"></path>
                                            </svg>
                                            <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                                <path class="arrow arrow-left" d="M17.5,10.7l-7.1-7.1C10,3.2,9.4,3,8.8,3.3c-0.6,0.2-1,0.8-1,1.4v14.9c0,0.6,0.4,1.2,1,1.4c0.2,0.1,0.4,0.1,0.6,0.1c0.4,0,0.8-0.2,1.1-0.5l7.1-7.1c0.4-0.4,0.6-0.9,0.6-1.5S17.9,11.1,17.5,10.7z"></path>
                                                <path class="arrow arrow-down" style="display: none;" d="M20.9,9c-0.2-0.6-0.8-1-1.4-1h-15C3.9,8,3.4,8.4,3.1,9C2.9,9.5,3,10.2,3.5,10.6l7.1,7.1c0.4,0.4,0.9,0.6,1.5,0.6c0.5,0,1.1-0.2,1.5-0.6l7.1-7.1C21,10.2,21.1,9.5,20.9,9z"></path>
                                            </svg>
                                        </span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="subtasks mt-2 col-md-12 overflow-hidden" style="max-height:0;">
                                @foreach ($completedTask->subTasks as $subTask)
                                <div class="subtask-name d-flex justify-content-between align-items-center p-0">
                                    <div class="d-flex align-items-center" role="button" style="max-width:60%;">
                                        <div class="">
                                            <svg style="width:14px" class="border border-dark rounded-circle bg-transparent" viewBox="0 0 32 32" aria-hidden="true" focusable="false">
                                                <path style="fill:transparent" d="M31,16c0,8.3-6.7,15-15,15S1,24.3,1,16S7.7,1,16,1S31,7.7,31,16z"></path>
                                                <path d="M13.4,22.1c-0.3,0-0.5-0.1-0.7-0.3l-3.9-3.9c-0.4-0.4-0.4-1,0-1.4s1-0.4,1.4,0l3.1,3.1l8.1-8.1c0.4-0.4,1-0.4,1.4,0   s0.4,1,0,1.4l-8.9,8.9C13.9,22,13.7,22.1,13.4,22.1z"></path>
                                            </svg>
                                        </div>
                                        <div class="" style="margin-left: 4px;z-index:1">
                                            <div onclick="showFixedContent(event,'{{ json_encode($subTask)}}')" style="white-space: nowrap;text-overflow:ellipsis;overflow:hidden;">{{$subTask->text}}</div>
                                        </div>
                                    </div>
                                    <div class="sub-task-actions">
                                        <div class="d-flex" style="z-index:2;margin-left:2px;white-space: nowrap;">
                                            <div class="" style="margin-right:;">
                                                <div role="button" tabindex="0" class="DeprecatedCircularButton DeprecatedCircularButton--enabled DeprecatedCircularButton--small DueDateContainer-button DueDateContainer-button--circular" aria-disabled="false" aria-pressed="false">
                                                    <svg class="action-icons" viewBox="0 0 32 32" aria-hidden="true" focusable="false">
                                                        <path d="M24,2V1c0-0.6-0.4-1-1-1s-1,0.4-1,1v1H10V1c0-0.6-0.4-1-1-1S8,0.4,8,1v1C4.7,2,2,4.7,2,8v16c0,3.3,2.7,6,6,6h16c3.3,0,6-2.7,6-6V8C30,4.7,27.3,2,24,2z M8,4v1c0,0.6,0.4,1,1,1s1-0.4,1-1V4h12v1c0,0.6,0.4,1,1,1s1-0.4,1-1V4c2.2,0,4,1.8,4,4v2H4V8C4,5.8,5.8,4,8,4z M24,28H8c-2.2,0-4-1.8-4-4V12h24v12C28,26.2,26.2,28,24,28z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <!-- <div class="ml-2" role="button">
                                                <svg class="action-icons" viewBox="0 0 32 32" aria-hidden="true" focusable="false">
                                                    <path d="M16,18c-4.4,0-8-3.6-8-8s3.6-8,8-8s8,3.6,8,8S20.4,18,16,18z M16,4c-3.3,0-6,2.7-6,6s2.7,6,6,6s6-2.7,6-6S19.3,4,16,4z M29,32c-0.6,0-1-0.4-1-1v-4.2c0-2.6-2.2-4.8-4.8-4.8H8.8C6.2,22,4,24.2,4,26.8V31c0,0.6-0.4,1-1,1s-1-0.4-1-1v-4.2C2,23,5,20,8.8,20h14.4c3.7,0,6.8,3,6.8,6.8V31C30,31.6,29.6,32,29,32z"></path>
                                                </svg>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                                <div class="mt-2 addsubtask" data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg" data-id="{{$completedTask->id}}" onclick="addSubTask(event)">
                                    <button data-id="{{$completedTask->id}}" class="btn btn-outline-light btn-md p-1 px-2 rounded-3" style="border:none ;color:#495057">
                                        <span data-id="{{$completedTask->id}}" class=""><i class="fa fa-plus" style="color:#495057"></i></span>
                                        <span data-id="{{$completedTask->id}}" class="">
                                            &nbsp;Add subtask
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end task card -->
                @endforeach

            </div>

            <div class="text-center d-grid">
                <a href="javascript: void(0);" class="btn btn-primary waves-effect waves-light addtask-btn" data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg" data-id="#complete-task"><i class="mdi mdi-plus me-1"></i> Add New</a>
            </div>
        </div>
    </div>
</div>
</div>
<!-- end col -->
</div>
<!-- end row -->

@include('tenant.kanban-tasks.task-details-view')
@include('tenant.kanban-tasks.create-modal')
@endsection
@section('script')
@include('tenant.kanban-tasks.task-details-script')
<!-- dragula plugins -->
<script src="{{ URL::asset('/assets/libs/dragula/dragula.min.js') }}"></script>

<!-- jquery-validation -->
<script src="{{ URL::asset('/assets/libs/jquery-validation/jquery-validation.min.js') }}"></script>

<!-- date-picker -->
<script src="{{ URL::asset('/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.3/js/bootstrap-select.min.js"></script> -->


<!-- drag-drop -->
<script src="{{ URL::asset('/assets/js/pages/task-kanban.init.js') }}"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script> -->

<!-- <script src="{{ URL::asset('/assets/js/pages/task-form.init.js') }}"></script> -->

@include('tenant.kanban-tasks.create-task-script')
@include('tenant.kanban-tasks.sub-tasks-script')



<script>




</script>

@endsection