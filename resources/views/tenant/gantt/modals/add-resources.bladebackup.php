

<div class="modal" tabindex="-1"  id="AddResourcesModel">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Resource Editor</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="accordion" id="accordionExample">
					<div class="accordion-item">
						<h2 class="accordion-header" id="headingOne">
							<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
								Resources Group
							</button>
						</h2>
						<div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
							<div class="accordion-body">
								<form id="GroupForm">
									<div class="form-add">
										<div class="form-group">
											<label for="group_name">Group Name</label>
											<input type="text" class="form-control" id="group_name" aria-describedby="emailHelp" placeholder="Enter Group Name" name="group_name" required="required">
										</div>
										<span class="text-danger" id="groupnameErrorMsg"></span>
										<br/>
										<input type="hidden" id="group_id" value="">
										<div class="add-button">
											<button type="submit" class="btn btn-primary">Add</button>

										</div>
										<br />
										<table class="table table-bordered" id="resource_group_table">
																						
											
										</table>
									</div>	
								</form>
							</div>
						</div>
					</div>
					<div class="accordion-item">
						<h2 class="accordion-header" id="headingTwo">
							<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
								Resources Items
							</button>
						</h2>
						<div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
							<div class="accordion-body">
								<form>
									<div class="form-group">
										<label for="resources_group">Resources Group</label>
											<select class="form-control" id="resources_group" name="resources_group">
												
											</select>
									</div>
									<div class="form-group">
										<label for="Resources_item">Resources Item</label>
										<input type="text" class="form-control" id="Resources_item" aria-describedby="emailHelp" placeholder="Enter Resources Item">
									</div>
									<div class="add-button">
										<button type="button" class="btn btn-primary">Add</button>
									</div>
									<table class="table table-bordered" id="resources_item_table">
										<thead>
											<tr>
												<th scope="col">Group</th>
												<th scope="col">Item Name</th>
												<th scope="col">Action</th>
											</tr>
										</thead>
										<tbody>
											
										</tbody>
									</table>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
			</div>
		</div>
	</div>
</div>