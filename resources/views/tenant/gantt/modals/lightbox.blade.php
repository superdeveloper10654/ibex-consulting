<div class="modal" tabindex="-1" id="lightboxModal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="taskModalTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="onCloseTaskModal()"></button>
{{--                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
            </div>
            <div class="modal-body">
                <div class="card" style="-webkit-box-shadow: none; box-shadow: none;">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6" id="id_sel">
                                <label for="typeSel" class="form-label">Type</label>
                                <select id="typeSel" class="form-select" aria-label="Type" onchange="onSelectChange()">
                                    <option value="task" selected>Task</option>
                                    <option value="project">Project</option>
                                    <option value="milestone">Milestone</option>
                                </select>
                            </div>
                            <div class="col-md-6"id="id_color">
                                <label for="colorCpk" class="form-label">Colour</label>
                                <button id="colorCpk" class="form-select" style='height: 36px;' onclick="colorPopup.show('colorCpk', {centering: false})"></button>
                            </div>
                        </div>
                        <div class="row mb-3 pb-3 border-bottom" id="id_name">
                            <div class="col-md-12">
                                <label for="nameInp" class="form-label">Name</label>
                                <input type="text" class="form-control" id="nameInp">
                            </div>
                        </div>
                 
                        <div class="row mb-3" id="id_calendar">
                            <div class="col-md-12">
                                <label for="calendarSel" class="form-label">Calendar</label>
                                <select id="calendarSel" class="form-select" aria-label="Calendar">
                                @foreach ($data['calendars'] as $calendar)
                                    @if ($calendar->type == 1)
                                    <option value="{{ $calendar->id }}">{{ $calendar->name }}</option>
                                    @endif
                                @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3" id="id_schedule">
                            <div class="col-md-12">
                                <label for="scheduleInp" class="form-label">Schedule</label>
                                <div class="input-group">
                                    <input id="scheduleInp" class="form-control" readonly onfocus="schedulePopup.show('scheduleInp', {centering: false})" />
                                    <span class="input-group-text" id="basic-addon2" onclick="schedulePopup.show('scheduleInp', {centering: false})">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3 pb-3 border-bottom" id="id_baseline">
                            <div class="col-md-12">
                                <label for="baselineInp" class="form-label">Baseline</label>
                                <div class="input-group">
                                    <input id="baselineInp" class="form-control" readonly onfocus="baselinePopup.show('baselineInp', {centering: false})" />
                                    <span class="input-group-text" id="basic-addon2" onclick="baselinePopup.show('baselineInp', {centering: false})">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3" id="id_resourcegroup">
                            <div class="col-md-12">
                                <label for="resourceGroupSel" class="form-label">Resource Group</label>
                                <select id="resourceGroupSel" class="form-select" aria-label="Group"></select>
                            </div>
                        </div>
                        <div class="row mb-3 pb-3 border-bottom" id="id_resourceitem">
                            <div class="col-md-12">
                                <label for="resourceItemsSel" class="form-label">Resource Items</label>
                                <select id="resourceItemsSel" class="form-select" aria-label="Resource"></select>
                            </div>
                        </div>
                        <div class="row mb-3 pb-3 border-bottom" id="id_progress">
                            <div class="col-md-12">
                                <label for="progressSld" class="form-label">Progress</label>
                                <div class="form-control pt-3 pb-3 ps-4 pe-4">
                                    <div id="progressSld"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3" id="id_image">
                            <div class="col-md-12">
                                <label for="taskimageupload" class="form-label">Images</label>
                                <div class ="mb-b text-center">
                                    <input id="taskimageupload" class="btn btn-light btn-rounded w-100 waves-effect waves-light" type="file" name="taskimageupload" />
                                    <button type="button" id="taskuploadbutton" class="btn btn-sm btn-primary btn-rounded waves-effect waves-light w-md mt-2" type="submit" style="display: none"><i class="mdi mdi-file-upload-outline font-size-16 align-middle"></i> Upload</button>
                                </div>
                                <div id="photo_gallery"></div>
                            </div>
                        </div>
                        <div class="row mb-3" style="display: none;">
                            <input id="id_new">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer ps-5 pe-5">
                <div class="flex-grow-1">
                    <button type="button" id="btn_del" class="btn btn-danger btn-rounded w-md waves-effect waves-light" onclick="deleteCurrTask()"><i class="mdi mdi-trash-can-outline"></i> Delete</button>
                </div>
                <button type="button" class="btn btn-secondary btn-rounded w-md waves-effect waves-light" id="btn_close" onclick="onCloseTaskModal()"> Cancel</button>
                <button type="button" class="btn btn-success btn-rounded w-md waves-effect waves-light" onclick="saveTaskOnModal()"><i class="mdi mdi-check"></i> Save</button>
            </div>
        </div>
    </div>
</div>

<script>
    const dateFormat = "%d/%m/%Y";
    var progressSld = new dhx.Slider("progressSld", {
        min: 0,
        max: 100,
        step: 1,
        tick: 10,
        majorTick: 2,
        tickTemplate: t => t + '%'
    });
    var colorCpk = new dhx.Colorpicker(null, {
        grayShades: false,
        palette: [ //custom palette
            ["#299cb4", "#a7dbd8", "#e0e4cc", "#f38630", "#fa6900", "#7fc7af", "#dad8a7"],
            ["#fe4365", "#fc9d9a", "#f9cdad", "#c8c8a9", "#83af9b", "#948c75", "#d5ded9"],
            ["#ecd078", "#d95b43", "#c02942", "#542437", "#53777a", "#cbe86b", "#f2e9e1"],
            ["#556270", "#4ecdc4", "#c7f464", "#ff6b6b", "#c44d58", "#dce9be", "#555152"],
            ["#774f38", "#e08e79", "#f1d4af", "#ece5ce", "#c5e0dc", "#005f6b", "#008c9e"],
            ["#e8ddcb", "#cdb380", "#036564", "#033649", "#031634", "#73626e", "#b38184"],
            ["#490a3d", "#bd1550", "#e97f02", "#f8ca00", "#8a9b0f", "#fc913a", "#f9d423"],
            ["#594f4f", "#547980", "#45ada8", "#9de0ad", "#e5fcc2", "#fecea8", "#ff847c"],
            ["#69d2e7", "#6a4a3c", "#cc333f", "#eb6841", "#edc951", "#80bca3", "#f6f7bd"],
            ["#e94e77", "#d68189", "#c6a49a", "#c6e5d9", "#f4ead5", "#40c0cb", "#f9f2e7"]
        ]
    });
    colorCpk.events.on("change", function(color) {
        $('#colorCpk').css('backgroundColor', color);
        colorPopup.hide();
    });
    const colorPopup = new dhx.Popup();
    colorPopup.attach(colorCpk);

    let scheduleCal1, scheduleCal2;

    function setScheduleValue(closable) {
        $('#scheduleInp').val(`${scheduleCal1.getValue()} - ${scheduleCal2.getValue()}`);
        if (closable && scheduleCal1.getValue() != '') {
            schedulePopup.hide();
        }
    }
    const schedulePopup = new dhx.Popup();
    schedulePopup.attachHTML(`<div style="display: flex;">
			<div id="scheduleCal1"></div>
<!--			<div id="scheduleCal2"></div>-->
		</div>`);
    schedulePopup.events.on("afterShow", function() {
        if (!scheduleCal1) {
            scheduleCal1 = new dhx.Calendar("scheduleCal1");
            scheduleCal1.config.dateFormat = dateFormat;
            scheduleCal1.events.on("change", (date, oldDate, byClick) => {
                if (byClick) {
                    setScheduleValue(false);
                }
            });
            scheduleCal2 = new dhx.Calendar("scheduleCal2");
            scheduleCal2.config.dateFormat = dateFormat;
            scheduleCal2.events.on("change", (date, oldDate, byClick) => {
                if (byClick) {
                    setScheduleValue(true)
                }
            });
            scheduleCal1.link(scheduleCal2);
        }
        let [sdate, edate] = $('#scheduleInp').val().split(' - ');
        scheduleCal1.setValue(sdate);
        scheduleCal2.setValue(edate);
    });


    let baselineCal1, baselineCal2;

    function setBaselineValue(closable) {
        $('#baselineInp').val(`${baselineCal1.getValue()} - ${baselineCal2.getValue()}`);
        if (closable && baselineCal1.getValue() != '') {
            baselinePopup.hide();
        }
    }
    const baselinePopup = new dhx.Popup();
    baselinePopup.attachHTML(`<div style="display: flex;">
			<div id="baselineCal1"></div>
<!--			<div id="baselineCal2"></div>-->
		</div>`);
    baselinePopup.events.on("afterShow", function() {
        if (!baselineCal1) {
            baselineCal1 = new dhx.Calendar("baselineCal1");
            baselineCal1.config.dateFormat = dateFormat;
            baselineCal1.events.on("change", (date, oldDate, byClick) => {
                if (byClick) {
                    setBaselineValue(false);
                }
            });
            baselineCal2 = new dhx.Calendar("baselineCal2");
            baselineCal2.config.dateFormat = dateFormat;
            baselineCal2.events.on("change", (date, oldDate, byClick) => {
                if (byClick) {
                    setBaselineValue(true);
                }
            });
            baselineCal1.link(baselineCal2);
        }
        let [sdate, edate] = $('#baselineInp').val().split(' - ');
        baselineCal1.setValue(sdate);
        baselineCal2.setValue(edate);
    });
    function onSelectChange() {
        var isNew = $("#id_new").val();
        if (isNew == 1) {
            if ($("#typeSel").val() == 'task') {
                $("#id_color").show();
                $("#id_name").show();
                $("#id_calendar").show();
                $('#id_schedule').show();
                $('#id_baseline').hide();
                $('#id_resourcegroup').hide();
                $('#id_resourceitem').hide();
                $("#id_progress").hide();
                $("#id_image").show();
                $("#btn_close").show();
            } else if ($("#typeSel").val() == 'project') {
                $("#id_color").hide();
                $("#id_name").show();
                $("#id_calendar").show();
                $('#id_schedule').show();
                $('#id_baseline').hide();
                $('#id_resourcegroup').hide();
                $('#id_resourceitem').hide();
                $("#id_progress").hide();
                $("#id_image").show();
                $("#btn_close").show();
                $("#taskModalTitle").html($("#typeSel").val().toUpperCase());
            } else {
                $("#id_color").hide();
                $("#id_name").show();
                $("#id_calendar").show();
                $('#id_schedule').show();
                $('#id_baseline').hide();
                $('#id_resourcegroup').hide();
                $('#id_resourceitem').hide();
                $("#id_progress").hide();
                $("#id_image").show();
                $("#btn_close").show();
                $("#taskModalTitle").html($("#typeSel").val().toUpperCase());
            }
        }
        $("#taskModalTitle").html($("#typeSel").val().toUpperCase());
    }

    function onCloseTaskModal() {
        $("#lightboxModal").modal('hide');
        gantt.clearAll();
        gantt.load("{{ t_route('api.data', ':id') }}".replace(':id', programme.id));
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

    var loadURL = "{{ t_route('api.data', ':id') }}";
    var resourceURL = "{{ t_route('GetResources') }}";
</script>
