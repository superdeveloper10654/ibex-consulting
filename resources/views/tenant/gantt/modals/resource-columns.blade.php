<div class="modal" tabindex="-1" id="modal_edit_resource_columns">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Gantt Columns Editor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php
                $columns = [];
                if ($data['columns']->isNotEmpty()) {
                    $columns = json_decode($data['columns'][0]->resource_columns);
                }
                error_log($data['columns']);
                ?>
                <div class="card">
                    <div class="card-body">
                        <p>Choose which columns to display in the resource pane</p>
                      <div class="table-responsive">
            <table id="table_resource_columns" class="table align-middle table-nowrap table-hover" style="font-size: 0.8125rem;">
              <thead>
                        <tr>
                           <th>Column</th>
                           <th>Displayed</th>
                        </tr>
                     </thead>
                            <tbody>
                                <tr data-index="name">
                                    <td><span>Name</span></td>
                                    <td><input class="customized" type="checkbox" id="resource_column_name"
                                            {{ count($columns) <= 0 ? '' : (isset($columns[0]->name) && $columns[0]->name == 1 ? 'checked' : '') }}>
                                        <label class="form-check-label" for="resource_column_name"
                                            class="label-table"></label>
                                    </td>
                                </tr>
                                <tr data-index="resource_calendar">
                                    <td><span>Calendar</span></td>
                                    <td><input class="customized" type="checkbox" id="resource_column_calendar"
                                            {{ count($columns) <= 0 ? '' : (isset($columns[0]->resource_calendar) && $columns[0]->resource_calendar == 1 ? 'checked' : '') }}>
                                        <label class="form-check-label" for="resource_column_calendar"
                                            class="label-table"></label>
                                    </td>
                                </tr>
                                <tr data-index="complete">
                                    <td><span>Complete</span></td>
                                    <td><input class="customized" type="checkbox" id="resource_column_complete"
                                            {{ count($columns) <= 0 ? '' : (isset($columns[0]->complete) && $columns[0]->complete == 1 ? 'checked' : '') }}>
                                        <label class="form-check-label" for="resource_column_complete"
                                            class="label-table"></label>
                                    </td>
                                </tr>
                                <tr data-index="workload">
                                    <td><span>Workload</span></td>
                                    <td><input class="customized" type="checkbox" id="resource_column_workload"
                                            {{ count($columns) <= 0 ? '' : (isset($columns[0]->workload) && $columns[0]->workload == 1 ? 'checked' : '') }}>
                                        <label class="form-check-label" for="resource_column_workload"
                                            class="label-table"></label>
                                    </td>
                                </tr>
                                <tr data-index="unit_cost">
                                    <td><span>Unit Cost</span></td>
                                    <td><input class="customized" type="checkbox" id="resource_column_unit_cost"
                                            {{ count($columns) <= 0 ? '' : (isset($columns[0]->unit_cost) && $columns[0]->unit_cost == 1 ? 'checked' : '') }}>
                                        <label class="form-check-label" for="resource_column_unit_cost"
                                            class="label-table"></label>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
          </div>
            <div class="modal-footer">
        <button type="submit" class="btn btn-success btn-rounded w-md waves-effect waves-light save-resource-columns"><i class="mdi mdi-check"></i> Save</button>
      </div>
        </div>
    </div>
</div>
