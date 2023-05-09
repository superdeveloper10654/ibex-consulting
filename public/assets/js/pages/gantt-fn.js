var ganttFn = {
    /** @param {object} of gantt instance */
    gantt : {},
    
    /** 
     * Set gantt object to work with
     * @param {object} obj of the gantt instance
     * @return {object} gantt instance
     */
    init: function(obj) {
        return this.gantt = obj;
    },

    /* --------------------------------------------------------------------
    Common functions START
    ---------------------------------------------------------------------*/
    /**
     * Wraapper for gantt date.date_to_str function
     * @param {string|object} date to convert
     * @param {string} format of returning string 
     * @returns string
     */
    dateToStr: function(date, format = "%d %M") {
        let fn = this.gantt.date.date_to_str(format);
        return fn(date);
    },

    initiateZoomMenu: function(levels) {
        let $zoom_contrainer = $('#gantt-zoom-container');

        for (let level of levels) {
            let $el = $(`
                <li>
                    <a class="dropdown-item" title="Set the zoom level to ${level.name}s" data-name="${level.name}">${level.name}s</a>
                </li>
            `);
            
            $($zoom_contrainer).append($el);
            var gantt = this.gantt;

            $($el).on('click', function() {
                let level_name = $(this).find('.dropdown-item').data('name');
                gantt.ext.zoom.setLevel(level_name);
            });
        }
    },

    /* --------------------------------------------------------------------
    Common functions END
    ---------------------------------------------------------------------*/


    /* -------------------------------------------------------------------
    Drag & Drop functional START
    ------------------------------------------------------------------- */
    initDragnDropFunctional: function() {
        
    },
    /* -------------------------------------------------------------------
    Drag & Drop functional END
    ------------------------------------------------------------------- */


    /* -------------------------------------------------------------------
    Gantt START
    -------------------------------------------------------------------- */
    getLayout: function() {
        return {
            css: "gantt_container",
            rows: [
                {
                    gravity: 2,
                    cols: [{
                            view: "grid",
                            group: "grids",
                            scrollY: "scrollVer"
                        },
                        {
                            resizer: true,
                            width: 1
                        },
                        {
                            view: "timeline",
                            scrollX: "scrollHor",
                            scrollY: "scrollVer"
                        },
                        {
                            view: "scrollbar",
                            id: "scrollVer",
                            group: "vertical"
                        }
                    ]
                },
                {
                    resizer: true,
                    width: 1,
                    next: "resources"
                },
                {
                    gravity: 1,
                    id: "resources",
                    config: ganttFn.getResourceColumns(),
                    templates: {
                        grid_row_class: (start, end, resource) => {
                            var css = [];
                            if (this.gantt.$resourcesStore.hasChild(resource.id)) {
                                css.push("folder_row");
                                css.push("group_row");
                            }
                            if (ganttFn.shouldHighlightResource(resource)) {
                                css.push("highlighted_resource");
                            }
                            return css.join(" ");
                        },
                        task_row_class: (start, end, resource) => {
                            var css = [];
                            if (ganttFn.shouldHighlightResource(resource)) {
                                css.push("highlighted_resource");
                            }
                            if (this.gantt.$resourcesStore.hasChild(resource.id)) {
                                css.push("group_row");
                            }
            
                            return css.join(" ");
            
                        }
                    },
                    cols: [{
                            view: "resourceGrid",
                            group: "grids",
                            scrollY: "resourceVScroll"
                        },
                        {
                            resizer: true,
                            width: 1
                        },
                        {
                            view: "resourceTimeline",
                            scrollX: "scrollHor",
                            scrollY: "resourceVScroll"
                        },
                        {
                            view: "scrollbar",
                            id: "resourceVScroll",
                            group: "vertical"
                        }
                    ]
                },
                {
                    view: "scrollbar",
                    id: "scrollHor"
                }
            ]
        
        };
    },
    /* -------------------------------------------------------------------
    Gantt END
    ------------------------------------------------------------------- */

    /* -------------------------------------------------------------------
    Tasks START
    ------------------------------------------------------------------- */
    getTaskColumns: function() {
        let taskColumns = columns.length > 0 ? JSON.parse(columns[0].task_columns)[0] : [];
        let taskColumnAry = [];
        Object.keys(taskColumns).filter(k => taskColumns[k] === true).map(k => {
            if (k !== 'status') {
                let col = this.prepareColumnInsert(k);
                taskColumnAry.push(col);
            }
        });
        taskColumnAry.push({
            name: "add",
            label: "",
            width: 44
        });

        return taskColumnAry;
    },

    prepareColumnInsert: function(columnName) {
        var object;
        var columnWidth = Number(columns[0][columnName]);
        if (columnName == "wbs") {
            object = {
                name: "wbs",
                align: "left",
                width: columnWidth,
                resize: true,
                template: function (task) {
                    return '<div class="drag-handle"><img src=""> ' + gantt.getWBSCode(gantt.getTask(task.id)) +
                        '</div>';
                }
            };
        }
        if (columnName == "text") {
            object = {
                name: "text",
                align: "left",
                tree: true,
                width: columnWidth,
                resize: true
            };
        }
        if (columnName == "start_date") {
            object = {
                name: "start_date",
                align: "left",
                width: columnWidth,
                resize: true,
                label: 'Start',
                template: function (task) {
                    var date = moment(task.start_date, 'YYYY-MM-DD HH:mm:ss', true);
                    if (date.isValid() == true) {
                        return moment(task.start_date).format("ddd D MMM");
                    } else {
                        return "";
                    }
                }
            };
        }
        if (columnName == "end_date") {
            object = {
                name: "end_date",
                align: "left",
                width: columnWidth,
                resize: true,
                label: 'Finish',
                template: function (task) {
                    var date = moment(task.end_date, 'YYYY-MM-DD HH:mm:ss', true);
                    if (date.isValid() == true) {
                        return moment(task.end_date).format("ddd D MMM");
                    } else {
                        return "";
                    }
                }
            };
        }
        if (columnName == "baseline_start") {
            object = {
                name: "baseline_start",
                align: "left",
                width: columnWidth,
                resize: true,
                label: 'Baseline start',
                template: function (task) {
                    var date = moment(task.planned_start, 'YYYY-MM-DD HH:mm:ss', true);
                    if (date.isValid() == true) {
                        return moment(task.planned_start).format("ddd D MMM");
                    } else {
                        return "";
                    }
                }
            };
        }
        if (columnName == "baseline_end") {
            object = {
                name: "baseline_end",
                align: "left",
                width: columnWidth,
                resize: true,
                label: 'Baseline end',
                template: function (task) {
                    var date = moment(task.planned_end, 'YYYY-MM-DD HH:mm:ss', true);
                    if (date.isValid() == true) {
                        return moment(task.planned_end).format("ddd D MMM");
                    } else {
                        return "";
                    }
                }
            };
        }
        if (columnName == "resource_id") {
            object = {
                name: "resource_id",
                align: "left",
                width: columnWidth,
                resize: true,
                label: 'Resources',
                template: function (task) {
                    if (task.type == gantt.config.types.project) {
                        return "";
                    }
                    if (task.resource_id == null) {
                        return "";
                    }
                    if (task.resource_id == "") {
                        return "";
                    }
                    if (task.resource_id == "NULL") {
                        return "";
                    }
                    if (task.resource_id == "undefined") {
                        return "";
                    }
                    // if (task.resource_id.indexOf(",") == -1) {
                    //   // Just one
                    //   var name;
                    //   $.each(window.ibex_gantt_config.resources, function (i) {
                    //     if (window.ibex_gantt_config.resources[i].id == task.resource_id) {
                    //       name = window.ibex_gantt_config.resources[i].name;
                    //     }
                    //   });
                    // } else {
                    //   // Multiple
                    //   // Get first
                    //   var resources = task.resource_id.split(',');
                    //   var totalResources = Number(resources.length);
                    //   var firstResource = resources[0];
                    //   var endString = " (+" + Number(totalResources - 1) + " more)";
                    //   $.each(window.ibex_gantt_config.resources, function (i) {
                    //     if (window.ibex_gantt_config.resources[i].id == firstResource) {
                    //       name = window.ibex_gantt_config.resources[i].name + endString;
                    //     }
                    //   });
                    // }
                    return name;
                }
            };
        }
        if (columnName == "progress") {
            object = {
                name: "progress",
                align: "left",
                width: columnWidth,
                resize: true,
                label: 'Progress',
                template: task => Math.round(task.progress * 10000) / 100
            };
        }
        if (columnName == "duration_worked") {
            object = {
                name: "duration_worked",
                align: "left",
                width: columnWidth,
                resize: true,
                label: 'Duration',
                template: function (task) {
                    return task.duration + " Days";
                }
            };
        }
        if (columnName == "task_calendar") {
            object = {
                name: "calendar_id",
                align: "left",
                width: columnWidth,
                label: "Calendar",
                resize: true,
                template: function (task) {
                    var calendarName;
    
                    $.each(calendars, function (index) {
                        if (calendars[index].id == task.calendar_id) {
                            calendarName = calendars[index].name;
                        }
                    });
                    return calendarName;
                }
            }
        }
        return object;
    },
    /* -------------------------------------------------------------------
    Tasks END
    ------------------------------------------------------------------- */


    /* -------------------------------------------------------------------
    Resources START
    ------------------------------------------------------------------- */
    shouldHighlightResource: function(resource) {
        var selectedTaskId = gantt.getState().selected_task;
        if (gantt.isTaskExists(selectedTaskId)) {
            var selectedTask = gantt.getTask(selectedTaskId),
                selectedResource = selectedTask[gantt.config.resource_property];
    
            if (resource.id == selectedResource) {
                return true;
            } else if (gantt.$resourcesStore.isChildOf(selectedResource, resource.id)) {
                return true;
            }
        }
        return false;
    },

    getResourceColumns: function() {
        let resourceColumns = columns.length > 0 ? JSON.parse(columns[0].resource_columns)[0] : [];
        let ResourceColumnArray = [];
        Object.keys(resourceColumns).filter(k => resourceColumns[k] === true).map(k => {
            let col = this.prepareResourceColumnInsert(k);
            ResourceColumnArray.push(col);
        });
        var resourceArray = {
            columns: ResourceColumnArray
        };

        return resourceArray;
    },

    prepareResourceColumnInsert: function(columnName) {
        var object;
        var columnWidth = 50;
        if (columnName == "name") {
            object = {
                name: "name",
                label: "Name",
                align: "center",
                width: columnWidth,
                resize: true,
                template: function (resource) {
                    return resource.text;
                },
            };
        }
        if (columnName == "complete") {
            object = {
                name: "complete",
                label: "Complete",
                align: "center",
                width: columnWidth,
                resize: true,
                template: (resource) => {
                    var tasks = this.getResourceTasks(resource.id);
    
                    var totalToDo = 0,
                        totalDone = 0;
                    tasks.forEach(function (task) {
                        totalToDo += task.duration;
                        totalDone += task.duration * (task.progress || 0);
                    });
    
                    var completion = 0;
                    if (totalToDo) {
                        completion = Math.floor((totalDone / totalToDo) * 100);
                    }
    
                    return Math.floor(completion) + "%";
                },
            };
        }
        if (columnName == "unit_cost") {
            object = {
                name: "unit_cost",
                label: "Unit Cost",
                align: "center",
                width: columnWidth,
                resize: true,
                template: (resource) => {
                    var tasks = this.getResourceTasks(resource.id);
                    var unit_cost = 0;
                    var totalDuration = 0;
                    tasks.forEach(function (task) {
                        totalDuration += task.duration * 8;
                    });
                    return totalDuration * resource.unit_cost;
                },
            };
        }
        if (columnName == "workload") {
            object = {
                name: "workload",
                label: "Workload",
                align: "center",
                width: columnWidth,
                resize: true,
                template: (resource) => {
                    var tasks = this.getResourceTasks(resource.id);
                    var totalDuration = 0;
                    tasks.forEach(function (task) {
                        totalDuration += task.duration;
                    });
    
                    return (totalDuration || 0) * 8 + "h";
                },
            };
        }
        if (columnName == "resource_calendar") {
            object = {
                name: "calendar",
                label: "Calendar",
                align: "center",
                tree: true,
                width: columnWidth,
                resize: true,
                template: (resource) => {
    
                    if (resource.calendar_id == "0" || resource.calendar_id == 0 || resource.calendar_id ==
                        "null" || resource.calendar_id == null) {
                        return "[None]";
                    }
                    var calendarName;
                    for (var calendar of calendars) {
                        if (calendar['id'] == resource.calendar_id) {
                            calendarName = calendar['name'];
                            break;
                        }
                    }
                    return calendarName;
                },
            };
        }
        return object;
    },

    getResourceTasks: function(resourceId) {
        var store = this.gantt.getDatastore(this.gantt.config.resource_store),
            field = this.gantt.config.resource_property,
            tasks;
    
        if (store.hasChild(resourceId)) {
            tasks = this.gantt.getTaskBy(field, store.getChildren(resourceId));
        } else {
            tasks = this.gantt.getTaskBy(field, resourceId);
        }
        
        return tasks;
    },
    /* -------------------------------------------------------------------
    Resources END
    ------------------------------------------------------------------- */
};