<div id="add-note-modal" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><span class="location-note-title"></span> Add New Note</h4>
			</div>
			<div class="modal-body">
				<form id="add-note-form">
					<div class="row col-sm-12">
						<label class="required control-label" for="note_type">Note Type <i class="fa fa-asterisk"></i></label>
						<select id="note_type-id" name="type" class="form-control" onchange="filter()">
							<option value="general">General</option>
							<option value="email sent">Email Sent</option>
							<option value="email contact">Email Contact</option>
							<option value="attempted to call">Attempted to Call</option>
							<option value="phone contact">Phone Contact</option>
						</select>
					</div>
					<div id="note-row" class="row">
						<div class="control-group col-sm-12">
							<label class="required control-label" for="content">Content <i class="fa fa-asterisk"></i></label>
							<textarea name="content" id="content-id" class="form-control counter" rows="5"></textarea>
						</div>
					</div>
					<input type="hidden" id="note_ref_fk-id" name="ref_fk" value="">
					<input type="hidden" id="note_table_ref-id" name="ref_table" value="practice" value="{$asset_single}">
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button id="btn-save-note" type="button" class="btn btn-success" data-dismiss="modal">Save</button>
			</div>
		</div>
	</div>
</div>
<div id="add-task-modal" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><span class="location-note-title"></span> Create New Task</h4>
			</div>
			<div class="modal-body">
				<form id="add-task-form">
					<div id="task-row" class="row">
						<div class="control-group col-sm-12">
							<label class="required control-label" for="task">Task Details<i class="fa fa-asterisk"></i></label>
							<textarea name="content" id="task_input-id" class="form-control counter" rows="5"></textarea>
						</div>
						<input type="hidden" id="task_ref_fk-id" name="ref_fk">
						<input type="hidden" id="task_ref_table-id" name="ref_table" value="{$asset_single}">
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button id="btn-save-task" type="button" class="btn btn-success" data-dismiss="modal">Save</button>
			</div>
		</div>
	</div>
</div>