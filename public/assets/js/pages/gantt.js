///////////////////////////////////C_C/////////////////////////////////////
var tableIndex = 0;
///////////////////////////////////////////////////////////////////////////
function shouldHighlightTask(task) {
    var store = gantt.$resourcesStore;
    var taskResource = task[gantt.config.resource_property],
        selectedResource = store.getSelectedId();
    if (taskResource == selectedResource || store.isChildOf(taskResource, selectedResource)) {
        return true;
    }
}

function shouldHighlightResource(resource) {
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
}

function calculateSummaryProgress(task) {
    if (task.type != gantt.config.types.project)
        return task.progress;
    var totalToDo = 0;
    var totalDone = 0;
    gantt.eachTask(function (child) {
        if (child.type != gantt.config.types.project) {
            totalToDo += child.duration;
            totalDone += (child.progress || 0) * child.duration;
        }
    }, task.id);
    if (!totalToDo) return 0;
    else return totalDone / totalToDo;
}

function refreshSummaryProgress(id, submit) {
    if (!gantt.isTaskExists(id))
        return;
    var task = gantt.getTask(id);
    var newProgress = calculateSummaryProgress(task);
    if (newProgress !== task.progress) {
        task.progress = newProgress;

        if (!submit) {
            gantt.refreshTask(id);
        } else {
            gantt.updateTask(id);
        }
    }

    if (!submit && gantt.getParent(id) !== gantt.config.root_id) {
        refreshSummaryProgress(gantt.getParent(id), submit);
    }
}
// recalculate progress of summary tasks when the progress of subtasks changes
(function dynamicProgress() {
    function calculateSummaryProgress(task) {
        if (task.type != gantt.config.types.project)
            return task.progress;
        var totalToDo = 0;
        var totalDone = 0;
        gantt.eachTask(function (child) {
            if (child.type != gantt.config.types.project) {
                totalToDo += child.duration;
                totalDone += (child.progress || 0) * child.duration;
            }
        }, task.id);
        if (!totalToDo) return 0;
        else return totalDone / totalToDo;
    }

    function refreshSummaryProgress(id, submit) {
        if (!gantt.isTaskExists(id))
            return;
        var task = gantt.getTask(id);
        var newProgress = calculateSummaryProgress(task);

        if (newProgress !== task.progress) {
            task.progress = newProgress;

            if (!submit) {
                gantt.refreshTask(id);
            } else {
                gantt.updateTask(id);
            }
        }
        if (!submit && gantt.getParent(id) !== gantt.config.root_id) {
            refreshSummaryProgress(gantt.getParent(id), submit);
        }
    }

    gantt.attachEvent("onParse", function () {
        gantt.eachTask(function (task) {
            task.progress = calculateSummaryProgress(task);
        });
    });

    gantt.attachEvent("onAfterTaskUpdate", function (id) {
        refreshSummaryProgress(gantt.getParent(id), true);
    });

    gantt.attachEvent("onTaskDrag", function (id) {
        refreshSummaryProgress(gantt.getParent(id), false);
    });
    gantt.attachEvent("onAfterTaskAdd", function (id) {
        refreshSummaryProgress(gantt.getParent(id), true);
    });

    (function () {
        var idParentBeforeDeleteTask = 0;
        gantt.attachEvent("onBeforeTaskDelete", function (id) {
            idParentBeforeDeleteTask = gantt.getParent(id);
        });
        gantt.attachEvent("onAfterTaskDelete", function () {
            refreshSummaryProgress(idParentBeforeDeleteTask, true);
        });
    })();
})();

function getResourceTasks(resourceId) {
    var store = gantt.getDatastore(gantt.config.resource_store),
        field = gantt.config.resource_property,
        tasks;

    if (store.hasChild(resourceId)) {
        tasks = gantt.getTaskBy(field, store.getChildren(resourceId));
    } else {
        tasks = gantt.getTaskBy(field, resourceId);
    }
    return tasks;
}

async function getParsedGroups(url, programmeId, token) {
    return await $.ajax({
        url,
        type: "POST",
        data: {
            "_token": token,
            programme_id: programmeId,
        },
        success: function (res) {
            return res;
        }
    });
}

function getCalendarOverrides(calendarID) {
    var calendarOverrides = [];
    $.each(window.ibex_gantt_config.calendarOverrides, function (index) {
        if (window.ibex_gantt_config.calendarOverrides[index].calendar_id == calendarID) {
            calendarOverrides.push(window.ibex_gantt_config.calendarOverrides[index]);
            return calendarOverrides;
        }
    });
    return calendarOverrides;
}

$('#lightboxModal').on('click', function (e) {
    if ($(e.target).attr('data-bs-dismiss')) {
        if (taskBigId > 1000000000) {
            gantt.deleteTask(taskBigId);
        }
    }
})

function parseDate(str) {
    let [sdate, edate] = str.split(' - ');
    return [moment(sdate, "DD/MM/YYYY").toDate(), moment(edate, "DD/MM/YYYY").toDate()];
}

function openganttmodel(toggle) {
    $('#modal_edit_task_columns').modal('show');
}

$(".save-task-columns").click(function (e) {
    var myArray = {};
    $('#table_task_columns tbody tr').each(function (i, row) {
        var row = $(this);
        var index = row.data("index");
        var enabled = false;
        if (row.find('input[type="checkbox"]').is(':checked')) {
            enabled = true;
        }
        myArray[index] = enabled;
    });
    let data = {
        json: myArray,
        programme_id: programme.id,
    };

    myAjax(saveUrl.replace('task/?', 'save-task-columns'), data).then(() => {
        location.reload();
    });
});

function ganttresourcemodel(toggle) {
    $('#modal_edit_resource_columns').modal('show');
}

$(".save-resource-columns").click(function (e) {
    var myArray = {};
    $('#table_resource_columns tbody tr').each(function (i, row) {
        var row = $(this);
        var index = row.data("index");
        let enabled = row.find('input[type="checkbox"]').is(':checked');
        myArray[index] = enabled;
    });
    let data = {
        json: myArray,
        programme_id: programme.id,
    };

    myAjax(saveUrl.replace('task/?', 'save-resource-columns')).then(() => {
        location.reload();
    });
});

function Daterange() {
    $('#modal_date_range').modal('show');
}
/* Update date range */
$('#daterangeform').on('submit', function (e) {
    e.preventDefault();
    let data = {
        date_from: $('input[name=date_from]').val(),
        date_to: $('input[name=date_to]').val(),
        programme_id: programme.id
    };
    myAjax(saveUrl.replace('task/?', 'set-date-range'), data).then(res => {
        location.reload();
    });
});

// Bug: RangeError: Maximum call stack size exceeded
// function chart_render(date_from, date_to) {
//     gantt.config.start_date = date_from;
//     gantt.config.end_date = date_to;
//     window.ibex_gantt_config.rangeStartDate = gantt.config.start_date;
//     window.ibex_gantt_config.rangeEndDate = gantt.config.end_date;
//     gantt.render();
//     $("#modal_date_range").modal('hide');
// }
//Activity Parts
function showactivity() {
    $('#activity').show();
}

$("#gantt-activity-expand").click(function () {
    $("#activity").addClass("zoomActivity");
});

$("#gantt-activity-shrink").click(function () {
    $("#activity").removeClass("zoomActivity");
});

$("#gantt-activity-close").click(function () {
    $('#activity').hide();
});

$('document').ready(function () {
    reloadActivityFeed();
});

function reloadActivityFeed() {
    $.ajax({
        url: saveUrl.replace('task/?', 'get_activity'),
        type: "POST",
        data: {
            "_token": token,
            programme_id: programme.id,
        },
        success: function (response) {
            var response = JSON.parse(response);
            var activity = response.activity;
            var ul = '<ul>';
            for (var i = 0; i < activity.length; i++) {
                var c = new Date(activity[i].created);
                ul += '<li id="rollback_' + activity[i].id +'">';
                ul += '<div class="activityDetail-header">';
                ul +=
                    ' <div class="activityDetail-img"><img src="https://beta.ibex.software/gantt/img/logo.png"></div>';
                ul += '</div><h6 class = "text-primary">' + $("#user_name").val() + ' ' + activity[i].ui_string + '</h6><p>' +
                    activity[i].aux_data + '</p>';
                ul +=
                    '<div><button type="button" class="btn btn-sm btn-primary btn-rounded w-md waves-effect waves-light task-rollback-trigger" onclick="rollbackActivity(' +
                    activity[i].id +
                    ')"><svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><path d="M0 0h24v24H0z"></path><path d="M10.963 7.5h.085a.5.5 0 01.497.45L12 12.5l3.248 1.856a.5.5 0 01.252.434V15a.382.382 0 01-.482.368l-4.62-1.26a.5.5 0 01-.366-.52l.432-5.626a.5.5 0 01.499-.462z" fill="#fff"></path><path d="M7.39 2.835A10.466 10.466 0 0111.5 2C17.299 2 22 6.701 22 12.5S17.299 23 11.5 23 1 18.299 1 12.5c0-.985.136-1.938.39-2.842l1.925.54A8.509 8.509 0 003 12.5 8.5 8.5 0 1011.5 4c-.951 0-1.878.156-2.751.454l1.19 1.42a.5.5 0 01-.354.82l-4.867.276a.5.5 0 01-.515-.615l1.129-4.731a.5.5 0 01.869-.206L7.39 2.835z" fill="#fff" opacity=".6"></path></g></svg> Roll Back</button></div></li>';
            }
            ul += '</ul>';
            $('#showactivitydata').html(ul);
        }
    });
}
//Calendars
function showCalendarModal(toggle) {
    $('#modal_edit_calendars').modal('show');
    $("#table_calendars > tbody").empty();
    $.each(calendars, function (index) {
        var calendar = calendars[index];
        var dayString = "";
        if (calendar.working_day_monday == 1) {
            dayString += "Mon, ";
        }
        if (calendar.working_day_tuesday == 1) {
            dayString += "Tue, ";
        }
        if (calendar.working_day_wednesday == 1) {
            dayString += "Wed, ";
        }
        if (calendar.working_day_thursday == 1) {
            dayString += "Thu, ";
        }
        if (calendar.working_day_friday == 1) {
            dayString += "Fri, ";
        }
        if (calendar.working_day_saturday == 1) {
            dayString += "Sat, ";
        }
        if (calendar.working_day_sunday == 1) {
            dayString += "Sun, ";
        }
        dayString = dayString.substring(0, dayString.length - 2);
        var calendarType = "<i class='bx bx-task'></i> Task";
        if (calendar.type == 2) {
            calendarType = "<i class='mdi mdi-excavator'></i> Resource";
        }
        $("#table_calendars > tbody").append('<tr><td>' + calendar.name + '</td><td style=""">' +
            calendarType +
            '</td><td><i class="mdi mdi-pencil font-size-20 edit-calendar" data-index="' + calendar.id +
            '"></i></span></td></tr>');
    });
}

function getCalendar(calendarID) {
    var calendar = null;
    $.each(calendars, function (index) {
        if (calendars[index].id == calendarID) {
            calendar = calendars[index];
            return calendar;
        }
    });
    return calendar;
}

function padLeadingZero(number) {
    return (number < 10) ? ("0" + number) : number;
}

function loadCalendarsToUI() {
    $('#resource_edit_calendar_id').empty();
    $('#resource_edit_calendar_id').append($('<option>', {
        value: "1",
        text: 'Select'
    }));
    $.each(calendars, function (index) {
        if (calendars[index].type == 2) {
            $('#resource_edit_calendar_id').append($('<option>', {
                value: calendars[index].id,
                text: calendars[index].name
            }));
        }
    });
    //$('.mdb-select').material_select();
    $("#table_calendars > tbody").empty();
    $.each(calendars, function (index) {
        var calendar = calendars[index];
        var dayString = "";
        if (calendar.working_day_monday == 1) {
            dayString += "Mon, ";
        }
        if (calendar.working_day_tuesday == 1) {
            dayString += "Tue, ";
        }
        if (calendar.working_day_wednesday == 1) {
            dayString += "Wed, ";
        }
        if (calendar.working_day_thursday == 1) {
            dayString += "Thu, ";
        }
        if (calendar.working_day_friday == 1) {
            dayString += "Fri, ";
        }
        if (calendar.working_day_saturday == 1) {
            dayString += "Sat, ";
        }
        if (calendar.working_day_sunday == 1) {
            dayString += "Sun, ";
        }
        dayString = dayString.substring(0, dayString.length - 2);
        var calendarType = "Task";
        if (calendar.type == 2) {
            calendarType = "Resource";
        }
        $("#table_calendars > tbody").append('<tr><td style=""><a class="edit-calendar" data-index="' +
            calendar.id + '">' + calendar.name + '</a></td><td style=""">' + calendarType +
            '</td><td><i class="mdi mdi-pencil font-size-20 edit-calendar" data-index="' + calendar
                .id + '"></i></span></td></tr>');
    });
}

function reloadSettings() {
    $.ajax({
        url: saveUrl.replace('task/?', 'reload_gantt'),
        type: "post",
        data: {
            "_token": token,
            programme_id: programme.id,
        },
        success: function (response) {
            result = JSON.parse(response);
            calendarOverrides = result.calendar_overrides;
            loadCalendarsToUI();
            $("#modal_calendar_editor").modal('hide');
            // location.reload();
        }
    });
}
// Edit both calendar types - task and resource
$(document).on('click', '.edit-calendar', function (e) {
    $("#modal_edit_calendars").modal('hide');
    $("#modal_task_calendar_editor").modal('show');
    $("#modal_resource_calendar_editor").modal('hide');
    window.ibex_gantt_config.editingCalendarID = $(this).data('index');
    var calendar = getCalendar($(this).data('index'));
    var calendarOverrides = getCalendarOverrides($(this).data('index'));
    // TASK CALENDARS
    var calendarType = "";
    if (calendar.type == 1) {
        if (calendar) {
            $("#task_editor_overrides_header").show();
            $("#resource_editor_overrides_header").show();
            $("#task_calendar_edit_id").val(calendar.id).trigger("change");
            $("#task_calendar_edit_type").val(calendar.type).trigger("change");
            $("#task_calendar_edit_name").val(calendar.name);
            $("#task_calendar_edit_start_time").val(padLeadingZero(calendar.start_hour) + ":" +
                padLeadingZero(calendar.start_minute));
            $("#task_calendar_edit_end_time").val(padLeadingZero(calendar.end_hour) + ":" + padLeadingZero(
                calendar.end_minute));
            $("#task_calendar_edit_start_minute").val(padLeadingZero(calendar.start_minute)).trigger(
                "change");
            $("#task_calendar_edit_end_hour").val(padLeadingZero(calendar.end_hour)).trigger("change");
            $("#task_calendar_edit_end_minute").val(padLeadingZero(calendar.end_minute)).trigger("change");
            var is_default_task_calendar = 1;
            var is_default_resource_calendar = 0;
            if (calendar.is_default_task_calendar == 1) {
                $("#task_calendar_edit_default").attr('checked', true);
            } else {
                $("#task_calendar_edit_default").attr('checked', false);
            }
            if (calendar.working_day_monday == 1) {
                $("#task_calendar_edit_working_day_monday").attr("checked", true);
            } else {
                $("#task_calendar_edit_working_day_monday").attr("checked", false);
            }
            if (calendar.working_day_tuesday == 1) {
                $("#task_calendar_edit_working_day_tuesday").attr("checked", true);
            } else {
                $("#task_calendar_edit_working_day_tuesday").attr("checked", false);
            }
            if (calendar.working_day_wednesday == 1) {
                $("#task_calendar_edit_working_day_wednesday").attr("checked", true);
            } else {
                $("#task_calendar_edit_working_day_wednesday").attr("checked", false);
            }
            if (calendar.working_day_thursday == 1) {
                $("#task_calendar_edit_working_day_thursday").attr("checked", true);
            } else {
                $("#task_calendar_edit_working_day_thursday").attr("checked", false);
            }
            if (calendar.working_day_friday == 1) {
                $("#task_calendar_edit_working_day_friday").attr("checked", true);
            } else {
                $("#task_calendar_edit_working_day_friday").attr("checked", false);
            }

            if (calendar.working_day_saturday == 1) {
                $("#task_calendar_edit_working_day_saturday").attr("checked", true);
            } else {
                $("#task_calendar_edit_working_day_saturday").attr("checked", false);
            }
            if (calendar.working_day_sunday == 1) {
                $("#task_calendar_edit_working_day_sunday").attr("checked", true);
            } else {
                $("#task_calendar_edit_working_day_sunday").attr("checked", false);
            }
            $("#table_task_calendar_overrides > tbody").empty();
            $.each(calendarOverrides, function (index) {
                $("#table_task_calendar_overrides > tbody").append("<tr><td>" + moment(
                    calendarOverrides[index].start_date, "MM/DD/YYYY").format(
                        "ddd Do MMM") + "&nbsp; - &nbsp;" + moment(calendarOverrides[index]
                            .end_date, "MM/DD/YYYY").format("ddd Do MMM") +
                    "</td><td class='delete-calendar-override' data-index='" +
                    calendarOverrides[index].id + "'><i class='bx bx-trash'></i></td></tr>");
            });
            //$('.mdb-select').material_select();
            $("#modal_resource_calendar_editor").modal('hide');
            $("#modal_task_calendar_editor").modal('show');
            $("#delete-task-calendar").show();
        }
    }
    // RESOURCE CALENDARS
    if (calendar.type == 2) {
        if (calendar) {
            $("#resource_calendar_edit_id").val(calendar.id).trigger("change");
            $("resource_calendar_edit_type").val(calendar.type).trigger("change");
            $("#resource_calendar_edit_name").val(calendar.name);
            $("#resource_calendar_edit_start_time").val(padLeadingZero(calendar.start_hour) + ":" +
                padLeadingZero(calendar.start_minute));
            $("#resource_calendar_edit_end_time").val(padLeadingZero(calendar.end_hour) + ":" +
                padLeadingZero(calendar.end_minute));
            $("#resource_calendar_edit_start_minute").val(padLeadingZero(calendar.start_minute)).trigger(
                "change");
            $("#resource_calendar_edit_end_hour").val(padLeadingZero(calendar.end_hour)).trigger("change");
            $("#resource_calendar_edit_end_minute").val(padLeadingZero(calendar.end_minute)).trigger(
                "change");
            var is_default_task_calendar = 0;
            var is_default_resource_calendar = 1;
            if (calendar.is_default_resource_calendar == 1) {
                $("#resource_calendar_edit_default").attr('checked', true);
            } else {
                $("#resource_calendar_edit_default").attr('checked', false);
            }
            if (calendar.working_day_monday == 1) {
                $("#resource_calendar_edit_working_day_monday").attr("checked", true);
            } else {
                $("#resource_calendar_edit_working_day_monday").attr("checked", false);
            }
            if (calendar.working_day_tuesday == 1) {
                $("#resource_calendar_edit_working_day_tuesday").attr("checked", true);
            } else {
                $("#resource_calendar_edit_working_day_tuesday").attr("checked", false);
            }
            if (calendar.working_day_wednesday == 1) {
                $("#resource_calendar_edit_working_day_wednesday").attr("checked", true);
            } else {
                $("#resource_calendar_edit_working_day_wednesday").attr("checked", false);
            }
            if (calendar.working_day_thursday == 1) {
                $("#resource_calendar_edit_working_day_thursday").attr("checked", true);
            } else {
                $("#resource_calendar_edit_working_day_thursday").attr("checked", false);
            }
            if (calendar.working_day_friday == 1) {
                $("#resource_calendar_edit_working_day_friday").attr("checked", true);
            } else {
                $("#resource_calendar_edit_working_day_friday").attr("checked", false);
            }
            if (calendar.working_day_saturday == 1) {
                $("#resource_calendar_edit_working_day_saturday").attr("checked", true);
            } else {
                $("#resource_calendar_edit_working_day_saturday").attr("checked", false);
            }
            if (calendar.working_day_sunday == 1) {
                $("#resource_calendar_edit_working_day_sunday").attr("checked", true);
            } else {
                $("#resource_calendar_edit_working_day_sunday").attr("checked", false);
            }
            $("#table_resource_calendar_overrides > tbody").empty();
            $.each(calendarOverrides, function (index) {
                $("#table_resource_calendar_overrides > tbody").append("<tr><td>" + moment(
                    calendarOverrides[index].start_date, "MM/DD/YYYY").format(
                        "ddd Do MMM") + " - " +
                    moment(calendarOverrides[index].end_date, "MM/DD/YYYY").format(
                        "ddd Do MMM") +
                    "</td><td class='delete-resource-calendar-override' data-index='" +
                    calendarOverrides[index].id + "'><i class='bx bx-trash'></i></td></tr>");
            });
            //$('.mdb-select').material_select();
            $("#modal_task_calendar_editor").modal('hide');
            $("#modal_resource_calendar_editor").modal('show');
            $("#delete-resource-calendar").show();
        }
    }
});

$("#save-task-calendar").click(function () {
    //$('.mdb-select').material_select('destroy');
    var enabled = 1,
        isDefault = 1,
        workingDayMonday = 1,
        workingDayTuesday = 1,
        workingDayWednesday = 1,
        workingDayThursday = 1,
        workingDayFriday = 1,
        workingDaySaturday = 1,
        workingDaySunday = 1;
    if (!$('#task_calendar_edit_working_day_monday').is(':checked')) {
        workingDayMonday = 0;
    }
    if (!$('#task_calendar_edit_working_day_tuesday').is(':checked')) {
        workingDayTuesday = 0;
    }
    if (!$('#task_calendar_edit_working_day_wednesday').is(':checked')) {
        workingDayWednesday = 0;
    }
    if (!$('#task_calendar_edit_working_day_thursday').is(':checked')) {
        workingDayThursday = 0;
    }
    if (!$('#task_calendar_edit_working_day_friday').is(':checked')) {
        workingDayFriday = 0;
    }
    if (!$('#task_calendar_edit_working_day_saturday').is(':checked')) {
        workingDaySaturday = 0;
    }
    if (!$('#task_calendar_edit_working_day_sunday').is(':checked')) {
        workingDaySunday = 0;
    }
    if (!$('#task_calendar_edit_enabled').is(':checked')) {
        enabled = 0;
    }
    if (!$('#task_calendar_edit_default').is(':checked')) {
        isDefault = 0;
    }
    var task_calendar_edit_id = $('#task_calendar_edit_id').val();
    var name = $('#task_calendar_edit_name').val();
    var programme_id = programme.id;

    $.ajax({
        url: saveUrl.replace('task/?', 'save_task_calendar'),
        type: "POST",
        data: {
            "_token": token,
            id: task_calendar_edit_id,
            name: name,
            working_day_monday: workingDayMonday,
            working_day_tuesday: workingDayTuesday,
            working_day_wednesday: workingDayWednesday,
            working_day_thursday: workingDayThursday,
            working_day_friday: workingDayFriday,
            working_day_saturday: workingDaySaturday,
            working_day_sunday: workingDaySunday,
            programme_id: programme_id,
            start_time: $("#task_calendar_edit_start_time").val(),
            end_time: $("#task_calendar_edit_end_time").val(),
            enabled: enabled,
            default: isDefault,
            type: 1,
            overrides: JSON.stringify(window.ibex_gantt_config.activeCalendarOverrides),
        },
        success: function (res) {
            if (!res.success) {
                errorMsg(res.message);
                return;
            }

            successMsg(res.message);
            $(this).find('form').trigger('reset');
            $("#modal_task_calendar_editor").modal('hide');
            window.ibex_gantt_config.activeCalendarOverrides = [];
            reloadSettings();
        }
    }).fail((res) => {
        showValidationErrors(res);
    });
});

$("#save-resource-calendar").click(function () {
    //$('.mdb-select').material_select('destroy');
    var enabled = 1,
        isDefault = 1,
        workingDayMonday = 1,
        workingDayTuesday = 1,
        workingDayWednesday = 1,
        workingDayThursday = 1,
        workingDayFriday = 1,
        workingDaySaturday = 1,
        workingDaySunday = 1;
    var programme_id = programme.id;
    if (!$('#resource_calendar_edit_working_day_monday').is(':checked')) {
        workingDayMonday = 0;
    }
    if (!$('#resource_calendar_edit_working_day_tuesday').is(':checked')) {
        workingDayTuesday = 0;
    }
    if (!$('#resource_calendar_edit_working_day_wednesday').is(':checked')) {
        workingDayWednesday = 0;
    }
    if (!$('#resource_calendar_edit_working_day_thursday').is(':checked')) {
        workingDayThursday = 0;
    }
    if (!$('#resource_calendar_edit_working_day_friday').is(':checked')) {
        workingDayFriday = 0;
    }
    if (!$('#resource_calendar_edit_working_day_saturday').is(':checked')) {
        workingDaySaturday = 0;
    }
    if (!$('#resource_calendar_edit_working_day_sunday').is(':checked')) {
        workingDaySunday = 0;
    }
    if (!$('#resource_calendar_edit_enabled').is(':checked')) {
        enabled = 0;
    }
    if (!$('#resource_calendar_edit_default').is(':checked')) {
        isDefault = 0;
    }
    var name = $("#resource_calendar_edit_name").val();
    $.ajax({
        url: saveUrl.replace('task/?', 'save_resource_calendar'),
        type: "POST",
        data: {
            "_token": token,
            id: $("#resource_calendar_edit_id").val(),
            name: $("#resource_calendar_edit_name").val(),
            working_day_monday: workingDayMonday,
            working_day_tuesday: workingDayTuesday,
            working_day_wednesday: workingDayWednesday,
            working_day_thursday: workingDayThursday,
            working_day_friday: workingDayFriday,
            working_day_saturday: workingDaySaturday,
            working_day_sunday: workingDaySunday,
            start_time: $("#resource_calendar_edit_start_time").val(),
            end_time: $("#resource_calendar_edit_end_time").val(),
            enabled: enabled,
            default: isDefault,
            type: $("#resource_calendar_edit_type").val(),
            programme_id: programme_id,
        },

        success: function (res) {
            if (!res.success) {
                errorMsg(res.message);
                return;
            }

            successMsg(res.message);
            $(this).find('form').trigger('reset');
            $("#modal_resource_calendar_editor").modal('hide');
            reloadSettings();
        }
    }).fail(res => {
        showValidationErrors(res);
        // addFormErrors($('#modal_resource_calendar_editor form')); @todo need to finish setup
    });
});

$(document).on('click', '#delete-resource-calendar', function (e) {
    var programme_id = programme.id;
    $.ajax({
        url: saveUrl.replace('task/?', 'delete_calendar'),
        type: "POST",
        data: {
            "_token": token,
            id: window.ibex_gantt_config.editingCalendarID,
            programme_id: programme_id,
        },
        success: function (data) {
            var data = JSON.parse(data);
            successMsg(data.message);
            $("#modal_resource_calendar_editor").modal('hide');
            reloadSettings();
        }
    });
});

$(".add-resource-calendar").click(function (e) {
    $("#modal_task_calendar_editor").modal('hide');
    $("#modal_edit_calendars").modal('hide');
    $("#modal_resource_calendar_editor").modal('show');
    $("#modal_resource_editor").modal('hide');
    $("#resource_editor_overrides_header").hide();
});

$(".add-task-calendar").click(function (e) {
    $("#modal_resource_editor").modal('hide');
    $("#modal_edit_calendars").modal('hide');
    $("#modal_resource_calendar_editor").modal('hide');
    $("#modal_task_calendar_editor").modal('show');
    $("#task_editor_overrides_header").hide();
});

function showResourceModal() {
    showdata();
    $('#AddResourcesModel').modal('show');
}

function showdata() {
    var programme_id = programme.id;
    $.ajax({
        url: saveUrl.replace('task/?', 'GetResources'),
        type: "POST",
        data: {
            "_token": token,
            programme_id: programme_id,
        },
        success: function (result) {
            var option = '<option value="">Select Group</option>';
            var tr = '<thead>' +
                '<tr>' +
                '<th scope="col">Name</th>' +
                '<th scope="col">Resource Calendar</th>' +
                '<th scope="col">Action</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody> ';
            var resourcess = result.resources;
            var resources_item = result.child_parent;
            $.each(resourcess, function (index) {
                if (resourcess[index].parent_id == 0) {
                    option += '<option value=' + resourcess[index].id + '>' + resourcess[index]
                        .name + '</option>';
                    tr += '<tr>' +
                        '<td>' +
                        '<input name="group_name[' + index + ']" value="' + resourcess[index].name + '" style="width: 100%; border: none">' +
                        '<input name="group_id[' + index + ']" value="' + resourcess[index].id + '" style="display: none;">' +
                        '</td>' +
                        '<td>' +
                        '<select class="form-control mdb-select dropdown-primary" style="font-size: 0.8em;" name="group_calendar[' + index + ']">' +
                        $("#resource_calendars").html() +
                        '</select>' +
                        '</td>' +
                        '<td>' +
                        '&nbsp;&nbsp;' +
                        '<a href="javascript:void(0)" onclick="deletegroup(' + resourcess[index].id + ')"><i class="fas fa-trash"></i></a>' +
                        '</td>' +
                        '</tr>';
                }
                tableIndex = index;
            });
            tr += '</tbody>';
            $('#resource_group_table').html(tr);
            $('#resources_group').html(option);

            var tr1 =
                '<thead><tr><th scope="col">Group</th><th scope="col">Item Name</th><th scope="col">Unit Cost</th><th scope="col">Action</th></tr></thead><tbody>';
            $.each(resources_item, function (index) {
                tr1 += '<tr><td>' + resources_item[index].parent_name + '</td><td>' +
                    resources_item[index].name + '</td><td>' +
                    resources_item[index].unit_cost +
                    '</td><td><a href="javascript:void(0)" onclick="editresource(' +
                    resources_item[index].id +
                    ')"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;<a href="javascript:void(0)" onclick="deletegroup(' +
                    resources_item[index].id + ')"><i class="fas fa-trash"></i></a></td></tr>';

            });
            tr1 += '</tbody>';
            $('#resources_item_table').html(tr1);
        }
    });
}

function showImportMPPModal() {
    $('#modal_import_microsoft_project').modal('show');
}

function showImportPrimaveraModal() {
    $('#modal_import_primavera_p6').modal('show');
}

$("#select_img").on("click", function () {
    $("#task-image-upload").click();
})

function get_images(id) {
    $.ajax({
        url: saveUrl.replace("task/?", "get-photos"),
        type: "GET",
        data: {
            _token: token,
            programme_id: id
        },
        success: function (response) {
            var images = JSON.parse(response);
            var text = "";
            for (var i = 0; i < images.length; i++) {
                text += `<div class= "form-control mb-3">`;
                text += `<img class="w-100" src = "${imageUrl + "/" + images[i].name}" alt = ""/>`;
                text += `<div class="row text-center m-3">`;
                text += `<div class="col-md-6">`;
                text += `<a class="btn btn-sm btn-light btn-rounded w-md waves-effect waves-light" href="${imageUrl + "/" + images[i].name}" target="_blank"><i class="bx bx-expand"></i> Pop-out</a></div>`;
                text += `<div class="col-md-6">`;
                text += `<a class="btn btn-sm btn-light btn-rounded w-md waves-effect waves-light" id = "${images[i].id}" href = "#"><span onclick = "delete_img(this)"><i class="mdi mdi-trash-can-outline"></i> Delete</span></a></div>`;
                text += `</div>`;
                text += `</div>`;
            }
            $("#photo_gallery").html(text);
        }
    })
}

function delete_img(obj) {
    swalConfirm('Are you sure want to delete the image?', '', (confirmed) => {
        if (confirmed) {
            $.ajax({
                url: saveUrl.replace("task/?", "delete-image"),
                type: "POST",
                data: {
                    _token: token,
                    id: $(obj).parent("a")[0].id
                },
                success: function (response) {
                    successMsg('Deleted');
                    get_images(programme.id);
                }
            })
        }
    });
}

(function () {
    setTimeout(function () {
        get_images(programme.id);
    }, 3000);
})();

$("#taskuploadbutton").on("click", function () {
    var programme_id = programme.id;
    var formData = new FormData();
    formData.append("file", taskimageupload.files[0]);
    formData.append("programme_id", programme_id);
    formData.append("_token", token);
    var file = taskimageupload.files[0];
    var type = file.type;
    for (var i = 0; i < image_type.length; i++) {
        if (type.split("/")[1] == image_type[i]) break;
    }
    if (i == image_type.length) {
        errorMsg("File must be an image");
        return;
    }
    $.ajax({
        url: saveUrl.replace('task/?', 'photo-uploads'),
        method: "POST",
        data: formData,
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        success: function (response) {
            get_images(programme_id);
        }
    });
})

function editgroup(id) {
    $.ajax({
        url: saveUrl.replace('task/?', 'edit-group'),
        type: "POST",
        data: {
            "_token": token,
            id: id,
        },
        success: function (response) {
            var result = JSON.parse(response);
            $('#group_name').val(result.resources[0].name);
            $('#resource_edit_calendar_id').val(result.resources[0].calendar_id);
            $('#group_id').val(result.resources[0].id);
        }
    });
}

function deletegroup(id) {
    $.ajax({
        url: saveUrl.replace('task/?', 'delete-group'),
        type: "POST",
        data: {
            "_token": token,
            id: id,
        },
        success: function (response) {
            showdata();
            successMsg(response.success);
        }
    });
}
/* Save New Resources item */
$('#resourceForm').on('submit', function (e) {
    e.preventDefault();
    let programme_id = programme.id;
    let group = $('#resources_group').val();
    let item_name = $('#Resources_item').val();
    let id = $('#resources_group_id').val();
    let calendar_id = $('#resource_group_calendar_id').val();
    let unit_cost = $('#resource_unit_cost').val();
    $.ajax({
        url: saveUrl.replace('task/?', 'create-resources-item'),
        type: "POST",
        data: {
            "_token": token,
            group: group,
            item_name: item_name,
            id: id,
            calendar_id: calendar_id,
            programme_id: programme_id,
            unit_cost: unit_cost
        },
        success: function (response) {
            showdata();
            $("#resourceForm").trigger("reset");
            successMsg(response.success);
        },
        error: function (response) {
            $('#resourcegroupErrorMsg').text(response.responseJSON.errors.group);
            $('#itemnameErrorMsg').text(response.responseJSON.errors.item_name);
            $('#calendargroupnameErrorMsg').text(response.responseJSON.errors.calendar_id);
        },
    });
});

function editresource(id) {
    $.ajax({
        url: saveUrl.replace('task/?', 'edit-group'),
        type: "POST",
        data: {
            "_token": token,
            id: id,
        },
        success: function (response) {
            var result = JSON.parse(response);
            $('#resources_group').val(result.resources[0].parent_id);
            $('#Resources_item').val(result.resources[0].name);
            $('#resources_group_id').val(result.resources[0].id);
            $('#resource_group_calendar_id').val(result.resources[0].calendar_id);
        }
    });
}

function saveTaskOnModal() {
    let scheduleDates = parseDate($('#scheduleInp').val());
    let baselineDates = parseDate($('#baselineInp').val());
    let task = gantt.getTask(ganttConf.current_task.id);
    task.type = $('#typeSel').val();
    task.text = $('#nameInp').val();
    task.resource_group_id = $('#resourceGroupSel').val();
    task.resource_id = $('#resourceItemsSel').val();
    task.progress = progressSld.getValue()[0] / 100;
    task.color = $('#colorCpk').css('backgroundColor');
    task.calendar_id = $('#calendarSel').val();
    task.start_date = scheduleDates[0];
    task.end_date = scheduleDates[1];
    task.planned_start = baselineDates[0];
    task.planned_end = baselineDates[1];
    gantt.refreshTask(ganttConf.current_task.id);

    if (task.type == null) {
        errorMsg('Select the Item type.');
        return;
    }
    if (task.text == '') {
        errorMsg('Input the Item name.');
        return;
    }

    saveTask(task)
        .then(() => {
            $('#lightboxModal').modal('hide');
            gantt.clearAll();

            gantt.load(loadURL.replace(':id', programme.id), function () {
                if(contract_key_date_name){
                    for(let i = 0; i< contract_key_date.length; i++){
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
    const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    if($("#id_new").val() == 1)
    {
        const d = new Date();
        setTimeout(function() {
            let activitydata = {
                _token: token,
                id: task.id,
                programme_id: programme.id,
                gantt_data: gantt.serialize(),
                primary_guid: task.guid,
                secondary_guid: '',
                action_type: 'added',
                type: 'task',
                info: 'Start ' + gantt.templates.task_date(task.start_date), // + '<br>' + 'Now is ' + new Date().getDate() + " " + months[new Date().getMonth()] + " " + new Date().getFullYear(),
                afterForm: '',
                testBefore: '',
                changeString: '',
                task_text: task.text
            };
            saveActivity(activitydata);
        }, 2000);
    } else {
        setTimeout(function() {
            const d = new Date();
            let activitydata = {
                _token: token,
                id: task.id,
                programme_id: programme.id,
                gantt_data: gantt.serialize(),
                primary_guid: task.guid,
                secondary_guid: '',
                action_type: 'edited',
                type: 'task',
                info: 'Start ' + gantt.templates.task_date(task.start_date), // + '<br>' + 'Now is ' + new Date().getDate() + " " + months[new Date().getMonth()] + " " + new Date().getFullYear(),
                afterForm: '',
                testBefore: '',
                changeString: '',
                task_text: task.text
            };
            saveActivity(activitydata);
        }, 2000);
    }
}

function saveTask(task) {
    let data = {
        _token: token,
        id: task.id,
        programme_id: programme.id,
        parent: task.parent,
        guid: task.guid,
        type: task.type,
        text: task.text,
        resource_group_id: task.resource_group_id ? task.resource_group_id : 0,
        resource_id: task.resource_id ? task.resource_id : '0',
        progress: task.progress,
        color: task.color,
        calendar_id: task.calendar_id,
        start_date: moment(task.start_date).format('YYYY-MM-DD hh:mm:ss'),
        end_date: moment(task.end_date).format('YYYY-MM-DD hh:mm:ss'),
        planned_start: moment(task.planned_start).format('YYYY-MM-DD hh:mm:ss'),
        planned_end: moment(task.planned_end).format('YYYY-MM-DD hh:mm:ss'),
    };

    return new Promise((resolve, reject) => {
        $.ajax({
            url: saveUrl.replace('?', task.id),
            type: "POST",
            data,
            success: function (res) {
                if (!res.success) {
                    errorMsg(res.message);
                    return;
                }
                successMsg(res.message);
                resolve();
            }
        }).fail(res => {
            showValidationErrors(res);
        });
    });
}

function deleteCurrTask() {
    let task = gantt.getTask(ganttConf.current_task.id);
    swalConfirm('Are you sure want to delete the task?', '', (confirmed) => {
        if (confirmed) {
            deleteTask(ganttConf.current_task.id)
                .then((res) => {
                    $('#lightboxModal').modal('hide');
                    gantt.clearAll();
                    // if(contract_key_date_name){
                    //     for(var i = 0; i< contract_key_date.length; i++){
                    //         gantt.addTask({
                    //             text        : contract_key_date_name[i],
                    //             type        : "milestone",
                    //             start_date  : contract_key_date[i],
                    //             readonly    : true,
                    //             editable    : false,
                    //             color       : "#299794"
                    //         }, i);
                    //     }
                    // }
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
                    const d = new Date();
                    setTimeout(function() {
                        let data = {
                            _token: token,
                            id: task.id,
                            programme_id: programme.id,
                            gantt_data: gantt.serialize(),
                            primary_guid: task.guid,
                            secondary_guid: '',
                            action_type: 'deleted',
                            type: task.type,
                            info: 'Delete ' + d.getFullYear() + '. ' + d.getMonth() + '. ' + d.getDate(),
                            afterForm: '',
                            testBefore: '',
                            changeString: '',
                            task_text: task.text
                        };
                        return saveActivity(data);
                    }, 2000);
                }
            );
        }
    });
}

function deleteTask(id) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: saveUrl.replace('?', ganttConf.current_task.id),
            type: "DELETE",
            data: { _token: token, id },
            success: function (res) {
                if (!res.success) {
                    errorMsg(res.message);
                    return;
                }
                gantt.deleteTask(ganttConf.current_task.id);
                successMsg(res.message);
                resolve(res.message);
            }
        }).fail(res => {
            showValidationErrors(res);
        });
    });
}

function getResourceColumns() {
    let resourceColumns = JSON.parse(columns[0].resource_columns)[0];
    let ResourceColumnArray = [];
    Object.keys(resourceColumns).filter(k => resourceColumns[k] === true).map(k => {
        let col = prepareResourceColumnInsert(k);
        ResourceColumnArray.push(col);
    });
    var resourceArray = {
        columns: ResourceColumnArray
    };
    return resourceArray;
}

function prepareResourceColumnInsert(columnName) {
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
            template: function (resource) {
                var tasks = getResourceTasks(resource.id);

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
            template: function (resource) {
                var tasks = getResourceTasks(resource.id);
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
            template: function (resource) {
                var tasks = getResourceTasks(resource.id);
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
            template: function (resource) {

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
}
//Zoom and Date
function zoom_in() {
    gantt.ext.zoom.zoomIn();
    gantt.$zoomToFit = false;
}

function zoom_out() {
    gantt.ext.zoom.zoomOut();
    gantt.$zoomToFit = false;
}

function saveConfig() {
    var config = gantt.config;
    cachedSettings = {};
    cachedSettings.scales = config.scales;
    cachedSettings.start_date = config.start_date;
    cachedSettings.end_date = config.end_date;
    cachedSettings.scroll_position = gantt.getScrollState();
}

var cachedSettings = {};

function restoreConfig() {
    applyConfig(cachedSettings);
}

function applyConfig(config, dates) {

    gantt.config.scales = config.scales;

    // restore the previous scroll position
    if (config.scroll_position) {
        setTimeout(function(){
            gantt.scrollTo(config.scroll_position.x, config.scroll_position.y)
        },4)
    }
}

function zoomToFit() {
    var project = gantt.getSubtaskDates(),
        areaWidth = gantt.$task.offsetWidth,
        scaleConfigs = zoomConfig.levels;

    for (var i = 0; i < scaleConfigs.length; i++) {
        var columnCount = getUnitsBetween(project.start_date, project.end_date, scaleConfigs[i].scales[scaleConfigs[i].scales.length-1].unit, scaleConfigs[i].scales[0].step);
        if ((columnCount + 2) * gantt.config.min_column_width <= areaWidth) {
            break;
        }
    }

    // if (i == scaleConfigs.length) {
    //     i--;
    // }
    i--;

    gantt.ext.zoom.setLevel(scaleConfigs[i].name);
    applyConfig(scaleConfigs[i], project);
}

// get number of columns in timeline
function getUnitsBetween(from, to, unit, step) {
    var start = new Date(from),
        end = new Date(to);
    var units = 0;
    while (start.valueOf() < end.valueOf()) {
        units++;
        start = gantt.date.add(start, step, unit);
    }
    return units;
}

var zoomConfig = {
    levels: [
        // hours
        {
            name:"Hour",
            scale_height: 27,
            scales:[
                {unit:"day", step: 1, format:"%d %M"},
                {unit:"hour", step: 1, format:"%H:%i"},
            ]
        },
        // days
        {
            name:"Day",
            scale_height: 27,
            scales:[
                {unit: "day", step: 1, format: "%d %M"}
            ]
        },
        // weeks
        {
            name:"Week",
            scale_height: 50,
            scales:[
                {unit: "week", step: 1, format: function (date) {
                        var dateToStr = gantt.date.date_to_str("%d %M");
                        var endDate = gantt.date.add(date, -6, "day");
                        var weekNum = gantt.date.date_to_str("%W")(date);
                        return "#" + weekNum + ", " + dateToStr(date) + " - " + dateToStr(endDate);
                    }},
                {unit: "day", step: 1, format: "%j %D"}
            ]
        },
        // months
        {
            name:"Month",
            scale_height: 50,
            scales:[
                {unit: "month", step: 1, format: "%F, %Y"},
                {unit: "week", step: 1, format: function (date) {
                        var dateToStr = gantt.date.date_to_str("%d %M");
                        var endDate = gantt.date.add(gantt.date.add(date, 1, "week"), -1, "day");
                        return dateToStr(date) + " - " + dateToStr(endDate);
                    }}
            ]
        },
        // quarters
        {
            name:"Quarter",
            height: 50,
            scales:[
                {
                    unit: "quarter", step: 3, format: function (date) {
                        var dateToStr = gantt.date.date_to_str("%M %y");
                        var endDate = gantt.date.add(gantt.date.add(date, 3, "month"), -1, "day");
                        return dateToStr(date) + " - " + dateToStr(endDate);
                    }
                },
                {unit: "month", step: 1, format: "%M"},
            ]
        },
        // years
        {
            name:"Year",
            scale_height: 50,
            scales:[
                {unit: "year", step: 5, format: function (date) {
                        var dateToStr = gantt.date.date_to_str("%Y");
                        var endDate = gantt.date.add(gantt.date.add(date, 5, "year"), -1, "day");
                        return dateToStr(date) + " - " + dateToStr(endDate);
                    }}
            ]
        },
        // decades
        // {
        //     name:"Year",
        //     scale_height: 50,
        //     scales:[
        //         {unit: "year", step: 100, format: function (date) {
        //                 var dateToStr = gantt.date.date_to_str("%Y");
        //                 var endDate = gantt.date.add(gantt.date.add(date, 100, "year"), -1, "day");
        //                 return dateToStr(date) + " - " + dateToStr(endDate);
        //             }},
        //         {unit: "year", step: 10, format: function (date) {
        //                 var dateToStr = gantt.date.date_to_str("%Y");
        //                 var endDate = gantt.date.add(gantt.date.add(date, 10, "year"), -1, "day");
        //                 return dateToStr(date) + " - " + dateToStr(endDate);
        //             }},
        //     ]
        // },
    ],
    element: function(){
        return gantt.$root.querySelector(".gantt_task");
    }
};

gantt.config.fit_tasks = true;


gantt.ext.zoom.init(zoomConfig);

gantt.ext.zoom.setLevel("Day");

gantt.$zoomToFit = true;
//Display and BaseLine
function toggleSlack(toggle) {
    toggle.enabled = !toggle.enabled;
    if (toggle.enabled) {
        toggle.innerHTML = "<i class='mdi mdi-sail-boat font-size-16 align-middle text-warning'></i> Float";
        //declaring custom config
        gantt.config.show_slack = true;
    } else {
        toggle.innerHTML = "<i class='mdi mdi-sail-boat font-size-16 align-middle'></i> Float";
        gantt.config.show_slack = false;
    }
    gantt.render();
}

function updateCriticalPath(toggle) {
    toggle.enabled = !toggle.enabled;
    if (toggle.enabled) {
        toggle.innerHTML =
            "<i class='mdi mdi-lightning-bolt font-size-16 align-middle text-danger'></i> Critical Path";
        gantt.config.highlight_critical_path = true;
    } else {
        toggle.innerHTML = "<i class='mdi mdi-lightning-bolt font-size-16 align-middle'></i> Critical Path";
        gantt.config.highlight_critical_path = false;
    }
    gantt.render();
}
//Dropdown Menu-Show Baseline
var isDefault = true;

$('.dropdown-menu').on('click', '#baselinePath', function () {
    if (isDefault == true) {
        $("#baselinePath").html('' +
            '<div style="display: inline-block;border-radius: 2px; opacity: 0.6; height: 8px; width: 15px; margin-right: 4px; background: #f90;">' +
            '</div>' +
            '<div style="display: inline-block;">' +
                'Show Baseline' +
            '</div>');
        $('.baseline').css("display", "none");
        isDefault = false;
    } else {
        $("#baselinePath").html('<div style="display: inline-block;border-radius: 2px; opacity: 0.6; height: 8px; width: 15px; margin-right: 4px; background: #f90;"></div><div style="display: inline-block;">Hide Baseline</div>');
        $('.baseline').css("display", "block");
        isDefault = true;
    }
});

function generateGUID() {
    var S4 = function () {
        var output = (((1 + Math.random()) * 0x10000) | 0).toString(16).substring(1).toUpperCase();
        return output;
    };
    return (S4() + S4() + "-" + S4() + "-" + S4() + "-" + S4() + "-" + S4() + S4() + S4());
}

function toggleGroups(input) {
    gantt.$groupMode = !gantt.$groupMode;
    if (gantt.$groupMode) {
        input.value = "show gantt view";

        var groups = gantt.$resourcesStore.getItems().map(function (item) {
            var group = gantt.copy(item);
            group.group_id = group.id;
            group.id = gantt.uid();
            return group;
        });

        gantt.groupBy({
            groups: groups,
            relation_property: gantt.config.resource_property,
            group_id: "group_id",
            group_text: "text",
            delimiter: ", ",
            default_group_label: "Not Assigned"
        });
    } else {
        input.value = "show resource view";
        gantt.groupBy(false);
    }
}

(function () {
    gantt.addTaskLayer(function addSlack(task) {
        if (!gantt.config.show_slack) {
            return null;
        }

        var slack = gantt.getFreeSlack(task);

        if (!slack) {
            return null;
        }
        var state = gantt.getState().drag_mode;

        if (state == 'resize' || state == 'move') {
            return null;
        }

        var slackStart = new Date(task.end_date);
        var slackEnd = gantt.calculateEndDate(slackStart, slack);
        var sizes = gantt.getTaskPosition(task, slackStart, slackEnd);
        var el = document.createElement('div');

        el.className = 'slack';
        el.style.left = sizes.left + 'px';
        el.style.top = sizes.top + 2 + 'px';
        el.style.width = sizes.width + 'px';
        el.style.height = sizes.height + 'px';

        return el;
    });
})();

var duration = function (a, b, c) {
    var res = gantt.calculateDuration(a.getDate(false), b.getDate(false));
    c.innerHTML = res + ' days';
};

function byId(list, id) {
    for (var i = 0; i < list.length; i++) {
        if (list[i].key == id)
            return list[i].label || "";
    }
    return "N/A";
}

function groupBy(objectArray, property) {
    return objectArray.reduce(function (acc, obj) {
        let key = obj[property]
        if (!acc[key]) {
            acc[key] = []
        }
        acc[key].push({
            key: obj.id,
            label: obj.name
        })
        return acc
    }, {})
}

function onDragEnd(startPoint, endPoint, startDate, endDate, tasksBetweenDates, tasksInRow) {
    if (tasksInRow.length === 1) {
        var parent = tasksInRow[0];
        gantt.createTask({
            text: "Subtask of " + parent.text,
            start_date: startDate, //gantt.roundDate(startDate),
            end_date: endDate //gantt.roundDate(endDate)
        }, parent.id);
    } else if (tasksInRow.length === 0) {
        gantt.createTask({
            text: "New task",
            start_date: startDate, //gantt.roundDate(startDate),
            end_date: endDate //gantt.roundDate(endDate)
        });
    }
}

var durationformatter = gantt.ext.formatters.durationFormatter({
    enter: "day",
    store: "minute", // duration_unit
    format: "day",
    hoursPerDay: 8,
    hoursPerWeek: 40,
    daysPerMonth: 30
});

var durationEditor = {
    type: "duration",
    map_to: "duration",
    formatter: durationformatter,
    min: 0,
    max: 1000
};

$(document).ready(function () {
    $('#mspFile').on('change', function () {
        $("label#mspFile-label").hide();
        $("input#mspFile").show();
        $("button#mspImportBtn").show();
    });
});

$(document).ready(function () {
    $('#primaveraFile').on('change', function () {
        $("label#primaveraFile-label").hide();
        $("input#primaveraFile").show();
        $("button#primaveraImportBtn").show();
    });
});

$(document).ready(function () {
    $('#taskimageupload').on('change', function () {
        $("button#taskuploadbutton").show();
    });
});

/////////////////////////////C_C///////////////////////////////

function addResourceGroupRow(){
    var tblHtml = $("#resource_group_table").html();
    tableIndex += 1;
    tblHtml += '' +
        '<tr id="added_row[' + tableIndex + ']">' +
            '<td>' +
                '<input name="group_name[' + tableIndex + ']" id="added_name[' + tableIndex + ']" oninput="updateText(' + tableIndex + ')" style="width: 100%; border: none">' +
                '<input name="group_id" style="display: none;">' +
            '</td>' +
            '<td>' +
                '<select class="form-control mdb-select dropdown-primary" name="group_calendar" style="font-size: 0.8em;">' +
                    $("#resource_calendars").html() +
                '</select>' +
            '</td>' +
            '<td>' +
                '&nbsp;&nbsp;' +
                '<a href="javascript:void(0)" onclick="deleteRow(' + tableIndex + ')"><i class="fas fa-trash"></i></a>' +
            '</td>' +
        '</tr>';
    $("#resource_group_table").html(tblHtml);
}

$('#GroupForm').on('submit', function (e){
    e.preventDefault();
    var data=$("#GroupForm").serializeArray();
    var programme_id = programme.id;
    $.ajax({
        url: saveUrl.replace('task/?', 'create-group'),
        type: "POST",
        data: {
            "_token": token,
            programme_id: programme_id,
            data:data
        },
        success: function (response, status) {
            showdata();
            $("#GroupForm").trigger("reset");
            successMsg(response.success);
        },
        error: function (response, status) {
            errorMsg("InputData Incorrect!");
        },
    });

});

function updateText(index) {
    let text = document.getElementById("added_name[" + index + "]").value;
    document.getElementById("added_name[" + index + "]").setAttribute('value', text);
}

function deleteRow(index) {
    document.getElementById("added_row[" + index + "]").remove();
}

function saveActivity(paramdata) {
    let data = paramdata;
    return new Promise((resolve, reject) => {
        $.ajax({
            url: saveUrl.replace('task/?', 'snapshot_gantt'),
            type: "POST",
            data: data,
            success: function (res) {
                reloadActivityFeed();
                // resolve();
            }
        }).fail(res => {
            showValidationErrors(res);
        });
    });
}

var curActiveID = 0;
var prevActiveID = 0;

var fileDnD = fileDragAndDrop();

gantt.attachEvent("onGanttReady", function() {
    fileDnD.init(gantt.$container);
});

function rollbackActivity(activityId) {

    fileDnD.showUpload();
        // modal_import_microsoft_project.hide();


    let data = {
        _token: token,
        activity_id: activityId,
        programme_id: programme.id
    };

    prevActiveID = curActiveID;
    curActiveID = activityId;
    document.getElementById("rollback_" + curActiveID).className = 'roll-active';

    if(prevActiveID != 0)
    {
        document.getElementById("rollback_" + prevActiveID).className = '';
    }

    return new Promise((resolve, reject) => {
        $.ajax({
            url: saveUrl.replace('task/?', 'rollbackActivity'),
            type: "POST",
            data,
            success: function (res) {
                gantt.clearAll();
                // if(contract_key_date_name){
                //     for(var i = 0; i< contract_key_date.length; i++){
                //         gantt.addTask({
                //             text        : contract_key_date_name[i],
                //             type        : "milestone",
                //             start_date  : contract_key_date[i],
                //             readonly    : true,
                //             editable    : false,
                //             color       : "#299794"
                //         }, i);
                //     }
                // }
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
                resolve();
                fileDnD.hideOverlay();
            }
        }).fail(res => {
            showValidationErrors(res);
            fileDnD.hideOverlay();
        });
    });

}

$("#btn_link_del").click(function () {
    gantt.deleteLink($("#linkId").val());
    $("#linkModal").modal('hide');
});


///////////////////////////////////////////////////////////////
