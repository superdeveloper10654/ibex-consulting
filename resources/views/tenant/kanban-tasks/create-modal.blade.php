<div id="modalForm" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0 add-task-title">Add New Task</h5>
                <h5 class="modal-title mt-0 update-task-title" style="display: none;">Update Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="NewtaskForm" role="form" method="post">
                    <input name="programme_id" type="text" value="{{$programId}}" hidden>
                    <input name="user_id" type="text" value="{{$userId}}" hidden>
                    <input id="createParent" name="parent" type="text" value="0" hidden>

                    <input type="hidden" id="range_start_date" value="{{ $date_range_start }}">
                    <input type="hidden" id="range_end_date" value="{{ $date_range_end }}">
                    <input type="hidden" id="gantt_columns" value="{{ $columns }}">
                    <input type="hidden" id="resourcess" value="{{ $resources }}">
                    <input type="hidden" id="calendardata" value="{{ $calendar }}">
                    <input type="hidden" id="resourcessgroup" value="{{ $groups }}">
                    <input type="hidden" id="calendarOverrides" value="{{ $calendar_overrides }}">

                    <div class="form-group mb-3">
                        <label for="text" class="col-form-label">Task Name<span class="text-danger">*</span></label>
                        <div class="col-lg-12">
                            <input name="text" type="text" class="form-control validate create-input" placeholder="Enter Task Name..." required>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="col-form-label">Task Description</label>
                        <div class="col-lg-12">
                            <textarea class="form-control create-input" name="description"></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 form-group mb-4">
                            <label class="col-form-label">Group<span class="text-danger">*</span></label>
                            <div class="col-lg-12">
                                <select name="resource_group_id" class="form-select validate create-input" required>
                                    <option value="" selected>Choose..</option>
                                    @foreach ($groups as $group)
                                    <option value="{{$group->id}}">{{$group->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6 form-group mb-4">
                            <label class="col-form-label">Resource<span class="text-danger">*</span></label>
                            <div class="col-lg-12">
                                <select name="resource_id" class="form-select validate create-input" required>
                                    <option value="" selected>Choose..</option>
                                    @foreach ($resources as $resource)
                                    <option value="{{$resource->id}}">{{$resource->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6 form-group mb-4">
                            <label class="col-form-label">Progress<span class="text-danger">*</span></label>
                            <div class="col-lg-12">
                                <select name="progress" class="form-select validate create-input" required>
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
                            </div>
                        </div>
                        <div class="col-lg-6 form-group mb-4">
                            <label class="col-form-label">Calendar<span class="text-danger">*</span></label>
                            <div class="col-lg-12">
                                <select id="calendar_id" name="calendar_id" class="form-select validate" required onclick="setDisable()">
                                    <!-- <option value="" selected>Choose..</option> -->
                                    @foreach ($calendar as $calendar)
                                    @if($calendar->type==1)
                                    <option value="{{$calendar->id}}">{{$calendar->name}}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 form-group mb-4">
                            <label for="planned_time_period" class="col-form-label">Planned Time Peroid<span class="text-danger">*</span></label>
                            <div class="col-lg-12">
                                <input id="planned_time_period" name="planned_time_period" type="text" placeholder="Select  planned time period..." class="caleran form-control" required>
                            </div>
                        </div>
                        <div class="col-lg-6 form-group mb-4">
                            <label for="time_period" class="col-form-label">Time Peroid</label>
                            <div class="col-lg-12">
                                <input id="time_period" name="time_period" type="text" placeholder="Enter time period..." class="caleran form-control create-input">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- <div class="col-lg-6 form-group mb-4">
                            <label for="planned_start" class="col-form-label">Planned Start Date<span class="text-danger">*</span></label>
                            <div class="col-lg-12">
                                <input name="planned_start" type="date" placeholder="Enter planned start date..." class="form-control create-input" required>
                            </div>
                        </div>

                        <div class="col-lg-6 form-group mb-4">
                            <label for="planned_end" class="col-form-label">Planned End Date<span class="text-danger">*</span></label>
                            <div class="col-lg-12">
                                <input name="planned_end" type="date" placeholder="Enter planned end date..." class="form-control create-input" required>
                            </div>
                        </div> -->



                        <!-- <div class="col-lg-6 form-group mb-4">
                            <label for="start_date" class="col-form-label">Start Date</span></label>
                            <div class="col-lg-12">
                                <input id="start_date" name="start_date" type="date" placeholder="Enter start date..." class="form-control create-input">
                            </div>
                        </div>

                        <div class="col-lg-6 form-group mb-4">
                            <label for="taskbudget" class="col-form-label">End Date</span></label>
                            <div class="col-lg-12">
                                <input id="end_date" name="end_date" type="date" placeholder="Enter end date..." class="form-control create-input">
                            </div>
                        </div> -->

                        <div class="col-lg-12 form-group mb-3">
                            <label class="col-form-label">Comment</label>
                            <div class="col-lg-12">
                                <textarea class="form-control create-input" name="comment"></textarea>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-lg-10">
                            <button type="button" class="btn btn-primary" id="addtask" onclick="create()">Create Task</button>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->