<script>
    $(function() {
        $('.date-input').datepicker({
            format: "D, dd M yyyy"
        });

        initialFixedContent()
    });

    function initialFixedContent() {
        let windowWidth = $(window).width()
        let width = 585;
        let left = windowWidth - 573;

        if (windowWidth <= 585) {
            width = windowWidth
            left = 12
        }

        $('.fixed-content').css({
            'left': windowWidth,
            'width': width
        })
    }

    function hideFixedContent() {

        $('.fixed-content').animate({
            "left": $(window).width() + 'px'
        }, 1000).removeClass('show');

    }

    function showFixedContent(event, taskdetails) {

        event.stopPropagation()
        // $('#modalForm').modal('hide');

        setTaskDetails(taskdetails)

        let windowWidth = $(window).width()
        let left = windowWidth - 573;

        if ($('.fixed-content').hasClass('show')) {
            $("div.spanner").addClass("show");
            $("div.overlay").addClass("show");
        } else {
            if (windowWidth <= 585) {
                left = 12
            }

            $('.fixed-content').animate({
                "left": left + 'px'
            }, 1000).addClass('show');

        }
    }

    function showTaskDetails(event, taskdetails) {

        showFixedContent(event, decodeURIComponent(taskdetails))

    }

    function showSubTaskDetails(taskdetails) {
        $("div.spanner").addClass("show");
        $("div.overlay").addClass("show");

        setTaskDetails(decodeURIComponent(taskdetails))
    }


    function setTaskDetails(taskdetails) {

        let task = JSON.parse(taskdetails)
        duration = task.duration
        planned_duration = task.duration_worked
        var options = {
            weekday: 'short',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };

        var periodoptions = {
            year: 'numeric',
            month: 'numeric',
            day: 'numeric'
        };


        $("#planned_time_period_edit").val(new Date(task.baseline_start).toLocaleDateString("en-GB", periodoptions) + ' - ' + new Date(task.baseline_end).toLocaleDateString("en-GB", periodoptions));
        $("#time_period_edit").val(new Date(task.start_date).toLocaleDateString("en-GB", periodoptions) + ' - ' + new Date(task.end_date).toLocaleDateString("en-GB", periodoptions));
        // instance.setStart(moment())

        task.deadline && $('#due-date').val(new Date(task.deadline).toLocaleDateString("en-GB", options))
        task.baseline_start && $('#planned_time_period').val(new Date(task.baseline_start).toLocaleDateString("en-GB", options))
        task.baseline_end && $('#planned-end-date').val(new Date(task.baseline_end).toLocaleDateString("en-GB", options))
        task.start_date && $('#start-date').val(new Date(task.start_date).toLocaleDateString("en-GB", options))
        task.end_date && $('#end-date').val(new Date(task.end_date).toLocaleDateString("en-GB", options))
        // $('#assignee').val(task.user_id)
        $('#addsubtaskdetail').data('id', task.id)
        $('.task-name').text(task.text)
        $('#task-name').val(task.text)
        $('#task-id').val(task.id)
        $('#parent').val(task.parent)
        $('#progress').val(task.progress)
        $('#group').val(task.resource_group_id)
        $('#resource').val(task.resource_id)
        $('#description').val(task.description)
        $('#comment').val(task.comment)

        getSubTasks(task.id)


    }



    $(window).on('resize', function() {

        if ($('.fixed-content').hasClass('show')) {

            let windowWidth = $(window).width()
            let width = 585;
            let left = windowWidth - 573;

            if (windowWidth <= 585) {
                width = windowWidth
                left = 12
            }

            $('.fixed-content').css({
                'left': left,
                'width': width
            })
        } else {
            initialFixedContent()
        }

    });

    $('.task-details-input').change(function() {
        edit()

    })

    // $('.main-task-date-label').click(function(event) {
    //     event.stopPropagation()
    //     $(this).next().click()

    // })



    // $('.main-task-actions').click(function(event) {
    //     event.stopPropagation()

    // })

    // $('.main-task-date-input').click(function(event) {
    //     event.stopPropagation()

    // })

    // $('.main-task-date-input').change(function(event) {
    //     $(this).prev().css('visibility', 'hidden')
    //     var name = $(this).prop('name');
    //     id = $(this).data('taskid')

    //     var values = {};
    //     values[name] = $(this).val();
    //     values['id'] = id;
    //     var url = '{{ t_route("updateTaskAttribute", ":id") }}';
    //     url = url.replace(':id', id);

    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    //     });

    //     $.ajax({
    //         url: url,
    //         method: 'POST',
    //         data: values,
    //         success: (res) => {
    //             console.log(res)
    //         },
    //         error: (error) => {
    //             console.log('error', error)
    //         }
    //     });
    // })



    $('#assignees').change(function(event) {

        var assignees = $(this).val()

        var url = '{{ t_route("update-assignees", ":id") }}';
        url = url.replace(':id', $('#task-id').val());

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: url,
            // url: "/api/task/" + $('#task-id').val(),
            method: 'POST',
            data: {
                assignees: assignees,
            },
            success: (res) => {
                addTaskCard(res.task, res.subTasks)
            },
            error: (error) => {
                console.log('error', error)
            }
        });
    })

    function edit() {
        var IsValid = $("#edit-task-form").valid();
        if (IsValid) {
            let form = new FormData(document.getElementById('edit-task-form'));
            let time_period = $('#time_period_edit').val()
            let planned_time_period = $('#planned_time_period_edit').val()
            time_period && form.append('picker_start_date', moment(time_period.split(' ')[0] + ' 00:00:00', 'DD/MM/YYYY HH:mm:ss').format('YYYY/MM/DD HH:mm:ss'))
            time_period && form.append('start_date', moment(time_period.split(' ')[0] + ' 00:00:00', 'DD/MM/YYYY HH:mm:ss').format('YYYY/MM/DD HH:mm:ss'))
            time_period && form.append('picker_end_date', moment(time_period.split(' ').pop() + ' 23:59:00', 'DD/MM/YYYY HH:mm:ss').format('YYYY/MM/DD HH:mm:ss'))
            time_period && form.append('end_date', moment(time_period.split(' ').pop() + ' 23:59:00', 'DD/MM/YYYY HH:mm:ss').format('YYYY/MM/DD HH:mm:ss'))
            planned_time_period && form.append('planned_start', moment(planned_time_period.split(' ')[0] + ' 00:00:00', 'DD/MM/YYYY HH:mm:ss').format('YYYY/MM/DD HH:mm:ss'))
            planned_time_period && form.append('planned_end', moment(planned_time_period.split(' ').pop() + ' 23:59:00', 'DD/MM/YYYY HH:mm:ss').format('YYYY/MM/DD HH:mm:ss'))
            form.append('duration', planned_duration)
            form.append('duration_worked', duration)

            var url = '{{ t_route("api.task.update", ":id") }}';
            url = url.replace(':id', $('#task-id').val());

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: url,
                method: 'POST',
                data: form,
                processData: false,
                contentType: false,
                success: (res) => {
                    addTaskCard(res.task, res.subTasks)
                },
                error: (error) => {
                    console.log('error', error)
                }
            });
        }
    }

    function getSubTasks(taskId) {
        var url = '{{ t_route("getSubTasks", ":id") }}';
        url = url.replace(':id', taskId);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: url,
            method: 'GET',
            processData: false,
            contentType: false,
            success: (res) => {

                var tasks = res.subTasks;
                var taskElements = '';
                $('#assignees').val(res.assignees)
                // $("#assignees").selectpicker("refresh");

                // var data = {!! json_encode($assignees, JSON_HEX_TAG) !!};
                // console.log(data)
                // $('#')

                //                 var options = '<option value="">no sss</option>'

                //                 $.each(data, function(index, itemData) {
                //                     if (res.assignees.includes(itemData.id)) {
                //                         options += `<option value=${itemData.id} selected>${itemData.name}</option>`;
                //                     } else {
                //                         options += `<option value=${itemData.id}>${itemData.name}</option>`;

                //                     }
                //                     // $('#dropListBuilding').append($("<option></option>")
                //                     //     .attr("value", key)
                //                     //     .text(value));
                //                 });

                //                 let select = `
                //                         <select name="assignee" multiple class="selectpicker form-control border-0">
                //                             ${options}
                //                         </select>
                //                         <span class="input-group-btn"><i class=""></i></span>
                //                 `

                //                 $('#assign').append(select)

                //                 $("#assignees").append('<option value="'+4+'">'+4+'</option>');
                // $("#assignees").val(4);
                // $("#assignees").selectpicker("refresh");

                $.each(tasks, function(index, task) {

                    taskElements += `<div class="subtask-name d-flex justify-content-between align-items-center p-0" data-task-id=${task.id}>
                            <div class="d-flex align-items-center" role="button" style="max-width:45%;">
                                <div class="">
                                    <svg style="width:14px" class="border border-dark rounded-circle bg-transparent" viewBox="0 0 32 32" aria-hidden="true" focusable="false">
                                        <path style="fill:transparent" d="M31,16c0,8.3-6.7,15-15,15S1,24.3,1,16S7.7,1,16,1S31,7.7,31,16z"></path>
                                        <path d="M13.4,22.1c-0.3,0-0.5-0.1-0.7-0.3l-3.9-3.9c-0.4-0.4-0.4-1,0-1.4s1-0.4,1.4,0l3.1,3.1l8.1-8.1c0.4-0.4,1-0.4,1.4,0   s0.4,1,0,1.4l-8.9,8.9C13.9,22,13.7,22.1,13.4,22.1z"></path>
                                    </svg>
                                </div>
                                <div class="" style="margin-left: 4px;z-index:1">
                                    <div class="" style="white-space: nowrap;text-overflow:ellipsis;overflow:hidden;">${task.text}</div>
                                </div>
                            </div>
                            <div class="sub-task-actions d-flex bg-white" style="z-index:2;margin-left:2px;white-space: nowrap;">
                                ${task.sub_tasks_count>0 ? `<div class="mx-1" onclick="showSubTaskDetails('${encodeURIComponent(JSON.stringify(task))}')"><span class="btn btn-outline-light btn-sm rounded-3 p-1 border-none" role="button">
                                    <span class="mx-1">${task.sub_tasks_count}</span>
                                    <svg class="" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                    <path d="M20,15c-1.9,0-3.4,1.3-3.9,3H7c-2.8,0-5-2.2-5-5v-3h14.1c0.4,1.7,2,3,3.9,3c2.2,0,4-1.8,4-4s-1.8-4-4-4 c-1.9,0-3.4,1.3-3.9,3H2V3c0-0.6-0.4-1-1-1S0,2.4,0,3v10c0,3.9,3.1,7,7,7h9.1c0.4,1.7,2,3,3.9,3c2.2,0,4-1.8,4-4S22.2,15,20,15z M20,7c1.1,0,2,0.9,2,2s-0.9,2-2,2s-2-0.9-2-2S18.9,7,20,7z M20,21c-1.1,0-2-0.9-2-2s0.9-2,2-2s2,0.9,2,2S21.1,21,20,21z"></path>
                                    </svg>
                                    </span></div>`:''}
                                <div class="mx-1" onclick="showSubTaskDetails('${encodeURIComponent(JSON.stringify(task))}')">
                                    <div role="button" tabindex="0" class="DeprecatedCircularButton DeprecatedCircularButton--enabled DeprecatedCircularButton--small DueDateContainer-button DueDateContainer-button--circular" aria-disabled="false" aria-pressed="false">
                                        <svg class="action-icons" viewBox="0 0 32 32" aria-hidden="true" focusable="false">
                                            <path d="M24,2V1c0-0.6-0.4-1-1-1s-1,0.4-1,1v1H10V1c0-0.6-0.4-1-1-1S8,0.4,8,1v1C4.7,2,2,4.7,2,8v16c0,3.3,2.7,6,6,6h16c3.3,0,6-2.7,6-6V8C30,4.7,27.3,2,24,2z M8,4v1c0,0.6,0.4,1,1,1s1-0.4,1-1V4h12v1c0,0.6,0.4,1,1,1s1-0.4,1-1V4c2.2,0,4,1.8,4,4v2H4V8C4,5.8,5.8,4,8,4z M24,28H8c-2.2,0-4-1.8-4-4V12h24v12C28,26.2,26.2,28,24,28z"></path>
                                        </svg>
                                    </div>
                                </div>
                                
                                ${task.sub_tasks_count==0 ? `<div class="mx-1" role="button" onclick="showSubTaskDetails('${encodeURIComponent(JSON.stringify(task))}')">
                                    <svg class="action-icons" viewBox="0 0 32 32" aria-hidden="true" focusable="false">
                                    <path d="M5,31c-0.1,0-0.3,0-0.4-0.1C4.2,30.7,4,30.4,4,30v-7.1c-2.5-2.3-4-5.5-4-8.9C0,7.4,5.4,2,12,2h8c6.6,0,12,5.4,12,12 s-5.4,12-12,12h-8c-0.1,0-0.3,0-0.4,0l-5.9,4.8C5.4,30.9,5.2,31,5,31z M12,4C6.5,4,2,8.5,2,14c0,3,1.3,5.8,3.6,7.7C5.9,21.9,6,22.2,6,22.5v5.4l4.6-3.7C10.8,24,11,24,11.3,24h0.1c0.2,0,0.4,0,0.6,0h8c5.5,0,10-4.5,10-10S25.5,4,20,4 C20,4,12,4,12,4z"></path>                                    </svg>
                                </div>`:''}
                            </div>
                        </div>`
                })

                // <div class="mx-1" role="button">
                //                     <svg class="action-icons" viewBox="0 0 32 32" aria-hidden="true" focusable="false">
                //                         <path d="M16,18c-4.4,0-8-3.6-8-8s3.6-8,8-8s8,3.6,8,8S20.4,18,16,18z M16,4c-3.3,0-6,2.7-6,6s2.7,6,6,6s6-2.7,6-6S19.3,4,16,4z M29,32c-0.6,0-1-0.4-1-1v-4.2c0-2.6-2.2-4.8-4.8-4.8H8.8C6.2,22,4,24.2,4,26.8V31c0,0.6-0.4,1-1,1s-1-0.4-1-1v-4.2C2,23,5,20,8.8,20h14.4c3.7,0,6.8,3,6.8,6.8V31C30,31.6,29.6,32,29,32z"></path>
                //                     </svg>
                //                 </div>
                                

                $('#appendSubTasks').html(taskElements);
                $("div.spanner").removeClass("show");
                $("div.overlay").removeClass("show");
            },
            error: (error) => {
                console.log('error', error)
            }
        });
    }

    // $('.main-task-assignee-label').click(function() {
    //     $(this).next().toggle('visibility')
    //     $(this).next().click()
    //     console.log($(this).next(), 'ooo')
    // })

    // $('.main-task-assignee').click(function(e) {
    //     e.stopPropagation()
    //     e.preventDefault()
    // })

    $('.assign-actions').click(function(e) {
        e.stopPropagation()
        e.preventDefault()
    })

    $('#addsubtaskdetail').click(function(e) {
        e.stopPropagation()
        hideFixedContent()
        $("#createParent").val($(this).data('id') ?? 0);
        // e.preventDefault()
    })

    function addSubTask(e) {
        e.stopPropagation()
        hideFixedContent()
        $("#createParent").val($(e.target).data('id') ?? 0);
    }



    // $(function() {
    //     // Enables popover
    //     $("[data-toggle=popover]").popover();
    // });

    $(function() {

        // $('#assignees').selectpicker();
        //         $("[data-toggle=popover]").popover();

        //         $("[data-toggle=popover]").popover({
        //             html: true,
        //             content: function() {
        //                 return `<div id="beds" class="hide">
        //     <div class="flex">
        //       <select name="minBeds" id="minBeds" class="selectpicker">
        //         <option>Min Beds</option>
        //         <option value="1">1 Bed</option>
        //         <option value="2">2 Bed</option>
        //         <option value="3">3 Bed</option>
        //         <option value="4">4 Bed</option>
        //         <option value="5">5 Bed</option>
        //       </select>
        //           </div>
        //   </div>`;
        //             }
        //         }).on('shown.bs.popover', function() {
        //             $('.selectpicker').selectpicker();
        //         });
    });

    function taskDelete(event) {

        deleteTask(event, $('#task-id').val())
    }

    function deleteTask(event, id) {
        event.stopPropagation()

        var url = '{{ t_route("task.delete", ":id") }}';
        url = url.replace(':id', id);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: url,
            method: 'POST',
            data: {
                id: id
            },
            success: (res) => {
                $(`#task-cards-${id}`).remove()
                hideFixedContent()
                addTaskCard(res.task, [])
            },
            error: (error) => {
                errorMsg(error.responseJSON.error)
            }
        })
    }
</script>