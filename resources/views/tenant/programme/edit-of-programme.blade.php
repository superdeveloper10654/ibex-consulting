@extends('tenant.layouts.master')
@section('title')
    Edit programme {{ $programme->name }}
@endsection

@push('css')
    <link href="{{ URL::asset('assets/css/gantt.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <x-resource.breadcrumb :resource="$programme" :title="'Edit programme ' . $programme->name" />

    <div class="row justify-content-center">
        <div class="col-xl-9 col-lg-8">
            <div class="card p-5">
                <div class="card-body">
                    <p class="card-title-desc">Please complete all fields below</p>
                    <form id="edit-programme" autocomplete="off">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <x-form.input label="Name" name="name" value="{{ $programme->name }}" />
                            </div>
                            <div class="col-sm-6 mb-3">
                                <x-form.select label="Contract"
                                    name="contract"
                                    :selected="$programme->contract_id"
                                    :options="$contracts->pluck('contract_name', 'id')"
                                />
                            </div>
                            <div class="mb-3">
                                <x-form.input type="hidden" name="id" value="{{ $programme->id }}" />
                            </div>
                        </div>
                        <button type="button" onclick="showCalendarModal(this)"
                            class="btn btn-light btn-rounded waves-effect waves-light mx-1">
                            <i class="mdi mdi-calendar-month"></i> Calendars
                        </button>
                        <hr>
                        <div class="row float-end row mt-5 pb-3">
                            <button type="submit"
                                class="btn btn-success btn-rounded w-md waves-effect waves-light">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('tenant.gantt.modals.calendars')
@section('script')
    {{-- <script src="{{ URL::asset('assets/js/pages/gantt-fn.js') . '?v=' . filemtime(public_path('assets/js/pages/gantt-fn.js')) }}"></script>
    <script src="{{ URL::asset('assets/js/pages/gantt-conf.js') . '?v=' . filemtime(public_path('assets/js/pages/gantt-conf.js')) }}"></script> --}}
    {{-- <script src="{{ URL::asset('assets/js/pages/gantt.js') . '?v=' . filemtime(public_path('assets/js/pages/gantt.js')) }}"></script> --}}
    <script>
    window.ibex_gantt_config = {
            currentZoomLevel: "day",
            testDTPicker: null,
            autoSchedulerRunning: false,
            filterType: 1,
            filterValue: "",
            resourceConfig: null,
            activeCalendarOverrides: [],
            calendarOverrides: {!! json_encode($calendar_overrides) !!}
        };
        const calendars = {!! json_encode($calendars) !!};
        const programme = {!! json_encode($programme) !!};
        const saveUrl = "{{ t_route('task.save', '?') }}";
        const token = "{{ csrf_token() }}";
        jQuery(($) => {
            $('#edit-programme').on('submit', function(e) {
                e.preventDefault();
                removeFormErrors(this);

                form_ajax("{{ t_route('programmes.update', $programme->id) }}", this, {
                    redirect: "{{ t_route('programmes') }}"
                });
            });
        });
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
    console.log(task_calendar_edit_id);
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
    $('#resource_edit_calendar_id').prop('selectedIndex', 0);
    $.ajax({
        url: saveUrl.replace('task/?', 'GetResources'),
        type: "POST",
        data: {
            "_token": token,
            programme_id: programme_id,
        },
        success: function (result) {
            var option = '<option value="">Select Group</option>';
            var tr =
                '<thead><tr><th scope="col">Name</th><th scope="col">Action</th></tr></thead><tbody> ';
            var resourcess = result.resources;
            var resources_item = result.child_parent;
            $.each(resourcess, function (index) {
                if (resourcess[index].parent_id == 0) {
                    option += '<option value=' + resourcess[index].id + '>' + resourcess[index]
                        .name + '</option>';
                    tr += '<tr><td>' + resourcess[index].name +
                        '</td><td><a href="javascript:void(0)" onclick="editgroup(' +
                        resourcess[index].id +
                        ')"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;<a href="javascript:void(0)" onclick="deletegroup(' +
                        resourcess[index].id + ')"><i class="fas fa-trash"></i></a></td></tr>';
                }
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
    function deleteCurrTask() {
    swalConfirm('Are you sure want to delete the task?', '', (confirmed) => {
        if (confirmed) {
            deleteTask(ganttConf.current_task.id)
                .then((res) => {
                    $('#lightboxModal').modal('hide');
                });
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
    </script>
@endsection
