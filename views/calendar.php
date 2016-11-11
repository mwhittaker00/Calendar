<?php $_PATH =  $_SERVER['DOCUMENT_ROOT']; ?>

<!-- PAGE SPECIFIC CSS -->
<link href='/resources/css/fullcalendar.css' rel='stylesheet' />
<link href='/resources/css/bootstrap-datepicker.standalone.min.css' rel='stylesheet' />
<link rel='stylesheet' type='text/css' href='/resources/css/bootstrap-timepicker.min.css' />
<link href='/resources/css/fullcalendar.print.css' rel='stylesheet' media='print' />

<!-- PAGE SPECIFIC JS -->
<script src='/resources/js/fullcalendar.js'></script>
<script src='/resources/js/bootstrap-datepicker.min.js'></script>
<script src='/resources/js/bootstrap-timepicker.min.js'></script>
<script src='/resources/js/cal.js'></script>

</head>

<body>

	<?php include("$_PATH/includes/nav.inc.php"); ?>

	<div class='content'>
		<div class='container-fluid calendar-container'>

			<div class='row-fluid'>
				<div class='col-sm-3 left-panel panel'>

					<ul class='nav nav-tabs'>
						<li  class="active">
							<a href=".events-panel" id="events-toggle" data-toggle='tab'>Events</a>
						</li>
						<li>
							<a href=".control-panel" data-toggle='tab'>Controls</a>
						</li>

					</ul>
					<div id='userTabContent' class='tab-content'>

						<div id='events' class='tab-pane active events-panel'>

							<h3><span class='glyphicon glyphicon-calendar' aria-hidden='true'></span> Events</h3>

							<form method='post' action='.' id='calendar-update' enctype='multipart/form-data'>
								<input type="hidden" name="MAX_FILE_SIZE" value="30000" />
								<label for='event-title'>
									Title:*
								</label>
								<div class='input-group'>
									<input type='text' id='event-title' class='form-control' name='event-title' required />
								</div>

								<label for='event-start-date'>
									Start Date:*
								</labeL>
								<div class='input-group date'>
									<input type='text' name='event-start-date' id='event-start-date' class='form-control' required="">
									<span class='input-group-addon'>
										<i class='glyphicon glyphicon-th'></i>
									</span>
								</div>

								<label for='event-end-date'>
									End Date:
								</labeL>
								<div class='input-group date'>
									<input type='text' name='event-end-date' id='event-end-date' class='form-control'>
									<span class='input-group-addon'>
										<i class='glyphicon glyphicon-th'></i>
									</span>
								</div>

								<label for='event-start-time'>
									Start Time:
								</label>
								<div class="input-group bootstrap-timepicker timepicker">
			            <input id="event-start-time" type="text" class="event-time form-control input-small" name="event-start-time">
			            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
			        	</div>

								<label for='event-end-time'>
									End Time:
								</label>
								<div class="input-group bootstrap-timepicker timepicker">
			            <input id="event-end-time" type="text" class="event-time form-control input-small" name="event-end-time">
			            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
			        	</div>

								<input type='checkbox' id='event-all-day' name='event-all-day' value='1'> All day event.<br /><br />

								<label for="event-location">
									Where:
								</label>
								<div class='input-group'>
									<select class='form-control' id='event-location' name='event-location' required>


<? if ( $dept_rows == 0 ){ ?>

          <option></option>

<? } // end dept_rows check
else{ // run the departments list ?>

<?for($i = 0; $i < count($location['id']); $i++) { ?>

          <option value="<?=$location['id'][$i];?>"><?=$location['name'][$i];?></option>

<? } // end FOR loop
} // end ELSE ?>


									</select>
								</div>

								<label for='event-department'>
									Department:
								</label>
								<div class='input-group'>
									<select class='form-control' id='event-department' name='event-department' required>

<? if ( $dept_rows == 0 ){ ?>

          						<option></option>

<? } // end dept_rows check
else{ // run the departments list ?>

<?for($i = 0; $i < count($dept['id']); $i++) { ?>

          						<option value="<?=$dept['id'][$i];?>"><?=$dept['name'][$i];?></option>

<? } // end FOR loop
} // end ELSE ?>

        					</select>

								</div>

								<label for='event-desc'>
									Description
								</label>
								<div class='input-group'>
									<textarea class='form-control' id='event-desc' name='event-desc'></textarea>
								</div>


								<!--
								<div class="fileinput fileinput-new" data-provides="fileinput">
								  <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 150px; height: 150px;"></div>
								  <div>
								    <span class="btn btn-default btn-file">
											<span class="fileinput-new">Select image</span>
											<span class="fileinput-exists">Change</span>
											<input type="file" name="event-picture" id="event-picture">
										</span>
								    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
								  </div>
								</div>
							-->
							<br />
								<div>
									<input type='submit' class='btn btn-default login-button' />
								</div>
							</form>


						</div>

						<div class='tab-pane control-panel'>

							<div class='tab-content'>
								<div class='tab-pane settings-panel active'>

<?php
 	include($_PATH.'/includes/page/settings-panel.php');
?>

								</div>

								<div class='tab-pane users-panel'>

<?php
 	include($_PATH.'/includes/page/users-panel.php');
?>

								</div>

								<div class='tab-pane notifications-panel'>

<?php
 	include($_PATH.'/includes/page/notifications-panel.php');
?>

								</div>

								<div class='tab-pane customize-panel'>

<?php
 	include($_PATH.'/includes/page/customize-panel.php');
?>

								</div>

								<div class='tab-pane export-panel'>

<?php
	include($_PATH.'/includes/page/export-panel.php');
?>

								</div>

							</div>


						</div>

					</div>

				</div>

				<div class='col-sm-9 right-panel panel tab-content'>
					<div class='tab-pane events-panel active'>
						<h2><?=$_SESSION['org']['name'];?></h2>

						<div id='calendar'></div>
					</div>

					<div class='tab-pane control-panel'>

						<ul class='nav nav-tabs'>
							<li>
								<a href='.settings-panel' data-toggle='tab'>
									<span class='glyphicon glyphicon-cog' aria-hidden='true'></span> Settings
								</a>
							</li>

							<li>
								<a href='.users-panel' data-toggle='tab'>
									<span class='glyphicon glyphicon-user' aria-hidden='true'></span> Users
								</a>
							</li>
							<li>
								<a href='.notifications-panel' data-toggle='tab'>
									<span class='glyphicon glyphicon-bell' aria-hidden='true'></span> Notifications
								</a>
							</li>
							<li>
								<a href='.customize-panel' data-toggle='tab'>
									<span class='glyphicon glyphicon-wrench' aria-hidden='true'></span> Customize
								</a>
							</li>
							<li>
								<a href='.export-panel' data-toggle='tab'>
									<span class='glyphicon glyphicon-download-alt' aria-hidden='true'></span> Export Tool
								</a>
							</li>
						</ul>

						<div class='tab-content'>
							<div class='tab-pane settings-panel active'>

<?php
 	include($_PATH.'/includes/page/settings-content.php');
?>

							</div>

							<div class='tab-pane location-panel'>

<?php
 	include($_PATH.'/includes/page/location-content.php');
?>

							</div>

							<div class='tab-pane users-panel'>

<?php
 	include($_PATH.'/includes/page/users-content.php');
?>

							</div>

							<div class='tab-pane notifications-panel'>

<?php
 	include($_PATH.'/includes/page/notifications-content.php');
?>

							</div>

							<div class='tab-pane customize-panel'>

<?php
 	include($_PATH.'/includes/page/customize-content.php');
?>

							</div>

							<div class='tab-pane export-panel'>

<?php
 	include($_PATH.'/includes/page/export-content.php');
?>

							</div>

						</div>

				</div>
			</div>

		</div>
	</div>
