<div class="modal" tabindex="-1" id="linkModal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="linkModalTitle">LINK</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card" style="-webkit-box-shadow: none; box-shadow: none;">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6" id="source_name">
                                <label for="sourceName" class="form-label">Source</label>
                                <input id="sourceName" class="form-control" aria-label="Source" readonly>
                            </div>
                            <div class="col-md-6" id="target_name">
                                <label for="targetName" class="form-label">Target</label>
                                <input id="targetName" class="form-control" aria-label="Target" readonly>
                            </div>
                        </div>
                        <div class="row mb-3" id="type_sel">
                            <div class="col-md-12">
                                <label for="linkstypeSel" class="form-label">Type</label>
                                <select id="linkstypeSel" class="form-select" aria-label="Type" onchange="onChangeLinkType()">
                                    <option value="0">Finish - Start</option>
                                    <option value="1">Start - Start</option>
                                    <option value="2">Finish - Finish</option>
                                    <option value="3">Start - Finish</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3" id="link_start">
                            <div class="col-md-12">
                                <label for="linkStart" class="form-label">Link Start</label>
                                <div class="input-group">
                                    <input id="linkStart" class="form-control" readonly onfocus="linkStartPopup.show('linkStart', {centering: false})" />
                                    <span class="input-group-text" onclick="linkStartPopup.show('linkStart', {centering: false})">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3 pb-3 border-bottom" id="link_end">
                            <div class="col-md-12">
                                <label for="link_end" class="form-label">Link Finish</label>
                                <div class="input-group">
                                    <input id="linkEnd" class="form-control" readonly onfocus="linkEndPopup.show('linkEnd', {centering: false})" />
                                    <span class="input-group-text" onclick="linkEndPopup.show('linkEnd', {centering: false})">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input id="linkId">
            </div>
            <div class="modal-footer ps-5 pe-5">
                <div class="flex-grow-1">
                    <button type="button" id="btn_link_del" class="btn btn-danger btn-rounded w-md waves-effect waves-light"><i class="mdi mdi-trash-can-outline"></i> Delete</button>
                </div>
                <button type="button" class="btn btn-success btn-rounded w-md waves-effect waves-light" onclick="onUpdateLink()"><i class="mdi mdi-check"></i> Save</button>
            </div>
        </div>
    </div>
</div>

<script>
    const format = "%m/%d/%Y";
    let linkStartCal;
    function setLinkStartValue(closable) {
        $('#linkStart').val(`${linkStartCal.getValue()}`);
        if (closable && linkStartCal.getValue() != '') {
            linkStartPopup.hide();
        }
    }
    const linkStartPopup = new dhx.Popup();
    linkStartPopup.attachHTML(`
            <div style="display: flex;">
			    <div id="linkStartCal"></div>
		    </div>
        `);
    linkStartPopup.events.on("afterShow", function() {
        if (!linkStartCal) {
            linkStartCal = new dhx.Calendar("linkStartCal");
            linkStartCal.config.dateFormat = format;
            linkStartCal.events.on("change", (date, oldDate, byClick) => {
                if (byClick) {
                    setLinkStartValue(true);
                }
            });
        }
        let sdate = $("#linkStart").val();
        linkStartCal.setValue(new Date(sdate));
    });

    let linkEndCal;
    function setLinkEndValue(closable) {
        $('#linkEnd').val(`${linkEndCal.getValue()}`);
        if (closable && linkEndCal.getValue() != '') {
            linkEndPopup.hide();
        }
    }
    const linkEndPopup = new dhx.Popup();
    linkEndPopup.attachHTML(`
            <div style="display: flex;">
			    <div id="linkEndCal"></div>
		    </div>
        `);
    linkEndPopup.events.on("afterShow", function() {
        if (!linkEndCal) {
            linkEndCal = new dhx.Calendar("linkEndCal");
            linkEndCal.config.dateFormat = format;
            linkEndCal.events.on("change", (date, oldDate, byClick) => {
                if (byClick) {
                    setLinkEndValue(true);
                }
            });
        }
        let edate = $("#linkEnd").val();
        linkEndCal.setValue(new Date(edate));
    });

    function onUpdateLink() {
        gantt.getLink($("#linkId").val()).type = $("#linkstypeSel").val();
        let link = gantt.getLink($("#linkId").val());
        let sourceTask = gantt.getTask(link.source);
        let sourceDuration = gantt.calculateDuration(sourceTask);
        let targetTask = gantt.getTask(link.target);
        let targetDuration = gantt.calculateDuration(targetTask);
        if($("#linkstypeSel").val() == 0) {
            gantt.getTask(link.source).end_date = new Date($("#linkStart").val());
            gantt.getTask(link.source).start_date = new Date((gantt.getTask(link.source).end_date).getTime() - sourceDuration * 1000 * 3600 * 24);
            gantt.getTask(link.target).start_date = new Date($("#linkEnd").val());
            gantt.getTask(link.target).end_date = new Date((gantt.getTask(link.target).start_date).getTime() + targetDuration * 1000 * 3600 * 24);
        } else if($("#linkstypeSel").val() == 1) {
            gantt.getTask(link.source).start_date = new Date($("#linkStart").val());
            gantt.getTask(link.source).end_date = new Date((gantt.getTask(link.source).start_date).getTime() + sourceDuration * 1000 * 3600 * 24);
            gantt.getTask(link.target).start_date = new Date($("#linkEnd").val());
            gantt.getTask(link.target).end_date = new Date((gantt.getTask(link.target).start_date).getTime() + targetDuration * 1000 * 3600 * 24);
        } else if($("#linkstypeSel").val() == 2) {
            gantt.getTask(link.source).end_date = new Date($("#linkStart").val());
            gantt.getTask(link.source).start_date = new Date((gantt.getTask(link.source).end_date).getTime() - sourceDuration * 1000 * 3600 * 24);
            gantt.getTask(link.target).end_date = new Date($("#linkEnd").val());
            gantt.getTask(link.target).start_date = new Date((gantt.getTask(link.target).end_date).getTime() - targetDuration * 1000 * 3600 * 24);
        } else {
            gantt.getTask(link.source).start_date = new Date($("#linkStart").val());
            gantt.getTask(link.source).end_date = new Date((gantt.getTask(link.source).start_date).getTime() + sourceDuration * 1000 * 3600 * 24);
            gantt.getTask(link.target).end_date = new Date($("#linkEnd").val());
            gantt.getTask(link.target).start_date = new Date((gantt.getTask(link.target).end_date).getTime() - targetDuration * 1000 * 3600 * 24);
        }
        gantt.updateLink($("#linkId").val());
        gantt.updateTask(sourceTask.id);
        gantt.updateTask(targetTask.id);
        gantt.ajax.del({
            url: route['api.link'] + '/' + link.id,
            data: {
                id: link.id
            }
        }).then(function(response) {

        });
        gantt.ajax.post({
            url: route['api.link'],
            data: {
                source: link['source'],
                programme_id: programme.id,
                target: link['target'],
                type: link['type'],
                db_type: "linkDB",
                gantt_data: '',
                user_id: $('#user_id').val(),
            }
        }).then(function(response) {
            var res = JSON.parse(response.responseText);
            gantt.changeLinkId(id, res.tid);
            return true;
        });
        $("#linkModal").modal('hide');
        setTimeout(function () {
            let link = gantt.getLink($("#linkId").val());
            let tasksource = gantt.getTask(link['source']);
            let tasktarget = gantt.getTask(link['target']);
            const d = new Date();
            let activitydata = {
                _token: token,
                id: '',
                programme_id: programme.id,
                gantt_data: gantt.serialize(),
                primary_guid: link['source'],
                secondary_guid: link['target'],
                action_type: 'updated',
                type: 'link',
                info: 'Update ' + d.getFullYear() + '. ' + d.getMonth() + '. ' + d.getDate(),
                afterForm: '',
                testBefore: '',
                changeString: '',
                task_text: ''
            };
            saveActivity(activitydata);
        }, 2000);
    }

    function onChangeLinkType() {
        let link = gantt.getLink($("#linkId").val());
        if($("#linkstypeSel").val() == 0) {
            $("#linkStart").val(gantt.templates.task_date(gantt.getTask(link.source).end_date));
            $("#linkEnd").val(gantt.templates.task_date(gantt.getTask(link.target).start_date));
        } else if($("#linkstypeSel").val() == 1) {
            $("#linkStart").val(gantt.templates.task_date(gantt.getTask(link.source).start_date));
            $("#linkEnd").val(gantt.templates.task_date(gantt.getTask(link.target).start_date));
        } else if($("#linkstypeSel").val() == 2) {
            $("#linkStart").val(gantt.templates.task_date(gantt.getTask(link.source).end_date));
            $("#linkEnd").val(gantt.templates.task_date(gantt.getTask(link.target).end_date));
        } else {
            $("#linkStart").val(gantt.templates.task_date(gantt.getTask(link.source).start_date));
            $("#linkEnd").val(gantt.templates.task_date(gantt.getTask(link.target).end_date));
        }
    }
</script>
