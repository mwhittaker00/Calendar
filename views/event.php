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
						<h3><span class='glyphicon glyphicon-calendar' aria-hidden='true'></span> Events</h3>

				</div>

				<div class='col-sm-9 right-panel panel tab-content'>
          <h3><?=$event_name;?></h3>
					<h4><?=$event_day;?></h4>
					<h4><?=$start_time;?></h4>
					<h4><?=$location_name;?></h4>
					<p><?=$event_desc;?></p>

			</div>

		</div>
	</div>
