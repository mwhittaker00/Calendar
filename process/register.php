<?php

$error = "There was a problem submitting this form. Please try again.";
$success = false;



$email = $_POST['email'];
$password = $_POST['password'];
$password2 = $_POST['password2'];


if (empty($email) || empty($password) || empty($password2)){
			$error = "You left a field blank. Please try again.";
      $success = false;
		}
if ($password !== $password2){
			$error = "You did not enter matching passwords. Please try again.";
      $success = false;
		}
else{
	$success = true;
	// prepare hashed password
	$passwordHash = password_hash($password, PASSWORD_DEFAULT);
}

if ( $success ){

	// Check if email is already in the database
	$stmt = $db->prepare("SELECT person_email
					FROM person
						WHERE person_email = ?
						LIMIT 1");
	$stmt->bind_param("s",$email);
	$stmt->execute();
	$stmt->bind_result($fetchEmail);
	$stmt->fetch();
	$stmt->close();
	if ($fetchEmail){
		$error = "This email address is already in use. Try the <a href='/page/login'>Log In</a> page instead.";
		$success = false;
	}
	else{
		$keyHash = md5($email.time());
	}

	// Add person to database
	$stmt = $db->prepare(
		"INSERT INTO person
			(person_email, person_password, person_verificationKey)
		VALUES
			(?,?,?)");
	$stmt->bind_param("sss", $email,$passwordHash,$keyHash);
	$stmt->execute();
	$insertID = $stmt->insert_id;
	$stmt->close();

	// PREPARE VERIFICATION email
	$url = "http://calendar.fromashes.co/process/verifyemail/".$keyHash."/".$insertID."/";
	$to = $email;
	$subject = "Welcome to Calendar!";
	$message = "Thanks for signing up with our calendar!<br /><br />";
	$message .= "We're excited to get you started with your new calendar. First, we need you to verify this email account for us.<br /><br />";
	$message .= "Use the link below or paste the URL into your browser's address bar to continue.<br /><br />";
	$message .= $url;

	$headers = "From: Calendar Site <no-reply@fromashes.co>"."\r\n";
	$headers = "Reply-To: no-reply@calendar.fromashes.co"."\r\n";
	$headers .= "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";


	mail($to,$subject,$message,$headers);
	$_SESSION['registered'] = 1;
	$_SESSION['success'] = "Almost ready to go! Check your email for a verification link! It might take a minute or two to arrive.";
	header("location:/page/login/");
}
?>
