<!-- Modals -->
<div class="modal fade modal-delete" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Confirm Delete Task</h4>
			</div>
			<div class="modal-body">
				<p>Are you sure you wish to delete this task?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-danger task-delete-confirm" data-dismiss="modal" onclick="deleteRow(2,null)">Delete</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade modal-open" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Open Session</h4>
			</div>
			<div class="modal-body">
				<p>Type in the session code you wish to open:</p>
				<div class="form-group">
					<input type="text" class="form-control" id="openCode" placeholder="Code" maxlength="5">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-success open-confirm" data-dismiss="modal" onclick="openCode()">Open</button>                </div>
		</div>
	</div>
</div>

<div class="modal fade modal-import" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Import Session</h4>
			</div>
			<div class="modal-body">
				<p>Paste the code you wish to import:</p>
				<div class="form-group">
					<textarea class="form-control" id="importCode" placeholder="Import Data"></textarea>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-success load-confirm" data-dismiss="modal" onclick="importCode()">Import</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade modal-export" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Export Session</h4>
			</div>
			<div class="modal-body">
				<p>Copy the following data to export:</p>
				<div class="form-group">
					<!--<textarea class="form-control" id="exportCode" placeholder="Export Data"></textarea>-->
					<pre id="exportCode"></pre>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Done</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade modal-new" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Confirm New Session</h4>
			</div>
			<div class="modal-body">
				<p>Are you sure you wish to start a new session? You will lose all data from the current session.</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-danger task-delete-confirm" data-dismiss="modal" onclick="newSession()">Yes, I'm sure</button>
			</div>
		</div>
	</div>
</div>