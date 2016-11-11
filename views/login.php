<?php $_PATH =  $_SERVER['DOCUMENT_ROOT']; ?>

</head>

<body>

<?php require_once($_PATH.'/includes/nav.inc.php'); ?>

	<div class='content content-feature'>
		<div class='container'>
			<div class='row row-centered'>
				<div class="col-xs-8 col-md-4 col-centered">
					<h3>Welcome to Calendar</h3>
					<br />
					<p><a href='/page/register/'>Create an account</a> or log in to get started.</p>
					<form id='reg-signin' action='/process/login/' method='post'>
						<div class='form-group'>
						  <label for='username'>Email:</label>
						  <input type='text' class='form-control' placeholder = 'Email address' maxlength=24 name='email' required />
						</div>

						<div class='form-group'>
						  <label for='password'>Password:</label>
						  <input type='password' class='form-control' placeholder='Password' maxlength=24 name='password' required />
						</div>
						<p><a href='/page/forgot/'>Forgot password</a></p>
						<button type='submit' class='btn btn-default login-button' name='login'>Log In</button>

					</form>

				</div>
			</div>
		</div>
	</div>
