<?php $_PATH =  $_SERVER['DOCUMENT_ROOT']; ?>

</head>

<body>

<?php require_once($_PATH.'/includes/nav.inc.php'); ?>

	<div class='content content-feature'>
		<div class='container'>
			<div class='row row-centered'>
				<div class="col-xs-8 col-md-4 col-centered">
					<h3>Create an account.</h3>
					<br />
					<form id='reg-signin' action='/process/register/' method='post'>
						<div class='form-group'>
						  <label for='username'>Email:</label>
						  <input type='text' class='form-control' placeholder = '' maxlength=24 name='email' required />
						</div>

						<div class='form-group'>
						  <label for='password'>Password:</label>
						  <input type='password' class='form-control' placeholder='' maxlength=24 name='password' autocomplete="false" required />
						</div>

            <div class='form-group'>
						  <label for='password'>Re-enter password:</label>
						  <input type='password' class='form-control' placeholder='' maxlength=24 name='password2' autocomplete="false" required />
						</div>

            <p>By clicking below you agree to our <a href='/page/terms/'>Terms of Use</a>.</p>

						<button type='submit' class='btn btn-default login-button' name='login'>Sign Up</button>

					</form>

				</div>
			</div>
		</div>
	</div>
