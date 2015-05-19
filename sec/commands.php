<div class="container" id="commands">
	<div class="col-md-12">
		<div class="row">
			<div class="btn-toolbar">
				<div class="btn-group command-btns">
					<button type="button" id="saveBtn" class="btn btn-default" aria-label="Save" onclick="saveAll()">
						<span class="glyphicon glyphicon-save" aria-hidden="true"></span> Save
					</button>
					<button type="button" id="openBtn" class="btn btn-default" aria-label="Open" data-toggle="modal" data-target=".modal-open">
						<span class="glyphicon glyphicon-open" aria-hidden="true"></span> Open
					</button>
					<button type="button" id="importBtn" class="btn btn-default" aria-label="Import" data-toggle="modal" data-target=".modal-import">
						<span class="glyphicon glyphicon-import" aria-hidden="true"></span> Import
					</button>
					<button type="button" id="exportBtn" class="btn btn-default" aria-label="Export" data-toggle="modal" data-target=".modal-export" onclick="exportCode()">
						<span class="glyphicon glyphicon-export" aria-hidden="true"></span> Export
					</button>
					<button type="button" id="refreshBtn" class="btn btn-default" aria-label="Refresh" onclick="refreshAll()">
						<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Refresh
					</button>
					<button type="button" id="newBtn" class="btn btn-default" aria-label="New Session" data-toggle="modal" data-target=".modal-new">
						<span class="glyphicon glyphicon-new-window" aria-hidden="true"></span> New Session
					</button>
					<button type="button" id="autoRefreshBtn" data-checked="0" class="btn btn-default" aria-label="Auto Refresh" onclick="autoRefresh()">
						<span class="glyphicon glyphicon-unchecked" aria-hidden="true"></span> Auto Refresh
					</button>
				</div>
			</div>
		</div>
	</div>
</div>

<hr/>