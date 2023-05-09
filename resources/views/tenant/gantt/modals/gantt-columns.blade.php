<div class="modal" tabindex="-1"  id="modal_edit_task_columns">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Gantt Columns Editor</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php 
        $columns = [];
        if($data['columns']->isNotEmpty())
        {
           $columns = json_decode($data['columns'][0]->task_columns);
        }
      
        ?>
        <div class="card" style="-webkit-box-shadow: none; box-shadow: none;">
          <div class="card-body">
            <p>Choose which columns to display in the left-hand pane</p>
            <div class="table-responsive">
            <table id="table_task_columns" class="table align-middle table-nowrap table-hover" style="font-size: 0.8125rem;">
              <thead>
                        <tr>
                           <th>Column</th>
                           <th>Displayed</th>
                        </tr>
                     </thead>
              <tbody>
                <tr data-index="wbs">
                  <td><span>WBS</span></td>
                  <td><input class="customized" type="checkbox" id="task_column_wbs" {{(count($columns) <= 0) ? "" : ((isset($columns[0]->wbs) && $columns[0]->wbs == 1)  ? "checked" : "")}}>
                    <label class="form-check-label" for="task_column_wbs" class="label-table"></label></td>
                </tr>
                <tr data-index="text">
                  <td><span>Name</span></td>
                  <td><input class="customized" type="checkbox" id="task_column_text" {{(count($columns) <= 0) ? "" : ((isset($columns[0]->text) && $columns[0]->text == 1)  ? "checked" : "")}}>
                    <label class="form-check-label" for="task_column_text" class="label-table"></label></td>
                </tr>
                <tr data-index="start_date">
                  <td><span>Start date</span></td>
                  <td><input class="customized" type="checkbox" id="task_column_start_date" {{(count($columns) <= 0) ? "" : ((isset($columns[0]->start_date) && $columns[0]->start_date == 1)  ? "checked" : "")}}>
                    <label class="form-check-label" for="task_column_start_date" class="label-table"></label></td>
                </tr>
                <tr data-index="end_date">
                  <td><span>Finish date</span></td>
                  <td><input class="customized" type="checkbox" id="task_column_end_date" {{(count($columns) <= 0) ? "" : ((isset($columns[0]->end_date) && $columns[0]->end_date == 1)  ? "checked" : "")}}>
                    <label class="form-check-label" for="task_column_end_date" class="label-table"></label></td>
                </tr>
                <tr data-index="progress">
                  <td><span>Progress</span></td>
                  <td><input class="customized" type="checkbox" id="task_column_progress" {{(count($columns) <= 0) ? "" : ((isset($columns[0]->progress) && $columns[0]->progress == 1)  ? "checked" : "")}}>
                    <label class="form-check-label" for="task_column_progress" class="label-table"></label></td>
                </tr>
              
                <tr data-index="baseline_start">
                  <td><span>Baseline start date</span></td>
                  <td><input class="customized" type="checkbox" id="task_column_baseline_start_date" {{(count($columns) <= 0) ? "" : ((isset($columns[0]->baseline_start) && $columns[0]->baseline_start == 1)  ? "checked" : "")}}>
                    <label class="form-check-label" for="task_column_baseline_start_date" class="label-table"></label></td>
                </tr>
                <tr data-index="baseline_end">
                  <td><span>Baseline finish date</span></td>
                  <td><input class="customized" type="checkbox" id="task_column_baseline_end_date" {{(count($columns) <= 0) ? "" : ((isset($columns[0]->baseline_end) && $columns[0]->baseline_end == 1)  ? "checked" : "")}}>
                    <label class="form-check-label" for="task_column_baseline_end_date" class="label-table"></label></td>
                </tr>
                <tr data-index="task_calendar">
                  <td><span>Calendar</span></td>
                  <td><input class="customized" type="checkbox" id="task_column_calendar" {{(count($columns) <= 0) ? "" : ((isset($columns[0]->task_calendar) && $columns[0]->task_calendar == 1)  ? "checked" : "")}}>
                    <label class="form-check-label" for="task_column_calendar" class="label-table"></label></td>
                </tr>
                {{--
                <tr data-index="deadline">
                  <td><span>Deadline</span></td>
                  <td><input class="customized" type="checkbox" id="task_column_deadline" {{(count($columns) <= 0) ? "" : ((isset($columns[0]->deadline) && $columns[0]->deadline == 1)  ? "checked" : "")}}>
                    <label class="form-check-label" for="task_column_deadline" class="label-table"></label></td>
                </tr>
                --}}
                <tr data-index="resource_id">
                  <td><span>Resources</span></td>
                  <td><input class="customized" type="checkbox" id="task_column_resources" {{(count($columns) <= 0) ? "" : ((isset($columns[0]->resource_id) && $columns[0]->resource_id == 1)  ? "checked" : "")}}>
                    <label class="form-check-label" for="task_column_resources" class="label-table"></label></td>
                </tr>
                 <tr data-index="duration_worked">
                  <td><span>Durations</span></td>
                  <td><input class="customized" type="checkbox" id="task_column_durations" {{(count($columns) <= 0) ? "" : ((isset($columns[0]->duration_worked) && $columns[0]->duration_worked == 1)  ? "checked" : "")}}>
                    <label class="form-check-label" for="task_column_durations" class="label-table"></label></td>
                </tr>
              </tbody>
            </table>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success btn-rounded w-md waves-effect waves-light save-task-columns"><i class="mdi mdi-check"></i> Save</button>
      </div>
    </div>
  </div>
</div>