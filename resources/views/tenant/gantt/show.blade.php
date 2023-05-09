@extends('tenant.layouts.master')
@section('title')
    @lang('Programme')
@endsection

@push('css')
    <link href="{{ URL::asset('assets/gantt-new/dhtmlxgantt.css?v=8.0') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/gantt/dhx_file_dnd.css?v=8.0') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/suite.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/css/caleran.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/css/gantt.css') }}" rel="stylesheet" />
    <style>
        .gantt-fullscreen {
            position: absolute;
            bottom: 20px;
            right: 20px;
            width: 30px;
            height: 30px;
            padding: 2px;
            font-size: 32px;
            background: transparent;
            cursor: pointer;
            opacity: 0.5;
            text-align: center;
            -webkit-transition: background-color 0.5s, opacity 0.5s;
            transition: background-color 0.5s, opacity 0.5s;
        }

        .gantt-fullscreen:hover {
            background: rgba(150, 150, 150, 0.5);
            opacity: 1;
        }

        .roll-active {
            background-color: lightblue;
        }
    </style>
}
@endpush

@section('content')
    <x-resource.breadcrumb :resource="$data['programme']" :title="'Programme ' . $data['programme']->name . ' gantt'" />

    <script src="{{ URL::asset('assets/gantt/dhtmlx.js') }}"></script>
    <script src="{{ URL::asset('assets/gantt/ext/dhtmlxgantt.js?v=8.0') }}"></script>
    <script src="https://export.dhtmlx.com/gantt/api.js?v=8.0"></script>
    <script src="{{ URL::asset('assets/gantt-new/resource/common/jquery_multiselect.js?v=8.0') }}"></script>
    <script src="{{ URL::asset('assets/gantt/ext/dhtmlxgantt_auto_scheduling.js?v=8.0') }}"></script>
    <script src="{{ URL::asset('assets/gantt/ext/dhtmlxgantt_undo.js?v=8.0') }}"></script>
    <script src="{{ URL::asset('assets/gantt/ext/dhx_file_dnd.js?v=8.0') }}"></script>
    <script src="{{ URL::asset('assets/js/suite.min.js') }}"></script>

    @if (isPaidSubscription())
        <a href="{{ t_route('addkanbantask', Crypt::encryptString($data['programme']->id)) }}">
            <i class="fa fa-retweet text-black mx-2" data-toggle="tooltip" title="Switch to Kanban Board"></i>
        </a>
    @endif

    <div class="card animated-slow mb-0">
        <div class="card-body py-0">
            <div class="navbar-header">
                <div class="text-center d-flex">
                    <div class="dropdown">
                        <button data-bs-toggle="dropdown"
                            class="dropdown-toggle btn btn-outline btn-rounded waves-effect waves-light mx-1">
                            Zoom<i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                        </button>
                        <ul class="dropdown-menu" id="gantt-zoom-container">
                            <li>
                                <a class="dropdown-item" onclick="zoom_in();" href="#">
                                    <i class="bx bx-zoom-in font-size-16 align-middle text-muted"></i> In
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" onclick="zoom_out();" href="#">
                                    <i class="bx bx-zoom-out font-size-16 align-middle text-muted"></i> Out
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" onclick="zoomToFit();" href="#">
                                    <i class="bx bx-zoom-out font-size-16 align-middle text-muted"></i> Fit
                                </a>
                            </li>
                            <div class="dropdown-divider"></div>
                        </ul>
                    </div>
                    <div class="dropdown">
                        <button data-bs-toggle="dropdown"
                            class="dropdown-toggle btn btn-outline btn-rounded waves-effect waves-light mx-1">
                            Display<i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" type="button" onclick="updateCriticalPath(this)">
                                    <i class="mdi mdi-lightning-bolt font-size-16 align-middle"></i> Critical Path
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" type="button" onclick="toggleSlack(this)">
                                    <i class="mdi mdi-sail-boat font-size-16 align-middle"></i>
                                    Float
                                </a>
                            </li>
                            <div class="dropdown-divider"></div>
                            <li>
                                <a class="dropdown-item" type="button" id="baselinePath">
                                    <div style="display: inline-block;border-radius: 2px; opacity: 0.6; height: 8px; width: 15px; margin-right: 4px; background: #f90;"></div>
                                    <div style="display: inline-block;">Hide Baseline</div>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" type="button" id="baselineReset">
                                    <div style="display: inline-block;border-radius: 2px; opacity: 0.6; height: 8px; width: 15px; margin-right: 4px; background: #f90;"></div>
                                    <div style="display: inline-block;">Reset Baseline</div>
                                </a>
                            </li>
                            <div class="dropdown-divider"></div>
                            <li><a class="dropdown-item" type="button" onclick="openganttmodel(this)"><i class="bx bx-columns font-size-16 align-middle"></i> Gantt columns</a>
                            </li>
                            <li><a class="dropdown-item" type="button" onclick="ganttresourcemodel(this)"><i class="bx bx-columns font-size-16 align-middle"></i> Resource columns</a></li>
                            <div class="dropdown-divider"></div>
                            <li><a class="dropdown-item" type="button" onclick="Daterange(this)"><i class="mdi mdi-calendar-clock font-size-16 align-middle"></i> Visible date range</a>
                            </li>
                        </ul>
                    </div>
                    <button type="button" onclick="showactivity()"
                        class="btn btn-outline btn-rounded waves-effect waves-light mx-1 activity">
                        <i class="mdi mdi-pulse"></i> Activity
                    </button>
                </div>

                <div class="d-flex dropdown">
                    <button type="button" onclick="showCalendarModal(this)"
                        class="btn btn-outline btn-rounded waves-effect waves-light mx-1">
                        <i class="mdi mdi-calendar-month"></i> Calendars
                    </button>
                    <button type="button" onclick="showResourceModal(this)"
                        class="btn btn-outline btn-rounded waves-effect waves-light mx-1 activity">
                        <i class="mdi mdi-excavator"></i> Resources
                    </button>
                    <div class="dropdown">
                        <button data-bs-toggle="dropdown"
                            class="dropdown-toggle btn btn-outline btn-rounded waves-effect waves-light mx-1">
                            Data<i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                              <a class="dropdown-item" onclick="showImportMPPModal(this)" href="#"><i class="mdi mdi-file-upload-outline font-size-16 align-middle"></i> Import from Microsoft Project Or XML</a>
                            </li>
                            <li>
                              <a class="dropdown-item" onclick="gantt.exportToMSProject({skip_circular_links: false})" href="#"><i class="mdi mdi-file-upload-outline font-size-16 align-middle"></i> Export to XML</a>
                            </li>
                          {{-- <li>
                              <a class="dropdown-item" onclick="showImportPrimaveraModal(this)" href="#"><i class="mdi mdi-file-upload-outline font-size-16 align-middle"></i> Import from Primavera P6</a>
                          </li> --}}
                          <div class="dropdown-divider"></div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card animated-slow">
        <div class="card-body animated-slow py-0 ps-0">
            <div class="row">
                <div id="gantt_here" style='width:100%; height:calc(100vh - 320px);'></div>
                <div id="activity" style="display: none;">
                    <div class="inner-activity-wrapper">
                        <div class="activitySideWrapper">
                            <div class="activity-header">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between"
                                    style="padding: 0;">
                                    <h4 class="mb-sm-0 font-size-18">Activity</h4>
                                </div>
                                <div class="activity-action">
                                    <button type="button" class="close" id="gantt-activity-close"><i
                                            class="mdi mdi-close noti-icon h4 m-0"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="activityDetailList" id="showactivitydata">
                    </div>
                    <div class="activitySearchBox">
                        <input type="text" id="activitySearchField" class="form-control" placeholder="Search">
                    </div>
                    <div id="output"></div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="user_id" value="{{ t_profile()->id }}" />
    <input type="hidden" id="user_name" value="{{ t_profile()->name }}" />

    @include('tenant.gantt.modals.add-resources')
    @include('tenant.gantt.modals.lightbox')
    @include('tenant.gantt.modals.gantt-columns')
    @include('tenant.gantt.modals.resource-columns')
    @include('tenant.gantt.modals.date-range')
    @include('tenant.gantt.modals.calendars')
    @include('tenant.gantt.modals.import-microsoft-project')
    @include('tenant.gantt.modals.import-primavera-p6')
    @include('tenant.gantt.modals.link-model')
@endsection

@section('script')
    <script src="{{ URL::asset('assets/js/pages/gantt-fn.js') . '?v=' . filemtime(public_path('assets/js/pages/gantt-fn.js')) }}"></script>
    <script src="{{ URL::asset('assets/js/pages/gantt-conf.js') . '?v=' . filemtime(public_path('assets/js/pages/gantt-conf.js')) }}"></script>
    <script src="{{ URL::asset('assets/js/pages/gantt.js') . '?v=' . filemtime(public_path('assets/js/pages/gantt.js')) }}"></script>

    <script>
        const token = "{{ csrf_token() }}";
        const saveUrl = "{{ t_route('task.save', '?') }}";
        const imageUrl = "{{URL::asset('assets/images/programmes_photo/')}}";
        const programme = {!! json_encode($data['programme']) !!};
        const resources = {!! json_encode($data['resources']) !!};
        const calendars = {!! json_encode($data['calendars']) !!};
        const columns = {!! json_encode($data['columns']) !!};
        const groups = {!! json_encode($data['group']) !!};
        const contract_key_date_name = {!! json_encode($data['contract_key_date_name']) !!};
        const contract_key_date = {!! json_encode($data['contract_key_date']) !!};
        const image_type = [
            "jpg", "JPG",
            "jpeg", "JPEG",
            "jfif", "JFIF",
            "pjpeg", "PJPEG",
            "pjp", "PJP",
            "png", "PNG",
            "svg", "SVG",
            "webp", "WEBP","WebP"
        ];
        const route = {
            'api.link' : '{{ t_route("api.link") }}'
        }
    </script>

    <script>
        window.ibex_gantt_config = {
            currentZoomLevel: "day",
            testDTPicker: null,
            autoSchedulerRunning: false,
            filterType: 1,
            filterValue: "",
            resourceConfig: null,
            activeCalendarOverrides: [],
            calendarOverrides: {!! json_encode($data['calendar_overrides']) !!}
        };

        function linkTypeToString(linkType) {
			switch (linkType) {
				case gantt.config.links.start_to_start:
					return "Start to start";
				case gantt.config.links.start_to_finish:
					return "Start to finish";
				case gantt.config.links.finish_to_start:
					return "Finish to start";
				case gantt.config.links.finish_to_finish:
					return "Finish to finish";
				default:
					return ""
			}
		}

        gantt.plugins({
            tooltip: true,
            fullscreen: true
        });

        gantt.templates.quick_info_content = function(start, end, task) {
            return task.details || task.text;
        };

        gantt.attachEvent("onTemplatesReady", function () {
            var toggle = document.createElement("i");
            toggle.className = "fa fa-expand gantt-fullscreen";
            gantt.toggleIcon = toggle;
            gantt.$container.appendChild(toggle);
            toggle.onclick = function() {
                gantt.ext.fullscreen.toggle();
            };
        });

        gantt.attachEvent("onExpand", function () {
            var icon = gantt.toggleIcon;
            if (icon) {
                icon.className = icon.className.replace("fa-expand", "fa-compress");
            }

        });

        gantt.attachEvent("onCollapse", function () {
            var icon = gantt.toggleIcon;
            if (icon) {
                icon.className = icon.className.replace("fa-compress", "fa-expand");
            }
        });

        ganttFn.init(gantt);
        ganttConf.init(gantt);

        gantt.init("gantt_here");

        gantt.load("{{ t_route('api.data', ':id') }}".replace(':id', programme.id), function () {
            if(contract_key_date_name){
                for(var i = 0; i< contract_key_date.length; i++){
                    gantt.addTask({
                        text        : contract_key_date_name[i],
                        type        : "milestone",
                        start_date  : contract_key_date[i],
                        readonly    : true,
                        editable    : false,
                        color       : "#299794"
                    }, 0, i);
                }
            }
            let earliestStartDate = null;
            let latestEndDate = null;

            gantt.serialize().data.forEach(function( task, index ) {
                if (task['guid'] == null) {

                } else {
                    if (!earliestStartDate || task['start_date'] < earliestStartDate) {
                        earliestStartDate = task['start_date'];
                    }

                    if (!latestEndDate || task['end_date'] > latestEndDate) {
                        latestEndDate = task['end_date'];
                    }
                }
            });

            gantt.addTask({
                text        : "Project Duration",
                type        : "milestone",
                start_date  : latestEndDate,
                color       : "#299794"
            }, 0, gantt.serialize().data.length);
        });


        gantt.ext.tooltips.tooltipFor({
            selector: ".gantt_task_link",
            html: function (event, node) {
                var linkId = node.getAttribute(gantt.config.link_attribute);
                if (linkId) {
                    var link = gantt.getLink(linkId);
                    var from = gantt.getTask(link.source);
                    var to = gantt.getTask(link.target);

                    return [
                        "Dependency<br><b>" + linkTypeToString(link.type) + "</b><br>",
                        "From<br><b>" + from.text + "</b><br>",
                        "To<br><b>" + to.text + "</b>"
                    ].join("<br>");
                }
            }
        });

        gantt.ext.tooltips.tooltipFor({
            selector: ".gantt_cell",
            html: function(event, domElement){
                return event.target.innerHTML;
            }
        });

        gantt.templates.tooltip_text = function(start,end,task){
            return "<b>" + task.text + "</b><br><br>Start<br>" + gantt.templates.tooltip_date_format(start) + "<br><br>Finish<br>" + gantt.templates.tooltip_date_format(end);
        };

        gantt.ext.tooltips.tooltipFor({
            selector: ".gantt_grid_head_cell.gantt_grid_head_add.gantt_last_cell",
            html: function(event, domElement){
                return "Insert a new project";
            }
        });
        /* Not working - please check and fix */
        gantt.ext.tooltips.tooltipFor({
            selector: ".gantt_grid_data .gantt_add",
            html: function(event, domElement){
                return "Insert a new row";
            }
        });

        gantt.ext.tooltips.tooltipFor({
            selector: ".gantt_resource_marker",
            html: function(event, domElement){
                return event.target.innerHTML;
            }
        });

        //Import P6 File
        var fileDnDP6 = fileDragAndDrop();
        fileDnDP6.fileTypeMessage = "Only XER and XML files are supported!";
        fileDnDP6.dndFileTypeMessage = "Please try XER and XML project file.";
        fileDnDP6.dndHint = "Drop XER file into Gantt";
        fileDnDP6.mode = "primaveraP6";
        fileDnDP6.init(gantt.$container);

        function sendFileP6(file) {
            fileDnDP6.showUpload();
            uploadP6(file, function() {
                fileDnDP6.hideOverlay();
            })
        }

        function uploadP6(file, callback) {
            var fileExtension = file.name.split('.').pop().toLowerCase();

            if (fileExtension === 'xer') {
                gantt.importFromPrimaveraP6({
                    data: file,
                    callback: function(project) {
                        if (project) {
                            gantt.clearAll();
                            if (project.config.duration_unit) {
                                gantt.config.duration_unit = project.config.duration_unit;
                            }
                            for (var i = 0; i < project.data.data.length; i++) {
                                project.data.data[i].planned_start = project.data.data[i].start_date;
                                project.data.data[i].type = "project";
                                project.data.data[i].calendar_id = calendars[0].id;
                                project.data.data[i].resource_group_id = groups[0].id;
                                project.data.data[i].resource_id = resources[0].id;
                                gantt.addTask(project.data.data[i]);
                            }
                        }
                        if (callback) {
                            callback(project);
                        }
                    }
                });
            } else if (fileExtension === 'xml') {
                gantt.importFromMSProject({
                    data: file,
                    callback: function (project) {
                        if (project) {
                            gantt.clearAll();
                            if (project.config.duration_unit) {
                                gantt.config.duration_unit = project.config.duration_unit;
                            }
                            for (var i = 0; i < project.data.data.length; i++) {
                                project.data.data[i].planned_start = project.data.data[i].start_date;
                                project.data.data[i].type = "project";
                                project.data.data[i].calendar_id = calendars[0].id;
                                project.data.data[i].resource_group_id = groups[0].id;
                                project.data.data[i].resource_id = resources[0].id;
                                gantt.addTask(project.data.data[i]);
                            }
                        }
                        if (callback)
                            callback(project);
                    }
                });
            } else {
                alert('Unsupported file format');
            }
            $("#modal_import_primavera_p6").hide();
            $(".modal-backdrop").hide();
        }

        fileDnDP6.onDrop(sendFileP6);

        var form = document.getElementById("ImportPrimaveraP6");

        form.onsubmit = function(event) {
            event.preventDefault();
            var fileInput = document.getElementById("primaveraFile");
            if (fileInput.files[0])
                sendFileP6(fileInput.files[0]);
        };

        getParsedGroups("{{ t_route('GetResources') }}", programme.id, token).then(res => {
            gantt.$resourcesStore.parse(res.resources.map(i => ({
                id: i.id,
                text: i.name,
                parent: i.parent_id,
                unit_cost: i.unit_cost
            })));
            $('#resourceGroupSel').empty();
            $('#resourceItemsSel').empty();
            res['parent'].map(i => {
                $('#resourceGroupSel').append($("<option/>").attr("value", i.id).text(i.name));
            });
            res['child_parent'].map(i => {
                $('#resourceItemsSel').append($("<option/>").attr("value", i.id).text(i.name));
            });
        });

        function onCloseResourceModal() {
            $("#AddResourcesModel").modal('hide');
            gantt.clearAll();

            gantt.load("{{ t_route('api.data', ':id') }}".replace(':id', programme.id), function () {
                if(contract_key_date_name){
                    for(var i = 0; i< contract_key_date.length; i++){
                        gantt.addTask({
                            text        : contract_key_date_name[i],
                            type        : "milestone",
                            start_date  : contract_key_date[i],
                            readonly    : true,
                            editable    : false,
                            color       : "#299794"
                        }, 0, i);
                    }
                }
                let earliestStartDate = null;
                let latestEndDate = null;

                gantt.serialize().data.forEach(function( task, index ) {
                    if (task['guid'] == null) {

                    } else {
                        if (!earliestStartDate || task['start_date'] < earliestStartDate) {
                            earliestStartDate = task['start_date'];
                        }

                        if (!latestEndDate || task['end_date'] > latestEndDate) {
                            latestEndDate = task['end_date'];
                        }
                    }
                });

                gantt.addTask({
                    text        : "Project Duration",
                    type        : "milestone",
                    start_date  : latestEndDate,
                    color       : "#299794"
                }, 0, gantt.serialize().data.length);
            });
            getParsedGroups("{{ t_route('GetResources') }}", programme.id, token).then(res => {
                gantt.$resourcesStore.parse(res.resources.map(i => ({
                    id: i.id,
                    text: i.name,
                    parent: i.parent_id,
                    unit_cost: i.unit_cost
                })));
                $('#resourceGroupSel').empty();
                $('#resourceItemsSel').empty();
                res['parent'].map(i => {
                    $('#resourceGroupSel').append($("<option/>").attr("value", i.id).text(i.name));
                });
                res['child_parent'].map(i => {
                    $('#resourceItemsSel').append($("<option/>").attr("value", i.id).text(i.name));
                });
            });
        }

        $("#baselineReset").click(function () {
            gantt.serialize().data.forEach(function( task, index ) {
                if (task.guid != null) {
                    let currentTask = gantt.getTask(task.id);
                    currentTask.planned_start = currentTask.start_date;
                    currentTask.planned_end = currentTask.end_date;
                    gantt.refreshTask(currentTask.id);
                } else {
                    let currentTask = gantt.getTask(task.id);
                    gantt.deleteTask(task.id);
                }
            });
            myAjax("{{ t_route('programmes.gantt.import-tasks-from-microsoft-project', ':programme') }}".replace(':programme', programme.id), {
                tasks: gantt.serialize().data,
                links: gantt.serialize().links,
                type: "baseline"
            }).then(response => {
                gantt.clearAll();
                gantt.load("{{ t_route('api.data', ':id') }}".replace(':id', programme.id), function () {
                    if(contract_key_date_name){
                        for(var i = 0; i< contract_key_date.length; i++){
                            gantt.addTask({
                                text        : contract_key_date_name[i],
                                type        : "milestone",
                                start_date  : contract_key_date[i],
                                readonly    : true,
                                editable    : false,
                                color       : "#299794"
                            }, 0, i);
                        }
                    }
                    let earliestStartDate = null;
                    let latestEndDate = null;

                    gantt.serialize().data.forEach(function( task, index ) {
                        if (task['guid'] == null) {

                        } else {
                            if (!earliestStartDate || task['start_date'] < earliestStartDate) {
                                earliestStartDate = task['start_date'];
                            }

                            if (!latestEndDate || task['end_date'] > latestEndDate) {
                                latestEndDate = task['end_date'];
                            }
                        }
                    });

                    gantt.addTask({
                        text        : "Project Duration",
                        type        : "milestone",
                        start_date  : latestEndDate,
                        color       : "#299794"
                    }, 0, gantt.serialize().data.length);
                });
            });
        });

        $("#resource_calendars").hide();
        $("#linkId").hide();
    </script>

@endsection
