<div class="modal" tabindex="1" id="AddResourcesModel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Resource Editor</h5>
{{--                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
            </div>
            <div class="modal-body">
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Resources Group
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <form id="GroupForm">
                                    <table class="table table-bordered" id="resource_group_table">
                                    </table>
                                    <div class="my-2 d-flex justify-content-end col-md-11">
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>&nbsp;Save</button>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <button type="button" class="btn btn-primary" onclick="addResourceGroupRow()"><i class="fas fa-plus"></i>&nbsp;Add</button>
                                    </div>
                                    <select class="form-control mdb-select dropdown-primary" id="resource_calendars" style="font-size: 0.8em">
                                    <?php
                                        if($data['calendars'] != null)
                                        {
                                            foreach($data['calendars'] as $key)
                                            {
                                                if($key->type == 2)
                                                {
                                    ?>
                                        <option value="<?php echo $key->id; ?>"><?php echo $key->name; ?>
                                    <?php
                                                }
                                            }
                                        }
                                    ?>
                                    </select>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Resources Items
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <form id="resourceForm">
                                    <div class="form-group">
                                        <label for="resources_group">Resources Group</label>
                                        <select class="form-control" id="resources_group" name="resources_group"
                                            required="required">
                                        </select>
                                    </div>
                                    <span class="text-danger" id="resourcegroupErrorMsg"></span>
                                    <div class="form-group">
                                        <label for="Resources_item">Resources Item</label>
                                        <input type="text" class="form-control" id="Resources_item"
                                            aria-describedby="emailHelp" placeholder="Enter Resources Item"
                                            required="required">
                                    </div>
                                    <span class="text-danger" id="itemnameErrorMsg"></span>
                                    <div class="form-group">
                                        <label for="resource_group_calendar_id">Calendar</label>
                                        <select class="form-control mdb-select dropdown-primary"
                                            id="resource_group_calendar_id" style="font-size: 0.8em"
                                            required="required">
                                            <?php
											if($data['calendars'] != null)
											{
												foreach($data['calendars'] as $key)
												{
													if($key->type == 2)
													{
													?>
                                            <option class="form-control" value="<?php echo $key->id; ?>"><?php echo $key->name; ?>
                                                <?php
												}
											 }
											}
											?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="Resources_item">Unit Cost</label>
                                        <input type="text" class="form-control" id="resource_unit_cost"
                                            aria-describedby="emailHelp" placeholder="Enter Unit Cost"
                                            required="required">
                                    </div>
                                    <span class="text-danger" id="calendargroupnameErrorMsg"></span>
                                    <br />
                                    <input type="hidden" id="resources_group_id" value="">
                                    <div class="add-button mb-3">
                                        <button type="submit" class="btn btn-primary">Add</button>
                                    </div>
                                    <table class="table table-bordered" id="resources_item_table">

                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="onCloseResourceModal()">Close</button>
            </div>
        </div>
    </div>
</div>
