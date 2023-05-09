<div class="row fixed-top fixed-content">

    <div class="card p-0" style="position: relative;">
        <div class="overlay"></div>
        <div class="spanner">
            <div class="loader"></div>
            <!-- <p>Getting details, please be patient.</p> -->
        </div>

        <div class="card-body">
            <div class="float-end mx-1">
                <div class="close-button" role="button" onclick="hideFixedContent()">
                    <svg class="" viewBox="0 0 32 32" aria-hidden="true" focusable="false">
                        <path fill="#74788d" d="M2,14.5h18.4l-7.4-7.4c-0.6-0.6-0.6-1.5,0-2.1c0.6-0.6,1.5-0.6,2.1,0l10,10c0.6,0.6,0.6,1.5,0,2.1l-10,10c-0.3,0.3-0.7,0.4-1.1,0.4c-0.4,0-0.8-0.1-1.1-0.4c-0.6-0.6-0.6-1.5,0-2.1l7.4-7.4H2c-0.8,0-1.5-0.7-1.5-1.5C0.5,15.3,1.2,14.5,2,14.5z M28,3.5C28,2.7,28.7,2,29.5,2S31,2.7,31,3.5v25c0,0.8-0.7,1.5-1.5,1.5S28,29.3,28,28.5V3.5z"></path>
                    </svg>
                </div>
            </div>

            <div class="dropdown float-end">
                <a href="#" class="dropdown-toggle arrow-none" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="mdi mdi-dots-vertical m-0 text-muted h5"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- <a class="dropdown-item" href="#">Edit</a> -->
                    <a class="dropdown-item" href="#" onclick='taskDelete(event)'>Delete</a>
                </div>

            </div>
            <!-- end dropdown -->
            <form id="edit-task-form" name="edit-task-form" method="post">
                <!-- <div class="overlay" id="loading">
                    <div class="d-flex justify-content-center">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div> -->
                <!-- <h4 class="card-title mb-4 task-name">Task name</h4> -->

                <input id="task-name" class="card-title border-0 task-details-input mb-4" name="text">

                <input type="hidden" name="_method" value="PUT">
                <input id="task-id" value="" hidden>
                <input id="programme-id" name="programme_id" type="text" value="{{$programId}}" hidden>
                <input id="user-id" name="user_id" type="text" value="{{$userId}}" hidden>
                <input id="parent" name="parent" value="0" hidden>

                <div class="task-details" style="overflow-y: scroll;max-height:88vh">
                    <div>
                        <h6>Sub Tasks</h6>
                        <div id="appendSubTasks"></div>

                        <div class="mt-2" id="addsubtaskdetail" data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg">
                            <button class="btn btn-outline-light btn-md p-1 px-2 rounded-3" type="button">
                                <span class=""><i class="fa fa-plus" style="color:#495057"></i></span>
                                <span class="">
                                    &nbsp;Add subtask
                                </span>
                            </button>
                        </div>
                    </div>
                    <!-- <div class="input-group align-items-center">
                        <label class="col-5 mb-0 mt-n3">Assignee</label>
                        <select id="assignees" name="assignee" multiple class="selectpicker form-control border-0">
                            <option value="">No assignee</option>
                            @foreach ($assignees as $assignee)
                            <option value="{{$assignee->id}}">{{$assignee->name}}</option>
                            @endforeach
                        </select>
                        <span class="input-group-btn"><i class=""></i></span>
                    </div> -->

                    <div class="input-group align-items-center mt-2">
                        <label class="col mb-0">Due Date</label>
                        <label class="input-group-btn mb-0" for="planned_start_date">
                            <div role="button" tabindex="0" class="mx-1" aria-disabled="false" aria-pressed="false">
                                <svg class="action-icons" style="width: 32px;padding:7px" viewBox="0 0 32 32" aria-hidden="true" focusable="false">
                                    <path d="M24,2V1c0-0.6-0.4-1-1-1s-1,0.4-1,1v1H10V1c0-0.6-0.4-1-1-1S8,0.4,8,1v1C4.7,2,2,4.7,2,8v16c0,3.3,2.7,6,6,6h16c3.3,0,6-2.7,6-6V8C30,4.7,27.3,2,24,2z M8,4v1c0,0.6,0.4,1,1,1s1-0.4,1-1V4h12v1c0,0.6,0.4,1,1,1s1-0.4,1-1V4c2.2,0,4,1.8,4,4v2H4V8C4,5.8,5.8,4,8,4z M24,28H8c-2.2,0-4-1.8-4-4V12h24v12C28,26.2,26.2,28,24,28z"></path>
                                </svg>
                            </div>
                        </label>
                        <input id="due-date" placeholder="No due date" type="text" class="form-control date-input bg-transparent border-0  task-details-input" name="deadline" readonly="readonly" role="button" />
                    </div>

                    <div class="input-group align-items-center">
                        <label class="col-5 mb-0">Calendar</label>
                        <select id="calendar_id" name="calendar_id" class="form-control border-0" onclick="setDisable()">
                            <!-- <option value="" selected>Choose..</option> -->
                            @foreach ($calendar as $calendar)
                            @if($calendar->type==1)
                            <option value="{{$calendar->id}}">{{$calendar->name}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group align-items-center">
                        <label class="col mb-0">Planned Time Peroid</label>
                        <label class="input-group-btn mb-0" for="planned_start_date">
                            <div role="button" tabindex="0" class="mx-1" aria-disabled="false" aria-pressed="false">
                                <svg class="action-icons" style="width: 32px;padding:7px" viewBox="0 0 32 32" aria-hidden="true" focusable="false">
                                    <path d="M24,2V1c0-0.6-0.4-1-1-1s-1,0.4-1,1v1H10V1c0-0.6-0.4-1-1-1S8,0.4,8,1v1C4.7,2,2,4.7,2,8v16c0,3.3,2.7,6,6,6h16c3.3,0,6-2.7,6-6V8C30,4.7,27.3,2,24,2z M8,4v1c0,0.6,0.4,1,1,1s1-0.4,1-1V4h12v1c0,0.6,0.4,1,1,1s1-0.4,1-1V4c2.2,0,4,1.8,4,4v2H4V8C4,5.8,5.8,4,8,4z M24,28H8c-2.2,0-4-1.8-4-4V12h24v12C28,26.2,26.2,28,24,28z"></path>
                                </svg>
                            </div>
                        </label>
                        <input id="planned_time_period_edit" name="planned_time_period" type="text" placeholder="No planned time period" class="task-details-input caleran form-control bg-transparent border-0">
                        <!-- <input id="planned-start-date" placeholder="No planned start date" type="text" class="form-control date-input bg-transparent border-0  task-details-input" name="planned_start_date" readonly="readonly" role="button" /> -->
                    </div>
                    <div class="input-group align-items-center">
                        <label class="col mb-0">Planned Time Peroid</label>
                        <label class="input-group-btn mb-0" for="planned_start_date">
                            <div role="button" tabindex="0" class="mx-1" aria-disabled="false" aria-pressed="false">
                                <svg class="action-icons" style="width: 32px;padding:7px" viewBox="0 0 32 32" aria-hidden="true" focusable="false">
                                    <path d="M24,2V1c0-0.6-0.4-1-1-1s-1,0.4-1,1v1H10V1c0-0.6-0.4-1-1-1S8,0.4,8,1v1C4.7,2,2,4.7,2,8v16c0,3.3,2.7,6,6,6h16c3.3,0,6-2.7,6-6V8C30,4.7,27.3,2,24,2z M8,4v1c0,0.6,0.4,1,1,1s1-0.4,1-1V4h12v1c0,0.6,0.4,1,1,1s1-0.4,1-1V4c2.2,0,4,1.8,4,4v2H4V8C4,5.8,5.8,4,8,4z M24,28H8c-2.2,0-4-1.8-4-4V12h24v12C28,26.2,26.2,28,24,28z"></path>
                                </svg>
                            </div>
                        </label>
                        <input id="time_period_edit" name="time_period" type="text" placeholder="No planned time period" class="task-details-input caleran form-control bg-transparent border-0">
                        <!-- <input id="planned-start-date" placeholder="No planned start date" type="text" class="form-control date-input bg-transparent border-0  task-details-input" name="planned_start_date" readonly="readonly" role="button" /> -->
                    </div>
                    <div class="input-group align-items-center">
                        <label class="col-5 mb-0">Group</label>
                        <select id="group" name="resource_group_id" class="form-control border-0  task-details-input">
                            <option value="" selected>Choose..</option>
                            @foreach ($groups as $group)
                            <option value="{{$group->id}}">{{$group->name}}</option>
                            @endforeach
                        </select>
                        <span class="input-group-btn"><i class=""></i></span>
                    </div>

                    <div class="input-group align-items-center">
                        <label class="col-5 mb-0">Resource</label>
                        <select id="resource" name="resource_id" class="form-control border-0  task-details-input">
                            <option value="" selected>Choose..</option>
                            @foreach ($resources as $resource)
                            <option value="{{$resource->id}}">{{$resource->name}}</option>
                            @endforeach
                        </select>
                        <span class="input-group-btn"><i class=""></i></span>
                    </div>

                    <div class="input-group mb-4 align-items-center">
                        <label class="col-5 mb-0">Progress</label>
                        <select id="progress" name="progress" class="form-control border-0  task-details-input">
                            <option value="" selected>Choose..</option>
                            <option value="0">Waiting</option>
                            <option value="0.1">10%</option>
                            <option value="0.2">20%</option>
                            <option value="0.3">30%</option>
                            <option value="0.4">40%</option>
                            <option value="0.5">50%</option>
                            <option value="0.6">60%</option>
                            <option value="0.7">70%</option>
                            <option value="0.8">80%</option>
                            <option value="0.9">90%</option>
                            <option value="1">Complete</option>
                        </select>
                        <span class="input-group-btn"><i class=""></i></span>
                    </div>

                    <div class="col-lg-12 form-group mb-3">
                        <label class="col-form-label">Comment</label>
                        <div style="margin-right: 5px;">
                            <textarea id="comment" rows="5" class="form-control task-details-input" name="comment"></textarea>
                        </div>
                    </div>

                </div>
            </form>

        </div>
    </div>
</div>