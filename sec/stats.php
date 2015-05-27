<div class="container">

	<a href="javascript:void(0)" onclick="$('#stats').fadeToggle();calculateStats();">
		<h3>Statistics</h3>
	</a>
	
	<div id="stats" style="display:none;">		
		<div class="row">
			<div class="col-xs-3 col-lg-1"><b>Today</b></div>
				<div class="col-xs-1 col-lg-1" id="stat-tasks-t"></div>
			<div class="col-xs-3 col-lg-1"><b>Yesterday</b></div>
				<div class="col-xs-1 col-lg-1" id="stat-tasks-y"></div>
			<div class="col-xs-3 col-lg-1"><b>All-time</b></div>
				<div class="col-xs-1 col-lg-1" id="stat-tasks-a"></div>
			<div class="col-xs-3 col-lg-1"><b>BD today</b></div>
				<div class="col-xs-1 col-lg-1" id="stat-bd-t"></div>
			<div class="col-xs-3 col-lg-1"><b>BD yday</b></div>
				<div class="col-xs-1 col-lg-1" id="stat-bd-y"></div>
			<div class="col-xs-3 col-lg-1"><b>BD vs yday</b></div>
				<div class="col-xs-1 col-lg-1" id="stat-bd-c"></div>
		</div>
		<br/>
		<div class="row" style="padding-bottom:20px;border-bottom:1px solid #eee">
			<div class="col-xs-2">Today</div>
			<div class="col-xs-10" id="stat-g-t">
				<div class="progress">
					<div data-toggle="tooltip" data-original-title="Business Development" class="bd progress-bar progress-bar-success"></div>
					<div data-toggle="tooltip" data-original-title="Email Sent" class="se progress-bar progress-bar-info"></div>
					<div data-toggle="tooltip" data-original-title="Visit Booked" class="vb progress-bar progress-bar-success"></div>
					<div data-toggle="tooltip" data-original-title="Call Back Later" class="cl progress-bar progress-bar-info"></div>
					<div data-toggle="tooltip" data-original-title="Left Message" class="lm progress-bar progress-bar-warning"></div>
					<div data-toggle="tooltip" data-original-title="Not Interested" class="ni progress-bar progress-bar-danger"></div>
					<div data-toggle="tooltip" data-original-title="Reception Block/Couldn't Connect" class="rb progress-bar progress-bar-warning"></div>
				</div>
				<span class="label label-success">BD: <span id="stat-gl-t-bd"></span></span>&nbsp;
				<span class="label label-info">@: <span id="stat-gl-t-se"></span></span>&nbsp;
				<span class="label label-success">Visit: <span id="stat-gl-t-vb"></span></span>&nbsp;
				<span class="label label-info">Call later: <span id="stat-gl-t-cl"></span></span>&nbsp;
				<span class="label label-warning">LMTCB: <span id="stat-gl-t-lm"></span></span>&nbsp;
				<span class="label label-danger">No Interest: <span id="stat-gl-t-ni"></span></span>&nbsp;
				<span class="label label-warning">No Conn: <span id="stat-gl-t-rb"></span></span>&nbsp;
				<span class="label label-default">N/A: <span id="stat-gl-t-in"></span></span>
			</div>
		</div>
		<div class="row" style="padding-bottom:20px;border-bottom:1px solid #eee">
			<div class="col-xs-2">Yesterday</div>
			<div class="col-xs-10" id="stat-g-y">
				<div class="progress">
					<div data-toggle="tooltip" data-original-title="Business Development" class="bd progress-bar progress-bar-success"></div>
					<div data-toggle="tooltip" data-original-title="Email Sent" class="se progress-bar progress-bar-info"></div>
					<div data-toggle="tooltip" data-original-title="Visit Booked" class="vb progress-bar progress-bar-success"></div>
					<div data-toggle="tooltip" data-original-title="Call Back Later" class="cl progress-bar progress-bar-info"></div>
					<div data-toggle="tooltip" data-original-title="Left Message" class="lm progress-bar progress-bar-warning"></div>
					<div data-toggle="tooltip" data-original-title="Not Interested" class="ni progress-bar progress-bar-danger"></div>
					<div data-toggle="tooltip" data-original-title="Reception Block/Couldn't Connect" class="rb progress-bar progress-bar-warning"></div>
				</div>
				<span class="label label-success">BD: <span id="stat-gl-y-bd"></span></span>
				<span class="label label-info">@: <span id="stat-gl-y-se"></span></span>
				<span class="label label-success">Visit: <span id="stat-gl-y-vb"></span></span>
				<span class="label label-info">Call later: <span id="stat-gl-y-cl"></span></span>
				<span class="label label-warning">LMTCB: <span id="stat-gl-y-lm"></span></span>
				<span class="label label-danger">No Interest: <span id="stat-gl-y-ni"></span></span>
				<span class="label label-warning">No Conn: <span id="stat-gl-y-rb"></span></span>
				<span class="label label-default">N/A: <span id="stat-gl-y-in"></span></span>
			</div>
		</div>
		<div class="row" style="padding-bottom:20px;border-bottom:1px solid #eee">
			<div class="col-xs-2">All-Time</div>
			<div class="col-xs-10" id="stat-g-a">
				<div class="progress">
					<div data-toggle="tooltip" data-original-title="Business Development" class="bd progress-bar progress-bar-success"></div>
					<div data-toggle="tooltip" data-original-title="Email Sent" class="se progress-bar progress-bar-info"></div>
					<div data-toggle="tooltip" data-original-title="Visit Booked" class="vb progress-bar progress-bar-success"></div>
					<div data-toggle="tooltip" data-original-title="Call Back Later" class="cl progress-bar progress-bar-info"></div>
					<div data-toggle="tooltip" data-original-title="Left Message" class="lm progress-bar progress-bar-warning"></div>
					<div data-toggle="tooltip" data-original-title="Not Interested" class="ni progress-bar progress-bar-danger"></div>
					<div data-toggle="tooltip" data-original-title="Reception Block/Couldn't Connect" class="rb progress-bar progress-bar-warning"></div>
				</div>
				<span class="label label-success">BD: <span id="stat-gl-a-bd"></span></span>
				<span class="label label-info">@: <span id="stat-gl-a-se"></span></span>
				<span class="label label-success">Visit: <span id="stat-gl-a-vb"></span></span>
				<span class="label label-info">Call later: <span id="stat-gl-a-cl"></span></span>
				<span class="label label-warning">LMTCB: <span id="stat-gl-a-lm"></span></span>
				<span class="label label-danger">No Interest: <span id="stat-gl-a-ni"></span></span>
				<span class="label label-warning">No Conn: <span id="stat-gl-a-rb"></span></span>
				<span class="label label-default">N/A: <span id="stat-gl-a-in"></span></span>
			</div>
		</div>
	</div>

</div>

<hr/>