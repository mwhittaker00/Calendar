<?php
$email = $_POST['email'];
$inPassword = $_POST['password'];

$stmt = $db->prepare("SELECT person_password, person_id, person_fname, person_lname, person_created, person_verified
											FROM person
											WHERE person_email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($fetchPassword,$person_id, $person_fname, $person_lname, $person_created, $person_verified);
$stmt->fetch();
$stmt->close();

$passwordVerified = password_verify($inPassword, $fetchPassword);

if ( $passwordVerified ){
	//Check to make sure $person_verified == 1. If so, continue with the log in.
	// If not, redirect to a page where user can resend the verification email.

	if ( $person_verified != 1 ){
		$success = false;
		$_SESSION['error'] = "This account has not been verified. Check your email for verification instructions.";
		header("location:/page/login/");
	}

	// user authenticated and verified email.
	// Set array of $_SESSION['user'][] array. Need to get other information first.
 else{
	 if ( file_exists($_PATH.'/resources/images/uploads/avatar/'.$person_id.'.jpg') ){
     $image = $person_id;
   } else{
     $image = 'default';
   }

		$_SESSION['user'] = [
			'email' => $email,
			'id' => $person_id,
			'fname' => $person_fname,
			'lname' => $person_lname,
			'created' => $person_created,
			'verified' => $person_verified,
			'login' => 1,
			'avatar' => $image
		];

		$org = $db->prepare("SELECT org_name, org_timezone, org_url, org_created,
			 						organization.org_id, person_org.role_id, role_name, dept_name
				FROM organization
				JOIN person_org
				ON organization.org_id = person_org.org_id
				JOIN role
				ON person_org.role_id = role.role_id
				JOIN organization_department
		    ON organization.org_id = organization_department.org_id
		    JOIN person_department
		    ON person_department.person_id = person_org.person_id
				WHERE person_org.person_id = ?");
		$org->bind_param("s", $_SESSION['user']['id']);
		$org->execute();
		$org->bind_result($org_name, $org_timezone, $org_url, $org_created, $org_id, $role_id, $role_name, $dept_name);
		$org->fetch();
		$org->close();

		$_SESSION['user']['roleID'] = $role_id;
		$_SESSION['user']['roleName'] = $role_name;
		$_SESSION['user']['deptName'] = $dept_name;

		$_SESSION['org'] = [
			'name' => $org_name,
			'timezone' => $org_timezone,
			'url' => $org_url,
			'created' => $org_created,
			'id' => $org_id
		];

		// Set logged-in cookie
		// Might want to add a "Stay logged in?" button?
		setcookie('user',$_SESSION['user']['email'],time()+(86400 * 7), "/"); // 30 day cookie
		$success = true;
		header("location:/page/calendar/");
	}
}
else{
	$success = false;
	$_SESSION['error'] = "We couldn't find your email address or password in the system.";
	header("location:/page/login/");
}
/*
if ($usr_cnt === 1){
	// user is logged in.
	$user = $qry_res->fetch_assoc();
	$id = $user['user_id'];
	$region = $user['region_id'];
	$user_level = $user['user_level'];

//
// Set USER cookie
//
	$c_name = 'user';
	$c_value = $username;
	setcookie($c_name,$c_value,time()+(86400 * 30), "/"); // 30 day cookie
	$_SESSION['logged'] = 1;
	$_SESSION['user'] = $id;
	$_SESSION['region'] = $region;
	$_SESSION['user_level'] = $user_level;

	if ( isMod() ){
		if ($region == 0){
			$target='/page/reg2/';
		}
		else{
			$target='/page/regions/'.$region.'/';
		}
	}

	$success = 'true';
}
else{
	// Make sure user isn't logged in somehow, prepare error message, and send back to log in page
	$_SESSION['logged'] = 0;
	$_SESSION['error'] = 'Wrong user name or password. Please try again.';
	$success = 'false';
}*/
?>
