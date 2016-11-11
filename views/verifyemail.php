<?php $_PATH =  $_SERVER['DOCUMENT_ROOT']; ?>

</head>

<body>

<?php require_once($_PATH.'/includes/nav.inc.php'); ?>

	<div class='content content-feature'>
		<div class='container'>
			<div class='row row-centered'>
				<div class="col-xs-8 col-md-4 col-centered">

<?php
if ( !isset($_SESSION['registered']) ){
?>
					<h3>Email Verification.</h3>
					<br />
					<form id='reg-signin' action='/process/verifyemail/' method='post'>
						<div class='form-group'>
						  <label for='verification'>Paste your email verification code below.</label>
						  <input type='text' class='form-control' placeholder = '' maxlength=24 name='verification' id='verification' required />
						</div>

						<button type='submit' class='btn btn-default login-button' name='submit'>Submit</button>

					</form>
<?php
} // end IF
else{
?>
					<h3>Verification email has been sent!</h3>
					<br />
					<p>
						Thanks for signing up with CALENDAR! We've sent you an email with further instructions.
					</p>

<?php
} // end ELSE
?>
				</div>
			</div>
		</div>
	</div>
