<!-- Start Calendar Editors -->
<div class="modal" tabindex="-1"  id="modal_edit_calendars">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Calendars Editor</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <div class="card" style="-webkit-box-shadow: none; box-shadow: none;">
               <div class="card-body pt-0">
                  <p class="text-muted">Edit your existing calendars</p>
                 <div class="table-responsive" >
                  <table id="table_calendars" class="table align-middle table-nowrap table-hover" style="font-size: 0.8125rem;">
                     <thead>
                        <tr>
                           <th>Name</th>
                           <th>Type</th>
                           <th></th>
                        </tr>
                     </thead>
                     <tbody>
                  </table>
                 </div>
                  <p class="text-muted">Add a new calendar</p>
                 <div class="row">
                   <div class="col-md-6">
                     <button id="calendars-modal-add-task-calendar" type="button" class="btn btn-outline-secondary waves-effect btn-rounded w-100 waves-effect waves-light add-task-calendar"><i class="bx bx-task"></i> Task Calendar</button>
                   </div>
                   <div class="col-md-6">
                  <button id="calendars-modal-add-resource-calendar" type="button" class="btn btn-outline-secondary waves-effect btn-rounded w-100 waves-effect waves-light add-resource-calendar"><i class="mdi mdi-excavator"></i> Resource Calendar</button>
                 </div>
                 </div>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-success btn-rounded w-md waves-effect waves-light close-calendars-modal">Save</button>
         </div>
      </div>
   </div>
</div>
<!-- End calendars Editors -->

<!--  Start Task Calendar  -->
<div class="modal" tabindex="-1"  id="modal_task_calendar_editor">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Task Calendar Editor</h5>
            <button type="button" class="btn-close reopen-all-calendars" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
           <div class="card">
            <form>
               <div class="accordion md-accordion" id="accordionTaskCalendarEditor" role="tablist" aria-multiselectable="true">
                     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">General
                     </button>
                     <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                        <div class="card-body pt-0">
                           <input type="hidden" id="task_calendar_edit_id" value="0">
                           <div class="form-group">
                              <label for="calendar_name">Calendar name</label>
                              <input type="text" class="form-control calendar-edit-name" id="task_calendar_edit_name" placeholder="Give this calendar a name" value="Default task calendar">
                              <span class="text-danger" id="calendarnameErrorMsg" style="color: red"></span>
                           </div>
                           <div class="form-group" style="display: none;">
                              <label for="task_calendar_edit_type">Type</label>
                              <select class="form-control mdb-select dropdown-primary" id="">
                                 <option value="1" selected>Task calendar</option>
                              </select>
                           </div>
                           <div class="form-group mt-3">
                              <div class="col md-form">
                                 <table style="width: 200px" class="table table-sm">
                                    <tbody>
                                       <tr>
                                          <td><span>Set as default</span></td>
                                          <td><input class="form-check-input " type="checkbox" id="task_calendar_edit_default">
                                             <label class="form-check-label" for="task_calendar_edit_default" class="label-table"></label>
                                          </td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>
                     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                     Normal Working
                     </button>
                     <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                        <div class="card-body pt-0">
                           <p class="text-muted">Select the normal working days with start and finish times below</p>
                           <div class="row">
                              <div class="col md-form">
                                  <label>Weekday</label>
                                 <table class="table table-sm" id="week_days">
                                    <tbody>
                                       <tr>
                                          <td><span>Monday</span></td>
                                          <td><input class="form-check-input" id="task_calendar_edit_working_day_monday" type="checkbox">
                                             <label class="form-check-label" for="task_calendar_edit_working_day_monday" class="label-table"></label>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td><span>Tuesday</span></td>
                                          <td><input class="form-check-input" id="task_calendar_edit_working_day_tuesday" type="checkbox">
                                             <label class="form-check-label" for="task_calendar_edit_working_day_tuesday" class="label-table"></label>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td><span>Wednesday</span></td>
                                          <td><input class="form-check-input" id="task_calendar_edit_working_day_wednesday" type="checkbox">
                                             <label class="form-check-label" for="task_calendar_edit_working_day_wednesday" class="label-table"></label>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td><span>Thursday</span></td>
                                          <td><input class="form-check-input" id="task_calendar_edit_working_day_thursday" type="checkbox">
                                             <label class="form-check-label" for="task_calendar_edit_working_day_thursday" class="label-table"></label>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td><span>Friday</span></td>
                                          <td><input class="form-check-input" id="task_calendar_edit_working_day_friday" type="checkbox">
                                             <label class="form-check-label" for="task_calendar_edit_working_day_friday" class="label-table"></label>
                                          </td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </div>
                              <div class="col md-form">
                                <label>Weekend</label>
                                 <table class="table table-sm" id="weekend_days">
                                    <tbody>
                                       <tr>
                                          <td><span>Saturday</span></td>
                                          <td><input class="form-check-input" id="task_calendar_edit_working_day_saturday" type="checkbox">
                                             <label class="form-check-label" for="task_calendar_edit_working_day_saturday" class="label-table"></label>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td><span>Sunday</span></td>
                                          <td><input class="form-check-input" id="task_calendar_edit_working_day_sunday" type="checkbox">
                                             <label class="form-check-label" for="task_calendar_edit_working_day_sunday" class="label-table"></label>
                                          </td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-6">
                                 <x-form.timepicker label="Start time" name="task_calendar_edit_start_time" />
                              </div>
                              <div class="col-md-6">
                                 <x-form.timepicker label="Finish time" name="task_calendar_edit_end_time" />
                              </div>
                           </div>
                        </div>
                     </div>
                  
                     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">Overrides  </button>
                     <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                        <div class="card-body pt-0">
                           <p class="text-muted">Select the overriding non-working periods below</p>
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="form-group" style="width: 100%">
                                    <x-form.datepicker label="Start date" name="task_calendar_edit_override_start" />
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group" style="width: 100%">
                                    <x-form.datepicker label="Finish date" name="task_calendar_edit_override_end" />
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col" style="flex: none; width: 20%;">
                                 <div class="form-group mt-3">
                                    <button type="button" class="btn btn-light" onclick="taskAddCalendarOverride(this)">Add</button>
                                 </div>
                              </div>
                           </div>
                           <table id="table_task_calendar_overrides" class="table table-sm">
                              <thead>
                                 <tr>
                                    <th style="width: 80%">Dates</th>
                                    <th style="width: 20%"></th>
                                 </tr>
                              </thead>
                              <tbody>
                              </tbody>
                           </table>
                        </div>
                     </div>
                  
               </div>
            </form>
        </div>
         </div>
         <div class="modal-footer">
             <button class="btn btn-danger mr-auto" class="delete-calendar" id="delete-task-calendar" style="display: none">Delete</button>
            <button type="button" id="save-task-calendar" class="btn btn-primary">Save</button>
         </div>
      </div>
   </div>
</div>
<!--  End Task Calendar-->

<!-- Start Resources Calendars -->
   
   <div class="modal" tabindex="-1"  id="modal_resource_calendar_editor">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Resource Calendar Editor</h5>
            <button type="button" class="btn-close reopen-all-calendars" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
           <div class="card">
            <form>
               <div class="accordion md-accordion" id="accordionTaskCalendarEditor" role="tablist" aria-multiselectable="true">
                     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">General
                     </button>
                     <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                        <div class="card-body pt-0">
                           <input type="hidden" id="resource_calendar_edit_id" value="0">
                           <div class="form-group">
                              <label for="resource_calendar_edit_name">Calendar name</label>
                              <input type="text" class="form-control calendar-edit-name" id="resource_calendar_edit_name" placeholder="Give this calendar a name">
                              <span class="text-danger" id="calendarrnameErrorMsg" style="color: red"></span>
                           </div>
                           <div class="form-group" style="display: none;">
                              <label for="resource_calendar_edit_type">Type</label>
                              <select class="form-control mdb-select dropdown-primary" id="resource_calendar_edit_type">
                                 <option value="1" selected>Task calendar</option>
                              </select>
                           </div>
                           <div class="form-group mt-3">
                              <div class="col md-form">
                                 <table style="width: 200px" class="table table-sm">
                                    <tbody>
                                       <tr>
                                          <td><span>Set as default</span></td>
                                          <td><input class="form-check-input " type="checkbox" id="resource_calendar_edit_default">
                                             <label class="form-check-label" for="resource_calendar_edit_default" class="label-table"></label>
                                          </td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>
                     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                     Normal Working
                     </button>
                     <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                        <div class="card-body pt-0">
                           <p class="text-muted">Select the normal working days with start and finish times below</p>
                           <div class="row">
                              <div class="col md-form">
                                <label>Weekday</label>
                                 <table class="table table-sm" id="week_days">
                                    <tbody>
                                       <tr>
                                          <td><span>Monday</span></td>
                                          <td><input class="form-check-input" id="resource_calendar_edit_working_day_monday" type="checkbox">
                                             <label class="form-check-label" for="resource_calendar_edit_working_day_monday" class="label-table"></label>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td><span>Tuesday</span></td>
                                          <td><input class="form-check-input" id="resource_calendar_edit_working_day_tuesday" type="checkbox">
                                             <label class="form-check-label" for="resource_calendar_edit_working_day_tuesday" class="label-table"></label>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td><span>Wednesday</span></td>
                                          <td><input class="form-check-input" id="resource_calendar_edit_working_day_wednesday" type="checkbox">
                                             <label class="form-check-label" for="resource_calendar_edit_working_day_wednesday" class="label-table"></label>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td><span>Thursday</span></td>
                                          <td><input class="form-check-input" id="resource_calendar_edit_working_day_thursday" type="checkbox">
                                             <label class="form-check-label" for="resource_calendar_edit_working_day_thursday" class="label-table"></label>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td><span>Friday</span></td>
                                          <td><input class="form-check-input" id="resource_calendar_edit_working_day_friday" type="checkbox">
                                             <label class="form-check-label" for="resource_calendar_edit_working_day_friday" class="label-table"></label>
                                          </td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </div>
                              <div class="col md-form">
                                <label>Weekend</label>
                                 <table class="table table-sm" id="weekend_days">
                                    <tbody>
                                       <tr>
                                          <td><span>Saturday</span></td>
                                          <td><input class="form-check-input" id="resource_calendar_edit_working_day_saturday" type="checkbox">
                                             <label class="form-check-label" for="resource_calendar_edit_working_day_saturday" class="label-table"></label>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td><span>Sunday</span></td>
                                          <td><input class="form-check-input" id="resource_calendar_edit_working_day_sunday" type="checkbox">
                                             <label class="form-check-label" for="resource_calendar_edit_working_day_sunday" class="label-table"></label>
                                          </td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-6">
                                 <label for="resource_calendar_edit_start_time">Start time</label>
                                 <div class="form-group">
                                    <input type="text" class="form-control" id="resource_calendar_edit_start_time" placeholder="07:00">
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <label for="resource_calendar_edit_end_time">Finish time</label>
                                 <div class="form-group">
                                    <input type="text" class="form-control" id="resource_calendar_edit_end_time" placeholder="17:00">
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>

                     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">Overrides </button>
                     <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                        <div class="card-body pt-0">
                           <p class="text-muted">Select the overriding non-working periods below</p>
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="form-group" style="width: 100%">
                                    <label for="resource_calendar_edit_override_start">Start date</label>
                                    <input
                                       id="resource_calendar_edit_override_start"
                                       type="text"
                                       class="form-control"
                                       />
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group" style="width: 100%">
                                    <label>Finish date</label>
                                    <input
                                       id="resource_calendar_edit_override_end"
                                       type="text"
                                       class="form-control"
                                       />
                                 </div>
                              </div>                              
                           </div>
                           <div class="row">
                              <div class="col" style="flex: none; width: 20%;">
                                 <div class="form-group mt-3">
                                    <button type="button" class="btn btn-light resource-add-calendar-override">Add</button>
                                 </div>
                              </div>
                           </div>
                           <table id="table_resource_calendar_overrides" class="table table-sm">
                              <thead>
                                 <tr>
                                    <th style="width: 80%">Dates</th>
                                    <th style="width: 20%"></th>
                                 </tr>
                              </thead>
                              <tbody>
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
            </form>
           </div>
         </div>
         <div class="modal-footer">
             <button class="btn btn-danger mr-auto" class="delete-calendar" id="delete-resource-calendar" style="display: none">Delete</button>
            <button type="button" id="save-resource-calendar" class="btn btn-primary">Save</button>
         </div>
      </div>
   </div>
</div>
<!-- End Resources Calendars -->