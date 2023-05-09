<script src="{{ URL::asset('assets/js/caleran.min.js') }}"></script>
<script>
    // $(document).ready(function() {
    //     $('#NewtaskForm').validate({

    //         rules: {
    //             "text": {
    //                 required: true
    //             },
    //             "progress": {
    //                 required: true
    //             },
    //             "planned_start": {
    //                 required: true

    //             },
    //             "start_date": {
    //                 required: true

    //             },
    //             "end_date": {
    //                 required: true
    //             }
    //         },
    //         messages: {
    //             text: {
    //                 required: "Please enter the task name",
    //             },
    //         }
    //     });
    // })

    window.ibex_gantt_config = {
        rangeStartDate: new Date($("#range_start_date").val()),
        rangeEndDate: new Date($("#range_end_date").val()),
        currentZoomLevel: "day", // was week
        testDTPicker: null,
        autoSchedulerRunning: false,
        filterType: 1,
        filterValue: "",
        resourceConfig: null,
        activeCalendarOverrides: [],
    };

    window.calendars = JSON.parse('{!!json_encode($calendar)!!}')
    window.cal_id = $('#calendar_id').val();
    window.planned_duration = null;
    window.duration = null;
    window.calendar = calendars[cal_id]
    window.ibex_gantt_config.calendarOverrides = JSON.parse('{!!$calendar_overrides!!}');
    window.ibex_gantt_config.calendars = calendars;
    window.ibex_gantt_config.periodDescriptor = 1;
    window.ibex_gantt_config.columns = $("#gantt_columns").val();
    window.ibex_gantt_config.resources = JSON.parse('{!!json_encode($resources)!!}');
    window.ibex_gantt_config.resource_groups = JSON.parse('{!!json_encode($groups)!!}');

    window.getCalendarOverrides = function getCalendarOverrides(calendarID) {
        var calendarOverrides = [];
        $.each(window.ibex_gantt_config.calendarOverrides, function(index) {
            if (window.ibex_gantt_config.calendarOverrides[index].calendar_id == calendarID) {
                calendarOverrides.push(window.ibex_gantt_config.calendarOverrides[index]);
                return calendarOverrides;
            }
        });
        return calendarOverrides;
    }

    window.padLeadingZero = function padLeadingZero(number) {
        return (number < 10) ? ("0" + number) : number;
    }

    window.getNextWorkingDate = function getNextWorkingDate(calendarID, includeCurrentDate = false, startDate = null) {
        var validDay = false;
        var date;
        var calendar = getCalendar(calendarID);
        var calendarOverrides = getCalendarOverrides(calendarID);

        if (includeCurrentDate == true) {
            if (startDate == null) {
                date = moment().format("YYYY-MM-DD");
            } else {
                date = moment(startDate).format("YYYY-MM-DD");
            }
        } else {
            if (startDate == null) {
                date = moment().add(1, 'day').format("YYYY-MM-DD");
            } else {
                date = moment(startDate).add(1, 'day').format("YYYY-MM-DD");
            }
        }
        do {
            var validDayLoop = true;

            if (calendarOverrides.length > 0) {

                for (var override of calendarOverrides) {
                    var dateCompare = moment(date);
                    var startDate = moment(override['start_date']);
                    var endDate = moment(override['end_date']);
                    if (dateCompare.isBetween(startDate, endDate, null, []) == true) {
                        validDayLoop = false;
                    }
                }
            } else {

                validDayLoop = true;

            }
            if (validDayLoop == true) {
                switch (moment(date).isoWeekday()) {
                    case 1:
                        if (calendar.working_day_monday != "1") {
                            validDayLoop = false;
                        }
                        break;
                    case 2:
                        if (calendar.working_day_tuesday != "1") {
                            validDayLoop = false;
                        }
                        break;
                    case 3:
                        if (calendar.working_day_wednesday != "1") {
                            validDayLoop = false;
                        }
                        break;
                    case 4:
                        if (calendar.working_day_thursday != "1") {
                            validDayLoop = false;
                        }
                        break;
                    case 5:
                        if (calendar.working_day_friday != "1") {
                            validDayLoop = false;
                        }
                        break;
                    case 6:
                        if (calendar.working_day_saturday != "1") {
                            validDayLoop = false;
                        }
                        break;
                    case 7:
                        if (calendar.working_day_sunday != "1") {
                            validDayLoop = false;
                        }
                        break;
                }
            }
            if (validDayLoop == false) {
                date = moment(date).add(1, 'day').format("YYYY-MM-DD");
                validDay = false;
            } else {
                validDay = true;
                break;
            }
        }
        while (validDay == false);
        var buildDateTime = moment(date).format("DD/MM/YYYY") + " " + padLeadingZero(calendar.start_hour) + ":" +
            padLeadingZero(calendar.start_minute);
        return buildDateTime;
    }

    window.getCalendar = function getCalendar(calendarID) {
        var calendar = null;
        $.each(window.ibex_gantt_config.calendars, function(index) {
            if (window.ibex_gantt_config.calendars[index].id == calendarID) {
                calendar = window.ibex_gantt_config.calendars[index];
                return calendar;
            }
        });
        return calendar;
    }

    // gantt.config.start_date = window.ibex_gantt_config.rangeStartDate;
    // gantt.config.end_date = window.ibex_gantt_config.rangeEndDate;

    if (calendar) {
        window.ibex_gantt_config.globalNonWorkingDays = [];
        if (calendar.working_day_monday == 0) {
            window.ibex_gantt_config.globalNonWorkingDays.push(1);
        }
        if (calendar.working_day_tuesday == 0) {
            window.ibex_gantt_config.globalNonWorkingDays.push(2);
        }
        if (calendar.working_day_wednesday == 0) {
            window.ibex_gantt_config.globalNonWorkingDays.push(3);
        }
        if (calendar.working_day_thursday == 0) {
            window.ibex_gantt_config.globalNonWorkingDays.push(4);
        }
        if (calendar.working_day_friday == 0) {
            window.ibex_gantt_config.globalNonWorkingDays.push(5);
        }
        if (calendar.working_day_saturday == 0) {
            window.ibex_gantt_config.globalNonWorkingDays.push(6);
        }
        if (calendar.working_day_sunday == 0) {
            window.ibex_gantt_config.globalNonWorkingDays.push(0);
        }
        var overrides = getCalendarOverrides(calendar.id);
        for (i = 0; i < overrides.length; i++) {
            var startDateOverride = overrides[i].start_date;
            var endDateOverride = overrides[i].end_date;
            var nonWorkingDatesOverride = enumerateDaysBetweenDates(startDateOverride, endDateOverride, calendar.id);
            for (j = 0; j < nonWorkingDatesOverride.length; j++) {
                window.ibex_gantt_config.globalNonWorkingDays.push(nonWorkingDatesOverride[j]);
            }
        }
        // $('#task_edit_start_date').datepicker('setDaysOfWeekDisabled', window.ibex_gantt_config.globalNonWorkingDays);
        // Set start date to next avail
        var dateNow = moment().format("YYYY-MM-DD HH:mm");
        if (cal_id != null)
            var setNext = getNextWorkingDate(cal_id, false, dateNow);
        // var setNext = getNextWorkingDate($('#task_edit_calendar_id').val(), false, dateNow);
        else
            var setNext = getNextWorkingDate(cal_id, false, dateNow);
        // var setNext = getNextWorkingDate($('#task_edit_calendar_id_init').val(), false, dateNow);

        // $('#task_edit_start_date').val(moment(setNext, "DD/MM/YYYY").format("ddd D MMM YYYY"));
        // $('#task_edit_start_time').val(moment(setNext, "DD/MM/YYYY").format("HH:mm"));
    }

    var fillInputs = function(instance, startDate, endDate) {
        days = endDate.diff(startDate, 'days') + 1;

        for (i = days; i > 0; i--) {

            if (ibex_gantt_config.globalNonWorkingDays.includes(startDate.day())) {
                days -= 1;
                // console.log(startDate.day(), 'day no', ibex_gantt_config.globalNonWorkingDays)
            }
            startDate.subtract(1, 'days')

        }

        (instance.elem.id == 'planned_time_period' || instance.elem.id == 'planned_time_period_edit') ? planned_duration = days: duration = days;
        (instance.elem.id == 'time_period_edit' || instance.elem.id == 'planned_time_period_edit') && edit();

        // var workingDays = [];
        // if (calendar.working_day_sunday == 1) {
        //     workingDays.push(0);
        // }
        // if (calendar.working_day_monday == 1) {
        //     workingDays.push(1);
        // }
        // if (calendar.working_day_tuesday == 1) {
        //     workingDays.push(2);
        // }
        // if (calendar.working_day_wednesday == 1) {
        //     workingDays.push(3);
        // }
        // if (calendar.working_day_thursday == 1) {
        //     workingDays.push(4);
        // }
        // if (calendar.working_day_friday == 1) {
        //     workingDays.push(5);
        // }
        // if (calendar.working_day_saturday == 1) {
        //     workingDays.push(6);
        // }
    };

    function initializeCaleRan() {

        $(".caleran").caleran({
            enableKeyboard: false,
            // startDate: moment(), 
            // endDate: moment(), 
            startOnMonday: true,
            startEmpty: true,
            endEmpty: true,
            format: "DD/MM/YYYY",
            disableDays: function(day) {
                var disabledDays = [];
                if (calendar.working_day_sunday == 0) {
                    disabledDays.push(0);
                }
                if (calendar.working_day_monday == 0) {
                    disabledDays.push(1);
                }
                if (calendar.working_day_tuesday == 0) {
                    disabledDays.push(2);
                }
                if (calendar.working_day_wednesday == 0) {
                    disabledDays.push(3);
                }
                if (calendar.working_day_thursday == 0) {
                    disabledDays.push(4);
                }
                if (calendar.working_day_friday == 0) {
                    disabledDays.push(5);
                }
                if (calendar.working_day_saturday == 0) {
                    disabledDays.push(6);
                }
                if (calendarOverrides.length > 0) {
                    for (var override of calendarOverrides) {
                        var over_startDate = moment(override['start_date']);
                        var over_endDate = moment(override['end_date']);
                        if (day.isBetween(over_startDate, over_endDate, 'days', '[]')) {
                            return true;
                        }
                    }
                }
                return disabledDays.includes(day.day());
            },
            oninit: function(instance) {

            },
            onafterselect: function(instance, startDate, endDate) {
                fillInputs(instance, startDate, endDate)
            }
        });
    }

    initializeCaleRan();

    function setDisable() {
        initializeCaleRan()
        // dateInput.set('disableDays',ibex_gantt_config.globalNonWorkingDays);

    }

    window.generateGUID = function generateGUID() {
        var S4 = function() {
            var output = (((1 + Math.random()) * 0x10000) | 0).toString(16).substring(1).toUpperCase();
            return output;
        };
        return (S4() + S4() + "-" + S4() + "-" + S4() + "-" + S4() + "-" + S4() + S4() + S4());
    }

    function create() {
        var IsValid = $("#NewtaskForm").valid();
        if (IsValid) {
            let form = new FormData(document.getElementById('NewtaskForm'));
            let time_period = $('#time_period').val()
            let planned_time_period = $('#planned_time_period').val()
            time_period && form.append('picker_start_date', moment(time_period.split(' ')[0] + ' 00:00:00', 'DD/MM/YYYY HH:mm:ss').format('YYYY/MM/DD HH:mm:ss'))
            time_period && form.append('start_date', moment(time_period.split(' ')[0] + ' 00:00:00', 'DD/MM/YYYY HH:mm:ss').format('YYYY/MM/DD HH:mm:ss'))
            time_period && form.append('picker_end_date', moment(time_period.split(' ').pop() + ' 23:59:00', 'DD/MM/YYYY HH:mm:ss').format('YYYY/MM/DD HH:mm:ss'))
            time_period && form.append('end_date', moment(time_period.split(' ').pop() + ' 23:59:00', 'DD/MM/YYYY HH:mm:ss').format('YYYY/MM/DD HH:mm:ss'))
            planned_time_period && form.append('planned_start', moment(planned_time_period.split(' ')[0] + ' 00:00:00', 'DD/MM/YYYY HH:mm:ss').format('YYYY/MM/DD HH:mm:ss'))
            planned_time_period && form.append('planned_end', moment(planned_time_period.split(' ').pop() + ' 23:59:00', 'DD/MM/YYYY HH:mm:ss').format('YYYY/MM/DD HH:mm:ss'))
            form.append('duration', planned_duration)
            form.append('duration_worked', duration)
            form.append('guid', generateGUID())

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "/api/task",
                method: 'POST',
                data: form,
                processData: false,
                contentType: false,
                success: (res) => {
                    task = res.task
                    subTasks = res.subTasks
                    $('#modalForm').modal('toggle');
                    addTaskCard(task, subTasks)

                    // $(element).find('span').text(text)
                    // $(element).find('span').removeClass(function(index, className) {
                    //     return (className.match(/(^|\s)badge-soft-\S+/g) || []).join(' ');
                    // }).addClass(add)
                },
                error: (error) => {
                    console.log('error', error)
                }
            });
        }
    }

    function addTaskCard(task, subTasks) {

        var options = {
            weekday: 'short',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };

        deadline = task.deadline ? new Date(task.deadline).toLocaleDateString("en-GB", options) : task.deadline;


        let card = $(`#task-cards-${task.id}`);

        assigneeElements = ""
        $.each(task.assignees, function(index, assignee) {
            assigneeElements += `<div class="avatar-group-item">
                                    <a href="javascript: void(0);" class="d-inline-block" value="member-1">
                                        <img src=" ${assignee.avatar ?  (assignee.avatar.startsWith('/assets/images/') ? `{{asset('')}}${assignee.avatar.substring(1)}`:`{{tenant_asset(config('path.images.profiles'))}}/${assignee.avatar}`):`{{asset('/assets/images/companies/img-5.png')}}`}" alt="" class="rounded-circle avatar-xs">
                                    </a>
                                </div>`
        })

        subTaskElements = ""
        $.each(subTasks, function(index, subTask) {
            subTaskElements += `<div class="subtask-name d-flex justify-content-between align-items-center p-0" onclick="showTaskDetails(event,'${encodeURIComponent(JSON.stringify(subTask))}')">
                                                <div class="d-flex align-items-center" role="button" style="max-width:60%;">
                                                    <div class="">
                                                        <svg style="width:14px" class="border border-dark rounded-circle bg-transparent" viewBox="0 0 32 32" aria-hidden="true" focusable="false">
                                                            <path style="fill:transparent" d="M31,16c0,8.3-6.7,15-15,15S1,24.3,1,16S7.7,1,16,1S31,7.7,31,16z"></path>
                                                            <path d="M13.4,22.1c-0.3,0-0.5-0.1-0.7-0.3l-3.9-3.9c-0.4-0.4-0.4-1,0-1.4s1-0.4,1.4,0l3.1,3.1l8.1-8.1c0.4-0.4,1-0.4,1.4,0   s0.4,1,0,1.4l-8.9,8.9C13.9,22,13.7,22.1,13.4,22.1z"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="" style="margin-left: 4px;z-index:1">
                                                        <div class="" style="white-space: nowrap;text-overflow:ellipsis;overflow:hidden;">${subTask.text}</div>
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
                                                        
                                                    </div>
                                                </div>
                                            </div>`
        });
        // <div class="ml-2" role="button">
        //                                                     <svg class="action-icons" viewBox="0 0 32 32" aria-hidden="true" focusable="false">
        //                                                         <path d="M16,18c-4.4,0-8-3.6-8-8s3.6-8,8-8s8,3.6,8,8S20.4,18,16,18z M16,4c-3.3,0-6,2.7-6,6s2.7,6,6,6s6-2.7,6-6S19.3,4,16,4z M29,32c-0.6,0-1-0.4-1-1v-4.2c0-2.6-2.2-4.8-4.8-4.8H8.8C6.2,22,4,24.2,4,26.8V31c0,0.6-0.4,1-1,1s-1-0.4-1-1v-4.2C2,23,5,20,8.8,20h14.4c3.7,0,6.8,3,6.8,6.8V31C30,31.6,29.6,32,29,32z"></path>
        //                                                     </svg>
        //                                                 </div>


        // ${task.assignees.length!=0 ?
        //                                             `${assigneeElements}`:
        //                                             `<div class="mx-n2" role="button">
        //                                                 <svg class="action-icons" style="width: 32px;padding:5px" viewBox="0 0 32 32" aria-hidden="true" focusable="false">
        //                                                     <path d="M16,18c-4.4,0-8-3.6-8-8s3.6-8,8-8s8,3.6,8,8S20.4,18,16,18z M16,4c-3.3,0-6,2.7-6,6s2.7,6,6,6s6-2.7,6-6S19.3,4,16,4z M29,32c-0.6,0-1-0.4-1-1v-4.2c0-2.6-2.2-4.8-4.8-4.8H8.8C6.2,22,4,24.2,4,26.8V31c0,0.6-0.4,1-1,1s-1-0.4-1-1v-4.2C2,23,5,20,8.8,20h14.4c3.7,0,6.8,3,6.8,6.8V31C30,31.6,29.6,32,29,32z"></path>
        //                                                 </svg>
        //                                             </div>`}

        element = `
                                <div class="card task-box" onclick="showTaskDetails(event,'${encodeURIComponent(JSON.stringify(task))}')">
                                    <div class="card-body">
                                        <div class="mb-2 actions">
                                            <div class="dropdown float-end">
                                                <a href="#" class="dropdown-toggle arrow-none" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="mdi mdi-dots-vertical m-0 text-muted h5"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item edittask-details" href="#" id="taskedit" data-id="#cmptask-1" data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg">Edit</a>
                                                    <a class="dropdown-item deletetask" href="#" data-id="#cmptask-1">Delete</a>
                                                </div>
                                            </div> <!-- end dropdown -->
                                            <div class="float-end ml-2">
                                                <span class="badge rounded-pill badge-soft-${task.progress==0?'secondary':(task.progress==1?'success':'warning')} font-size-12">${task.progress==0?'Waiting':(task.progress==1?'Complete':'In Progress')}</span>
                                            </div>
                                            <div>
                                                <h5 class="font-size-15"><a href="javascript: void(0);" class="text-dark">${task.text}</a></h5>
                                                <p class="text-muted mb-4">${task.baseline_start??''}</p>
                                            </div>

                                            <div class="row justify-content-between align-items-center overflow-hidden">
                                                <div class="avatar-group col-auto task-assigne align-items-center text-nowrap " style="flex-wrap: unset;">

                                                    <label class="input-group-btn mb-0 main-task-date-label" style="visibility: ${task.deadline ? 'hidden':'visible'}" onclick="clickDate(event)">
                                                        <div role=" button" tabindex="0" class="mx-1" aria-disabled="false" aria-pressed="false">
                                                            <svg class="action-icons" style="width: 32px;padding:7px" viewBox="0 0 32 32" aria-hidden="true" focusable="false">
                                                                <path d="M24,2V1c0-0.6-0.4-1-1-1s-1,0.4-1,1v1H10V1c0-0.6-0.4-1-1-1S8,0.4,8,1v1C4.7,2,2,4.7,2,8v16c0,3.3,2.7,6,6,6h16c3.3,0,6-2.7,6-6V8C30,4.7,27.3,2,24,2z M8,4v1c0,0.6,0.4,1,1,1s1-0.4,1-1V4h12v1c0,0.6,0.4,1,1,1s1-0.4,1-1V4c2.2,0,4,1.8,4,4v2H4V8C4,5.8,5.8,4,8,4z M24,28H8c-2.2,0-4-1.8-4-4V12h24v12C28,26.2,26.2,28,24,28z"></path>
                                                            </svg>
                                                        </div>
                                                    </label>
                                                    ${task.deadline ? `
                                                    <input value="${deadline}" type="text" class="main-task-date-input date-input bg-transparent border-0 mx-n5" name="deadline" data-taskid="${task.id}" readonly="readonly" role="button"/  onclick="stopPropagation(event)" onchange="updateAttribute(event)">`
                                                    :
                                                    `<input type="text" class="main-task-date-input date-input bg-transparent border-0 mx-n5" name="deadline" data-taskid="${task.id}" readonly="readonly" role="button"/  onclick="stopPropagation(event)" onchange="updateAttribute(event)">`
                                                    }
                                                </div>

                                                ${subTasks.length>0 ?                       
                                                    `<div class="col-auto p-0 mt-1 toggle-sub-task" onclick="showSubTask(event)">
                                                        <span class="btn btn-outline-light btn-sm rounded-3 p-1 border-none" role="button" aria-label="Expand" tabindex="0">
                                                            <span class="mx-1">${subTasks.length}</span>
                                                            <svg class="" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                                                <path d="M20,15c-1.9,0-3.4,1.3-3.9,3H7c-2.8,0-5-2.2-5-5v-3h14.1c0.4,1.7,2,3,3.9,3c2.2,0,4-1.8,4-4s-1.8-4-4-4 c-1.9,0-3.4,1.3-3.9,3H2V3c0-0.6-0.4-1-1-1S0,2.4,0,3v10c0,3.9,3.1,7,7,7h9.1c0.4,1.7,2,3,3.9,3c2.2,0,4-1.8,4-4S22.2,15,20,15z M20,7c1.1,0,2,0.9,2,2s-0.9,2-2,2s-2-0.9-2-2S18.9,7,20,7z M20,21c-1.1,0-2-0.9-2-2s0.9-2,2-2s2,0.9,2,2S21.1,21,20,21z"></path>
                                                            </svg>
                                                            <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                                                <path class="arrow arrow-left" d="M17.5,10.7l-7.1-7.1C10,3.2,9.4,3,8.8,3.3c-0.6,0.2-1,0.8-1,1.4v14.9c0,0.6,0.4,1.2,1,1.4c0.2,0.1,0.4,0.1,0.6,0.1c0.4,0,0.8-0.2,1.1-0.5l7.1-7.1c0.4-0.4,0.6-0.9,0.6-1.5S17.9,11.1,17.5,10.7z"></path>
                                                                <path class="arrow arrow-down" style="display: none;" d="M20.9,9c-0.2-0.6-0.8-1-1.4-1h-15C3.9,8,3.4,8.4,3.1,9C2.9,9.5,3,10.2,3.5,10.6l7.1,7.1c0.4,0.4,0.9,0.6,1.5,0.6c0.5,0,1.1-0.2,1.5-0.6l7.1-7.1C21,10.2,21.1,9.5,20.9,9z"></path>
                                                            </svg>
                                                        </span>
                                                    </div>`:''
                                                }
                                            </div>
                                        </div>

                                        <div class="subtasks mt-2 col-md-12 overflow-hidden" style="max-height:0;">
                                            ${subTaskElements}
                                            <div class="mt-2 addsubtask" data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg" data-id="${task.id}" onclick="addSubTask(event)">
                                                <button data-id="${task.id}" class="btn btn-outline-light btn-md p-1 px-2 rounded-3" style="border:none ;color:#495057">
                                                    <span data-id="${task.id}" class=""><i class="fa fa-plus" style="color:#495057"></i></span>
                                                    <span data-id="${task.id}" class="">
                                                        &nbsp;Add subtask
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>`;

        if (card.length > 0) {
            card.html(element);
        } else {
            if (task.parent == 0) {

                taskElement = ` 
                                <div class="task" id = "task-cards-${task.id}">
                                    ${element} 
                                    </div>
                                `;

                if (task.progress == 0) {
                    $('#upcoming-task').append(taskElement)

                } else if (task.progress == 1) {
                    $('#complete-task').append(taskElement)

                } else {

                    $('#inprogress-task').append(taskElement)
                }
            }

        }
        $('.date-input').datepicker({
            format: "D, dd M yyyy"
        });
    }

    function stopPropagation(event) {
        event.stopPropagation()

    }

    function clickDate(event) {
        event.stopPropagation()
        $(event.target).next().click()
    }

    $(document).on('change', '.main-task-date-input', function() {
        // console.log('clic dyna')
        // Your Code
    });

    function updateAttribute(event) {

        hideFixedContent()

        $(event.target).prev().css('visibility', 'hidden')
        var name = $(event.target).prop('name');
        id = $(event.target).data('taskid')

        var values = {};
        values[name] = $(event.target).val();
        values['id'] = id;
        var url = '{{ t_route("updateTaskAttribute", ":id") }}';
        url = url.replace(':id', id);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: url,
            method: 'POST',
            data: values,
            success: (res) => {
                addTaskCard(res.task, res.subTasks)
            },
            error: (error) => {
                console.log('error', error)
            }
        });
    }

    $('#modalForm').on('hidden.bs.modal', function(e) {
        $(this).find(".create-input").val('').end()
    })
    $('#modalForm').on('shown.bs.modal', function(e) {
        duration = null
        planned_duration = null
        hideFixedContent()
    })
</script>