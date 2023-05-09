@push('css')
    <style type="text/css">
        .datepicker {
            z-index: 9999 !important;
        }

        .datepicker.datepicker-dropdown.dropdown-menu.datepicker-orient-left.datepicker-orient-bottom {
            z-index: 999999999 !important;
        }

        input[type=file]::-webkit-file-upload-button {
            display: none;
        }

        input[type=file]::file-selector-button {
            display: none;
        }
    </style>
@endpush
<div class="modal" tabindex="-1" id="modal_import_microsoft_project">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Microsoft Project Or XML file</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="mspImport" action="" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <p>
                        Please choose an MPP Or XML file to import
                    </p>
                    <div class="row">
                        <div class="col-md-12">
                            <input type="file" id="mspFile" class="btn btn-light btn-rounded w-100 waves-effect waves-light"
                                name="file"
                                accept=".mpp,.xml,.xer, text/xml, application/xml, application/xer, application/vnd.ms-project, application/msproj, application/msproject, application/x-msproject, application/x-ms-project, application/x-dos_ms_project, application/mpp, zz-application/zz-winassoc-mpp"
                                style="display: none;" />
                            <label for="mspFile" id="mspFile-label" class="btn btn-light btn-rounded w-100 waves-effect waves-light">Select
                                Microsoft Project Or XML file</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" id="mspImportBtn" class="btn btn-primary btn-rounded waves-effect waves-light w-md mx-1"
                        style="display: none"><i class="mdi mdi-file-upload-outline font-size-16 align-middle"></i>
                        Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('script')
    <script>
        var modal_import_microsoft_project = new bootstrap.Modal($('#modal_import_microsoft_project')[0]);
        var fileDnD = fileDragAndDrop();

        gantt.attachEvent("onGanttReady", function() {
            fileDnD.init(gantt.$container);
        });

        function sendFile(file) {
            fileDnD.showUpload();
            modal_import_microsoft_project.hide();

            upload(file, function() {
                fileDnD.hideOverlay();
            })
        }

        function upload(file, callback, id) {
            var fileResources = [];
            gantt.importFromMSProject({
                data: file,
                callback: function (project, id) {
                    if (project) {
                        gantt.clearAll();
                        if (project.config.duration_unit) {
                            gantt.config.duration_unit = project.config.duration_unit;
                        }
                        for (var i = 0; i < project.data.data.length; i++) {
                            project.data.data[i].planned_start = project.data.data[i].start_date;
                            project.data.data[i].calendar_id = calendars[0] ? calendars[0].id : "0";
                            project.data.data[i].resource_group_id = groups[0] ? groups[0].id : "0";
                            project.data.data[i].resource_id = project.data.data[i].resource.length ? parseInt(project.data.data[i].resource[0]) : "0";
                            project.data.data[i].text = project.data.data[i].text ? project.data.data[i].text : 'task';
                        }
                        for (var j = 0; j < project.resources.length; j++) {
                            fileResources.push({name: "group", value: "1"});
                            fileResources.push({name: "item_name", value: project.resources[j]['name']});
                            fileResources.push({name: "id", value: ""});
                            fileResources.push({name: "calendar_id", value: calendars[0] ? calendars[0].id : "0"});
                            fileResources.push({name: "unit_cost", value: "0"});
                        }

                        myAjax("{{ t_route('programmes.gantt.import-tasks-from-microsoft-project', ':programme') }}".replace(':programme', programme.id), {
                            tasks: project.data.data,
                            links: project.data.links,
                            type: "import"
                        }).then(response => {
                            $.ajax({
                                url: saveUrl.replace('task/?', 'create-group'),
                                type: "POST",
                                data: {
                                    "_token": token,
                                    programme_id: programme.id,
                                    type: "replace",
                                    data:fileResources
                                },
                                success: function (res, status) {
                                    onCloseResourceModal();
                                    const d = new Date();
                                    const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                                    setTimeout(function() {
                                        let activitydata = {
                                            _token: token,
                                            id: '',
                                            programme_id: programme.id,
                                            gantt_data: '',
                                            primary_guid: '',
                                            secondary_guid: '',
                                            action_type: 'imported',
                                            type: 'file',
                                            info: 'Import ' + new Date().getDate() + " " + months[new Date().getMonth()] + " " + new Date().getFullYear(),
                                            afterForm: '',
                                            testBefore: '',
                                            changeString: '',
                                            task_text: file.name
                                        };
                                        saveActivity(activitydata);
                                    }, 1000);
                                },
                                error: function (res, status) {
                                    console.log(res)
                                },
                            });
                            if (callback) {
                                callback(project);
                            }
                        });
                    }
                }
            });
        }

        fileDnD.onDrop(sendFile);
        var form = document.getElementById("mspImport");
        form.onsubmit = function(event) {
            event.preventDefault();
            var fileInput = document.getElementById("mspFile");

            if (fileInput.files[0]) {
                sendFile(fileInput.files[0]);
            } else {
                errorMsg('Please select file to import')
            }
        };
    </script>
@endpush
