var ganttConf = {
    /** @param {object} of gantt instance */
    gantt: {},

    /** Variables required for script to work */
    current_task: {},

    taskBigId: '',
    resourceMode: 'hours',

    /**
     * Set gantt object to work with
     * @param {object} obj of the gantt instance
     * @return {object} gantt instance
     */
    init: function(gantt) {
        this.gantt = gantt;

        // plugins
        gantt.plugins(this.plugins);

        // zoom
        gantt.ext.zoom.init(this.zoom);
        ganttFn.initiateZoomMenu(this.zoom.levels);


        let today = new Date();
        gantt.addMarker({
            start_date: today,
            css: "today",
            text: "Today",
            title: "Today: " + ganttFn.dateToStr(today)
        });


        gantt.addTaskLayer(function draw_planned(task) {
            if (task.planned_start && task.planned_end) {
                var sizes = gantt.getTaskPosition(task, task.planned_start, task.planned_end);
                var el = document.createElement('div');
                el.className = 'baseline';
                el.id = 'uniqueBaseline';
                el.style.left = sizes.left + 'px';
                el.style.width = sizes.width + 'px';
                el.style.top = sizes.top + gantt.config.task_height + 13 + 'px';
                return el;
            }
            return false;
        });

        // events
        this.attachEvents();

        // templates
        for (let [key, value] of Object.entries(this.templates())) {
            gantt.templates[key] = value;
        }

        // options
        for (let [key, value] of Object.entries(this.options())) {
            gantt[key] = value;
        }

        // config
        for (let [key, value] of Object.entries(this.config())) {
            gantt.config[key] = value;
        }

        // dataStore
        this.initDataStore();

        return gantt;
    },


    /*--------------------------------------------------------------
    Configurations START
    -------------------------------------------------------------- */
    /** Plugins */
    plugins: {
        auto_scheduling: true,
        critical_path: true,
        grouping: true,
        marker: true,
    },
    /** Plugins END */


    /** Gantt templates gantt.templates.* START */
    templates: function() {
        var gantt = this.gantt;
        var conf = this;

        return {
            rightside_text: function(start, end, task) {
                if (task.type == gantt.config.types.milestone) {
                    return task.text;
                }
                return "";
            },
            task_text: function(syart, end, task) {
                return task.text;
            },
            resource_cell_value: function(start_date, end_date, resource, tasks) {
                var html = "<div>"

                if (conf.resourceMode == "hours") {
                    html += tasks.length * 8;
                } else {
                    html += tasks.length;
                }
                html += "</div>";
                return html;
            },
            progress_text: function(start, end, task) {
                return "<span style='text-align:left;'>" + Math.round(task.progress * 100) + "% </span>";
            },
            grid_row_class: function(start, end, task) {
                var css = [];
                if (gantt.hasChild(task.id)) {
                    css.push("folder_row");
                }

                if (task.$virtual) {
                    css.push("group_row")
                }

                if (shouldHighlightTask(task)) {
                    css.push("highlighted_resource");
                }

                return css.join(" ");
            },
            task_row_class: function(start, end, task) {
                if (shouldHighlightTask(task)) {
                    return "highlighted_resource";
                }
                return "";
            },
            timeline_cell_class: function(task, date) {
                if (!gantt.isWorkTime({
                        date: date,
                        task: task
                    }))
                    return "week_end";
                return "";
            },
            resource_cell_class: function(start_date, end_date, resource, tasks) {
                var css = [];
                css.push("resource_marker");
                if (tasks.length <= 1) {
                    css.push("workday_ok");
                } else {
                    css.push("workday_over");
                }
                return css.join(" ");
            },
        };
    },
    /** Gantt templates END */


    /** Events START */
    attachEvents: function() {
        var gantt = this.gantt;
        var conf = this;

        gantt.attachEvent("onTaskLoading", function(task) {
            task.planned_start = gantt.date.parseDate(task.planned_start, "xml_date");
            task.planned_end = gantt.date.parseDate(task.planned_end, "xml_date");
            return true;
        });
        gantt.attachEvent("onTaskCreated", function(task) {
            conf.taskBigId = task.id;
            task.programme_id = programme;
            task.data = JSON.stringify(gantt.copy(gantt.serialize()));
            task.user_id = $('#user_id').val();
            task.guid = generateGUID();
            return true;
        });
        gantt.attachEvent("onAfterTaskUpdate", function(id, item) {
            item.programme_id = programme.id;
            item.user_id = $('#user_id').val();
            refreshSummaryProgress(gantt.getParent(id), true);
            saveTask(gantt.getTask(id));
            return true;
        });
        gantt.attachEvent("onGanttReady", function() {
            var radios = [].slice.call(gantt.$container.querySelectorAll("input[type='radio']"));
            radios.forEach(function(r) {
                gantt.event(r, "change", function(e) {
                    var radios = [].slice.call(gantt.$container.querySelectorAll(
                        "input[type='radio']"));
                    radios.forEach(function(r) {
                        r.parentNode.className = r.parentNode.className.replace("active",
                            "");
                    });
                    if (this.checked) {
                        conf.resourceMode = this.value;
                        this.parentNode.className += " active";
                        gantt.getDatastore(gantt.config.resource_store).refresh();
                    }
                });
            });
        });
        gantt.attachEvent("onParse", function() {
            gantt.eachTask(function(task) {
                // @todo: remove if works with no issues. Bug: page infinite redirects if subtask added
            });
        });
        gantt.attachEvent("onBeforeAutoSchedule", function(taskId) {
            return true;
        });
        gantt.attachEvent("onAfterAutoSchedule", function(taskId) {
            return true;
        });
        gantt.attachEvent("onBeforeTaskAutoSchedule", function(task, start, link, predecessor) {
            return true;
        });
        gantt.attachEvent("onAfterTaskAutoSchedule", function(task, new_date, constraint, predecessor) {
            if (task && predecessor) {

            }
        });
        var gantt_previous_link_data = null;
        gantt.attachEvent("onBeforeLinkAdd", function(id, link) {
            gantt_previous_link_data = JSON.stringify(gantt.copy(gantt.serialize()));
            return true;
        });
        gantt.attachEvent("onAfterLinkAdd", function(id, link) {
            gantt.ajax.post({
                url: route['api.link'],
                data: {
                    source: link['source'],
                    programme_id: programme.id,
                    target: link['target'],
                    type: link['type'],
                    db_type: "linkDB",
                    gantt_data: gantt_previous_link_data,
                    user_id: $('#user_id').val(),
                }
            }).then(function(response) {
                var res = JSON.parse(response.responseText);
                gantt.changeLinkId(id, res.tid);
                return true;
            });
            setTimeout(function () {
                let tasksource = gantt.getTask(link['source']);
                let tasktarget = gantt.getTask(link['target']);
                const d = new Date();
                let activitydata = {
                    _token: token,
                    id: link.type,
                    programme_id: programme.id,
                    gantt_data: gantt.serialize(),
                    primary_guid: link['source'],
                    secondary_guid: link['target'],
                    action_type: 'added',
                    type: 'link',
                    info: 'Add ' + d.getFullYear() + '. ' + d.getMonth() + '. ' + d.getDate(),
                    afterForm: '',
                    testBefore: '',
                    changeString: '',
                    task_text: ''
                };
                saveActivity(activitydata);
            },2000);
        });
        gantt.attachEvent("onAfterLinkDelete", function(id, link) {
            gantt.ajax.del({
                url: route['api.link'] + '/' + id,
                data: {
                    id: id
                }
            }).then(function(response) {

            });
            setTimeout(function () {
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
                    action_type: 'deleted',
                    type: 'link',
                    info: 'Delete ' + d.getFullYear() + '. ' + d.getMonth() + '. ' + d.getDate(),
                    afterForm: '',
                    testBefore: '',
                    changeString: '',
                    task_text: ''
                };
                saveActivity(activitydata);
            }, 2000);
        });
        gantt.attachEvent("onAfterTaskDrag", function(id, mode, e){
            //any custom logic here
            let task = gantt.getTask(id);
            setTimeout(function () {
                const d = new Date();
                const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                let activitydata = {
                    _token: token,
                    id: id,
                    programme_id: programme.id,
                    gantt_data: gantt.serialize(),
                    primary_guid: '',
                    secondary_guid: '',
                    action_type: 'change duration',
                    type: 'task',
                    info: 'Start ' + gantt.templates.task_date(task.start_date), // + '<br>' + 'Now is ' + new Date().getDate() + " " + months[new Date().getMonth()] + " " + new Date().getFullYear(),
                    afterForm: '',
                    testBefore: '',
                    changeString: '',
                    task_text: ''
                };
                saveActivity(activitydata);
            },2000);
        });
        gantt.attachEvent("onLinkDblClick", function(id,e){
            //any custom logic here

            let link = gantt.getLink(id);
            $("#sourceName").val(gantt.getTask(link.source).text);
            $("#targetName").val(gantt.getTask(link.target).text);
            $("#linkstypeSel").val(link.type);
            $("#linkId").val(id);
            if(link.type == 0) {
                $("#linkStart").val(gantt.templates.task_date(gantt.getTask(link.source).end_date));
                $("#linkEnd").val(gantt.templates.task_date(gantt.getTask(link.target).start_date));
            } else if(link.type == 1) {
                $("#linkStart").val(gantt.templates.task_date(gantt.getTask(link.source).start_date));
                $("#linkEnd").val(gantt.templates.task_date(gantt.getTask(link.target).start_date));
            } else if(link.type == 2) {
                $("#linkStart").val(gantt.templates.task_date(gantt.getTask(link.source).end_date));
                $("#linkEnd").val(gantt.templates.task_date(gantt.getTask(link.target).end_date));
            } else {
                $("#linkStart").val(gantt.templates.task_date(gantt.getTask(link.source).start_date));
                $("#linkEnd").val(gantt.templates.task_date(gantt.getTask(link.target).end_date));
            }

            $("#linkModal").modal('show');
        });
    },
    /** Events END */


    /** Gantt options gantt.* START */
    options: () => {
        return {
            $zoomToFit: false,
            showLightbox: function(id) {
                ganttConf.current_task.id = id;
                let task = gantt.getTask(id);
                $('#taskModalTitle').html(task.type ? task.type.toUpperCase() : "New Item");
                $('#typeSel').val(task.type ? task.type : "");
                $('#nameInp').val(task.type ? task.text : "");
                $('#resourceGroupSel').val(task.resource_group_id || $('#resourceGroupSel').first().val());
                $('#resourceItemsSel').val(task.resource_id || $('#resourceItemsSel').first().val());
                progressSld.setValue(task.progress * 100);
                $('#colorCpk').css('backgroundColor', task.color || '#299cb4');
                $('#calendarSel').val(task.calendar_id || $('#calendarSel').first().val());
                $('#scheduleInp').val(
                    `${moment(task.start_date ).format('DD/MM/YYYY')} - ${moment(task.end_date ).format('DD/MM/YYYY')}`);
                $('#baselineInp').val(
                    `${moment(task.planned_start || task.start_date).format('DD/MM/YYYY')} - ${moment(task.planned_end || task.end_date).format('DD/MM/YYYY')}`
                );
                if (task.type == null) {
                    $("#id_color").hide();
                    $("#id_name").hide();
                    $("#id_calendar").hide();
                    $('#id_schedule').hide();
                    $('#id_baseline').hide();
                    $('#id_resourcegroup').hide();
                    $('#id_resourceitem').hide();
                    $("#id_progress").hide();
                    $("#id_image").hide();
                    $("#btn_del").hide();
                    $("#id_new").val(1);
                    $("#taskModalTitle").html("New Item");
                } else if ($('#typeSel').val() == 'task') {
                    $("#id_color").show();
                    $("#id_name").show();
                    $("#id_calendar").show();
                    $('#id_schedule').show();
                    $('#id_baseline').show();
                    $('#id_resourcegroup').hide();
                    $('#id_resourceitem').hide();
                    $("#id_progress").show();
                    $("#id_image").show();
                    $("#btn_del").show();
                    $("#id_new").val(0);
                } else if ($('#typeSel').val() == 'project') {
                    $("#id_color").hide();
                    $("#id_name").show();
                    $("#id_calendar").show();
                    $('#id_schedule').show();
                    $('#id_baseline').hide();
                    $('#id_resourcegroup').hide();
                    $('#id_resourceitem').hide();
                    $("#id_progress").hide();
                    $("#id_image").show();
                    $("#btn_del").show();
                    $("#id_new").val(0);
                } else if ($('#typeSel').val() == 'milestone') {
                    $("#id_color").hide();
                    $("#id_name").show();
                    $("#id_calendar").show();
                    $('#id_schedule').show();
                    $('#id_baseline').show();
                    $('#id_resourcegroup').hide();
                    $('#id_resourceitem').hide();
                    $("#id_progress").hide();
                    $("#id_image").show();
                    $("#btn_del").show();
                    $("#id_new").val(0);
                };
                $('#lightboxModal').modal('show');
            }
        };
    },
    /** Gantt options END */


    /** gantt.conf. */
    config: () => {
        return {
            // end_date: moment().add(10, 'days'),
            // start_date: moment().subtract(10, 'days'),
            fit_tasks: true,
            bar_height: 16,
            row_height: 40,
            task_height: 16,
            branch_loading: true,
            sort: true,
            auto_scheduling: true,
            auto_scheduling_compatibility: true,
            work_time: true,
            skip_off_time: true, // hides non-working time in the gant,
            columns: ganttFn.getTaskColumns(),
            resource_store: "resource_id",
            resource_property: "resource_id",
            order_branch_free: true,
            open_tree_initially: true,
            layout: ganttFn.getLayout(),
            wide_form: true,
            scale_height: 20 * 3,
            duration_unit: "day",
            min_grid_column_width: 30,
            order_branch: "marker",
            auto_types: true,
            static_background: true,
            date_format: "%Y-%m-%d %H:%i",
        };
    },
    /** gantt.conf. END */


    /** dataStore START */
    initDataStore: function() {
        let gantt = this.gantt;

        gantt.$resourcesStore = gantt.createDatastore({
            name: gantt.config.resource_store,
            type: "treeDatastore",
            initItem: function(item) {
                item.parent = item.parent || gantt.config.root_id;
                item[gantt.config.resource_property] = item.parent;
                item.open = true;
                return item;
            }
        });
        gantt.$resourcesStore.attachEvent("onAfterSelect", function(id) {
            gantt.refreshData();
        });
    },
    /** dataStore END */


    /** gantt.ext.zoom. START */
    zoom: {
        activeLevelIndex: 1,
        levels: [
            {
                name: "Hour",
                scale_height: 27,
                scales: [
                    {
                        unit: "day",
                        step: 1,
                        format: "%d %M"
                    },
                    {
                        unit: "hour",
                        step: 1,
                        format: "%H:%i"
                    },
                ]
            },
            {
                name: "Day",
                scale_height: 50,
                scales: [
                    {
                        unit: "day",
                        step: 1,
                        format: "%d %M"
                    }
                ]
            },
            {
                name: "Week",
                scale_height: 50,
                scales: [
                    {
                        unit: "week",
                        step: 1,
                        format: (date) => {
                            var endDate = this.gantt.date.add(date, -6, "day");
                            var weekNum = this.gantt.date.date_to_str("%W")(date);
                            return "#" + weekNum + ", " + ganttFn.dateToStr(date, "%d %M") + " - " + ganttFn.dateToStr(endDate, "%d %M");
                        }
                    },
                    {
                        unit: "day",
                        step: 1,
                        format: "%j %D"
                    }
                ]
            },
            {
                name: "Month",
                scale_height: 50,
                scales: [
                    {
                        unit: "month",
                        step: 1,
                        format: "%F, %Y"
                    },
                    {
                        unit: "week",
                        step: 1,
                        format: (date) => {
                            var endDate = this.gantt.date.add(this.gantt.date.add(date, 1, "week"), -1, "day");
                            return ganttFn.dateToStr(date) + " - " + ganttFn.dateToStr(endDate);
                        }
                    }
                ]
            },
            {
                name: "Quarter",
                height: 50,
                scales: [
                    {
                        unit: "quarter",
                        step: 3,
                        format: (date) => {
                            var endDate = this.gantt.date.add(this.gantt.date.add(date, 3, "month"), -1, "day");
                            return ganttFn.dateToStr(date, "%M %y") + " - " + ganttFn.dateToStr(endDate, "%M %y");
                        }
                    },
                    {
                        unit: "month",
                        step: 1,
                        format: "%M"
                    },
                ]
            },
            {
                name: "Year",
                scale_height: 50,
                scales: [
                    {
                        unit: "year",
                        step: 5,
                        format: (date)  => {
                            var endDate = this.gantt.date.add(this.gantt.date.add(date, 5, "year"), -1, "day");
                            return ganttFn.dateToStr(date, "%Y") + " - " + ganttFn.dateToStr(endDate, "%Y");
                        }
                    }
                ]
            },
        ],
        element: function () {
            return this.gantt.$root.querySelector(".gantt_task");
        }
    }
    /** gantt.ext.zoom. END */
}
