<div class="modal" tabindex="-1"  id="modal_task_editor">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" id="modal_task_editor_content">
      <div class="modal-header">
        <h4 class="modal-title" id="task-editor-title">Task Editor</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">       
         <form id="form_task_editor">
          <div class="accordion accordion-flush" id="accordionFlushExample">
             <div class="card" id="task-editor-general-section">
            <div class="accordion-item">
              <h2 class="accordion-header" id="flush-headingOne">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOneGeneral" aria-expanded="false" aria-controls="flush-collapseOne">
                  General
                </button>
              </h2>
              <div id="flush-collapseOneGeneral" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <div class="form-group">
                        <label for="task_edit_type">Type</label>
                        <select class="form-control mdb-select dropdown-primary" name="task_edit_type" id="task_edit_type">
                          <option value="project">Project</option>
                          <option value="task">Task</option>
                          <option value="milestone">Milestone</option>
                        </select>
                      </div>
                    </div>
                    <div class="col">
                      <div class="form-group">
                        <label for="task_edit_calendar_id">Calendar</label>
                        <select class="form-control mdb-select dropdown-primary" id="task_edit_calendar_id" style="font-size: 0.8em">
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col">
                      <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" id="task_edit_name" name="Name" class="form-control task_edit_name reset-init" required>
                      </div>
                    </div>
                  </div>
                  <div class="row" style="display: none" id="start_dates_disabled">
                    <div class="col">
                      <span>Start date and time are disabled due to dependency</span>
                    </div>
                  </div>
                  <div class="row row-start-date" style="align-items:flex-end">
                    <div class="col" style="padding-right: 2px;">
                      <div class="form-group" style="width: 100%">
                        <label for="task_edit_start_date_d">Start date</label>
                        <select class="form-control mdb-select dropdown-primary reset-init" id="task_edit_start_date_d" style="border-radius: 4px 0 0 4px;">
                          <?php
                          $start_date = 1;
                          $end_date = 31;
                          for ($i = $start_date; $i <= $end_date; $i++) {
                            if ($i < 10) {
                              $i = "0" . $i;
                            }
                          ?>
                            <option value='<?= $i ?>'><?= $i ?></option>
                          <?php
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col" style="padding-left: 2px; padding-right: 2px;">
                      <div class="form-group" style="width: 100%">
                        <select class="form-control mdb-select dropdown-primary reset-init" id="task_edit_start_date_m" style="width: 100%">
                          <?php
                          $month_names = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
                          $count = 1;
                          foreach ($month_names as $month) {
                            if ($count < 10) {
                              $count_ui = "0" . $count;
                            } else {
                              $count_ui = $count;
                            }
                          ?>
                            <option value="<?= $count_ui ?>"><?php echo $month; ?></option>
                          <?php
                            $count++;
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col" style="padding-left: 2px;">
                      <div class="form-group" style="width: 100%">
                        <select class="form-control mdb-select dropdown-primary reset-init" id="task_edit_start_date_y" style="width: 100%">
                          <?php
                          $earliest_year = date("Y") - 3;
                          $latest_year = date("Y") + 3;
                          foreach (range($earliest_year, $latest_year) as $i) {
                          ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                          <?php
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col start" style="padding-right: 2px;">
                      <div class="form-group">
                        <label for="task_edit_start_time_h">Start time</label>
                        <select class="form-control mdb-select dropdown-primary reset-init" id="task_edit_start_time_h">
                          <option value="00">00</option>
                          <option value="01">01</option>
                          <option value="02">02</option>
                          <option value="03">03</option>
                          <option value="04">04</option>
                          <option value="05">05</option>
                          <option value="06">06</option>
                          <option value="07">07</option>
                          <option value="08">08</option>
                          <option value="09">09</option>
                          <option value="10">10</option>
                          <option value="11">11</option>
                          <option value="12">12</option>
                          <option value="13">13</option>
                          <option value="14">14</option>
                          <option value="15">15</option>
                          <option value="16">16</option>
                          <option value="17">17</option>
                          <option value="18">18</option>
                          <option value="19">19</option>
                          <option value="20">20</option>
                          <option value="21">21</option>
                          <option value="22">22</option>
                          <option value="23">23</option>
                        </select>
                      </div>
                    </div>
                    <div class="col start" style="padding-left: 2px;">
                      <div class="form-group">
                         <label for="task_edit_start_time_m"></label>
                        <select class="form-control mdb-select dropdown-primary reset-init" id="task_edit_start_time_m" style="width: 100%">
                          <option value="00">00</option>
                          <option value="05">05</option>
                          <option value="10">10</option>
                          <option value="15">15</option>
                          <option value="20">20</option>
                          <option value="25">25</option>
                          <option value="30">30</option>
                          <option value="35">35</option>
                          <option value="40">40</option>
                          <option value="45">45</option>
                          <option value="50">50</option>
                          <option value="55">55</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row" id="workload-driven-duration-prompt" style="display: none">
                    <div class="col">
                      <span style="color: #fff">The duration is driven by the workload</span>
                    </div>
                  </div>
                  <div class="row">
                    <div class="row-task-editor-period-descriptors-default" style="display: inherit;align-items: flex-end;;">
                      <div class="col" style="padding-right: 2px;">
                        <div class="form-group">
                          <label id="label_task_edit_duration_hours" for="task_edit_duration_hours">Duration (hours & mins)</label>
                          <label id="" for="task_edit_duration_hours"></label>
                          <input type="text" id="task_edit_duration_hours" name="Duration (hours)" class="form-control reset-init" placeholder="hours" style="border-radius: 4px 0 0 4px !important;">
                        </div>
                      </div>
                      <div class="col" style="padding-left: 2px;">
                        <div class="form-group">
                          <input type="text" id="task_edit_duration_mins" name="Duration (mins)" class="form-control reset-init" placeholder="mins" style="border-radius: 0 4px 4px 0 !important;">
                        </div>
                      </div>
                    </div>
                    <input type="hidden" id="task_edit_timings_overriden">
                    <div class="row-task-editor-period-descriptors-custom" style="">
                      <div class="col">
                        <div class="form-group">
                          <label id="task_edit_custom_duration_label" for="task_edit_duration_custom">Duration (custom)</label>
                          <input type="text" id="task_edit_duration_custom" class="form-control reset-init">
                        </div>
                      </div>
                    </div>
                    <input type="text" id="task_edit_calendar_id_init" style="width:0px; height: 0px !important; border: none;">
                     <div class="row-task-editor-period-descriptors-custom" style="">
                      <div class="col">
                        <div class="form-group">
                          <label id="task_edit_custom_duration_label" for="task_edit_progress">Progress</label>
                         <select class="form-control" id="task_edit_progress" name="task_edit_progress">
                          <option value="0">Not started</option>
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
                          <option value="2">Prolonged</option>
                          <option value="3">Delayed</option>
                          <option value="4">Accelerated</option>
                         </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col">
                      <div class="form-group">
                        <label for="task_edit_end_date">Finish date & time</label>
                        <input disabled type="text" id="task_edit_end_date" name="Finish" class="form-control reset-init">
                      </div>
                    </div>
                  </div>
                  <input type="text" id="task_edit_calendar_id_init" style="width:0px; height: 0px !important; border: none;">
                </div>
              </div>
            </div>
          </div>

           <div class="card" id="task-editor-resources-section">
            <div class="accordion-item">
              <h2 class="accordion-header" id="flush-headingOne">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOneResources" aria-expanded="false" aria-controls="flush-collapseOne">
                  Resources
                </button>
              </h2>
              <div id="flush-collapseOneResources" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <div class="form-group">
                        <label for="task_edit_resource_group_id">Resource group</label>
                        <select class="form-control mdb-select dropdown-primary reset-init" id="task_edit_resource_group_id">
                        </select>
                      </div>
                    </div>
                  </div>
                  <br>
                  <div class="row" id="task-editor-resource-items-allocated">
                    <div class="col">
                      <div class="form-group">
                        <label for="task_edit_resource_id">Resource items</label>
                        <select id="task_edit_resource_id" multiple="" class="form-control reset-init" style="width: 100%">
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="card" id="task-editor-deadline-section">
             <div class="accordion-item">
              <h2 class="accordion-header" id="flush-headingOne">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOneDeadline" aria-expanded="false" aria-controls="flush-collapseOne">
                  Deadline
                </button>
              </h2>
              <div id="flush-collapseOneDeadline" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <div class="row" style="align-items: flex-end;">
                        <div class="col" style="padding-right: 2px;">
                          <div class="form-group" style="width: 100%">
                            <label for="task_edit_deadline_date_d">Start date</label>
                            <select class="form-control mdb-select dropdown-primary reset-init" id="task_edit_deadline_date_d" style="width: 100%">
                              <?php
                              $start_date = 1;
                              $end_date = 31;
                              for ($i = $start_date; $i <= $end_date; $i++) {
                                if ($i < 10) {
                                  $i = "0" . $i;
                                }
                              ?>
                                <option value='<?= $i ?>'><?= $i ?></option>
                              <?php
                              }
                              ?>
                            </select>

                          </div>
                        </div>
                        <div class="col" style="padding-left: 2px; padding-right: 2px;">
                          <div class="form-group" style="width: 100%">
                            <select class="form-control mdb-select dropdown-primary reset-init" id="task_edit_deadline_date_m" style="width: 100%">
                              <?php
                              $month_names = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
                              $count = 1;
                              foreach ($month_names as $month) {
                                if ($count < 10) {
                                  $count_ui = "0" . $count;
                                } else {
                                  $count_ui = $count;
                                }
                              ?>
                                <option value="<?= $count_ui ?>"><?php echo $month; ?></option>
                              <?php
                                $count++;
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="col" style="padding-left: 2px;">
                          <div class="form-group" style="width: 100%">
                            <select class="form-control mdb-select dropdown-primary reset-init" id="task_edit_deadline_date_y" style="width: 100%">
                              <?php
                              $earliest_year = date("Y") - 3;
                              $latest_year = date("Y") + 3;
                              foreach (range($earliest_year, $latest_year) as $i) {
                              ?>
                                <option value="<?= $i ?>"><?= $i ?></option>
                              <?php
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="col" style="padding-right: 2px;">
                          <div class="form-group">
                            <label for="task_edit_deadline_time_h">Start time</label>
                            <select class="form-control mdb-select dropdown-primary reset-init" id="task_edit_deadline_time_h" style="width: 100%">
                              <?php
                              $earliest_hour = 0;
                              $latest_hour = 23;


                              foreach (range($earliest_hour, $latest_hour) as $i) {
                                if ($i < 10) {
                                  $i = "0" . $i;
                                }

                              ?>
                                <option value="<?= $i ?>"><?= $i ?></option>

                              <?php
                              }
                              ?>

                            </select>
                          </div>
                        </div>
                        <div class="col" style="padding-left: 2px;">
                          <div class="form-group">
                            <select class="form-control mdb-select dropdown-primary reset-init" id="task_edit_deadline_time_m" style="width: 100%">
                              <option value="00">00</option>
                              <option value="05">05</option>
                              <option value="10">10</option>
                              <option value="15">15</option>
                              <option value="20">20</option>
                              <option value="25">25</option>
                              <option value="30">30</option>
                              <option value="35">35</option>
                              <option value="40">40</option>
                              <option value="45">45</option>
                              <option value="50">50</option>
                              <option value="55">55</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

           <div class="card" id="task-editor-baseline-section">
            <div class="accordion-item">
              <h2 class="accordion-header" id="flush-headingOne">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOneBaseline" aria-expanded="false" aria-controls="flush-collapseOne">
                  Baseline
                </button>
              </h2>
              <div id="flush-collapseOneBaseline" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                <div class="card-body">
                  <div class="row" id="adjusted-baseline-prompt" style="display: none">
                    <div class="col">
                      <span style="color: #fff">Budget has been updated to reflect the baseline dates</span>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col">
                      <div class="row" style="align-items: flex-end;">
                        <div class="col" style="padding-right: 2px;">
                          <div class="form-group" style="width: 100%">
                            <label for="task_edit_baseline_start_date_d">Start date</label>
                            <select class="form-control mdb-select dropdown-primary" id="task_edit_baseline_start_date_d" style="width: 100%">
                              <?php
                              $start_date = 1;
                              $end_date = 31;
                              for ($i = $start_date; $i <= $end_date; $i++) {
                                if ($i < 10) {
                                  $i = "0" . $i;
                                }
                              ?>
                                <option value='<?= $i ?>'><?= $i ?></option>
                              <?php
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="col" style="padding-left: 2px; padding-right: 2px;">
                          <div class="form-group" style="width: 100%">
                            <select class="form-control mdb-select dropdown-primary" id="task_edit_baseline_start_date_m" style="width: 100%">
                              <?php
                              $month_names = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
                              $count = 1;
                              foreach ($month_names as $month) {
                                if ($count < 10) {
                                  $count_ui = "0" . $count;
                                } else {
                                  $count_ui = $count;
                                }
                              ?>
                                <option value="<?= $count_ui ?>"><?php echo $month; ?></option>
                              <?php
                                $count++;
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="col" style="padding-left: 2px;">
                          <div class="form-group" style="width: 100%">
                            <select class="form-control mdb-select dropdown-primary" id="task_edit_baseline_start_date_y" style="width: 100%">
                              <?php
                              $earliest_year = date("Y") - 3;
                              $latest_year = date("Y") + 3;
                              foreach (range($earliest_year, $latest_year) as $i) {
                              ?>
                                <option value="<?= $i ?>"><?= $i ?></option>
                              <?php
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="col" style="padding-right: 2px;">
                          <div class="form-group">
                            <label for="task_edit_baseline_start_time_h">Start time</label>
                            <select class="form-control mdb-select dropdown-primary" id="task_edit_baseline_start_time_h" style="width: 100%">
                              <option value="">Hour</option>
                              <?php
                              $earliest_hour = 0;
                              $latest_hour = 23;
                              foreach (range($earliest_hour, $latest_hour) as $i) {
                                if ($i < 10) {
                                  $i = "0" . $i;
                                }
                              ?>
                                <option value="<?= $i ?>"><?= $i ?></option>
                              <?php
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="col" style="padding-left: 2px;">
                          <div class="form-group">
                            <select class="form-control mdb-select dropdown-primary" id="task_edit_baseline_start_time_m" style="width: 100%">
                              <option value="">Mins</option>
                              <option value="00">00</option>
                              <option value="05">05</option>
                              <option value="10">10</option>
                              <option value="15">15</option>
                              <option value="20">20</option>
                              <option value="25">25</option>
                              <option value="30">30</option>
                              <option value="35">35</option>
                              <option value="40">40</option>
                              <option value="45">45</option>
                              <option value="50">50</option>
                              <option value="55">55</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row" style="align-items: flex-end;">
                        <div class="col" style="padding-right: 2px;">
                          <div class="form-group" style="width: 100%">
                            <label for="task_edit_baseline_end_date_d">Finish date</label>
                            <select class="form-control mdb-select dropdown-primary" id="task_edit_baseline_end_date_d" style="width: 100%">
                              <?php
                              $start_date = 1;
                              $end_date = 31;
                              for ($i = $start_date; $i <= $end_date; $i++) {
                                if ($i < 10) {
                                  $i = "0" . $i;
                                }
                              ?>
                                <option value='<?= $i ?>'><?= $i ?></option>
                              <?php
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="col" style="padding-left: 2px; padding-right: 2px;">
                          <div class="form-group" style="width: 100%">
                            <select class="form-control mdb-select dropdown-primary" id="task_edit_baseline_end_date_m" style="width: 100%">
                              <?php
                              $month_names = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
                              $count = 1;
                              foreach ($month_names as $month) {
                                if ($count < 10) {
                                  $count_ui = "0" . $count;
                                } else {
                                  $count_ui = $count;
                                }
                              ?>
                                <option value="<?= $count_ui ?>"><?php echo $month; ?></option>
                              <?php
                                $count++;
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="col" style="padding-left: 2px;">
                          <div class="form-group" style="width: 100%">
                            <select class="form-control mdb-select dropdown-primary" id="task_edit_baseline_end_date_y" style="width: 100%">
                              <?php
                              $earliest_year = date("Y") - 3;
                              $latest_year = date("Y") + 3;
                              foreach (range($earliest_year, $latest_year) as $i) {
                              ?>
                                <option value="<?= $i ?>"><?= $i ?></option>
                              <?php
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="col" style="padding-right: 2px;">
                          <div class="form-group">
                            <label for="task_edit_baseline_end_time_h">Finish time</label>
                            <select class="form-control mdb-select dropdown-primary" id="task_edit_baseline_end_time_h" style="width: 100%">
                              <option value="">Hour</option>
                              <?php
                              $earliest_hour = 0;
                              $latest_hour = 23;
                              foreach (range($earliest_hour, $latest_hour) as $i) {
                                if ($i < 10) {
                                  $i = "0" . $i;
                                }
                              ?>
                                <option value="<?= $i ?>"><?= $i ?></option>
                              <?php
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="col" style="padding-left: 2px;">
                          <div class="form-group">
                            <select class="form-control mdb-select dropdown-primary" id="task_edit_baseline_end_time_m" style="width: 100%">
                              <option value="">Mins</option>
                              <option value="00">00</option>
                              <option value="05">05</option>
                              <option value="10">10</option>
                              <option value="15">15</option>
                              <option value="20">20</option>
                              <option value="25">25</option>
                              <option value="30">30</option>
                              <option value="35">35</option>
                              <option value="40">40</option>
                              <option value="45">45</option>
                              <option value="50">50</option>
                              <option value="55">55</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          </div>
          <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary save-task">Save changes</button>
      </div>
         </form>
    </div>
  </div>
</div>
</div>