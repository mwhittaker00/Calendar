<?php

$key = $_GET['key'];
$id = $_GET['use'];
$stmt = $db->prepare(
	"SELECT person_id, person_verificationKey
		FROM person
		WHERE person_id = ?
		AND person_verificationKey = ?
		LIMIT 1");
$stmt->bind_param("ss",$id,$key);
$stmt->execute();
$stmt->bind_result($fetchID,$fetchKey);
$stmt->fetch();
$stmt->close();

// If we found the user's key and ID, set verified to 1
if ($fetchID){
	$stmt = $db->prepare(
		"UPDATE person
			SET person_verified = 1
			WHERE person_id = ?
			LIMIT 1");
	$stmt->bind_param("s",$fetchID);
	$stmt->execute();
	$stmt->close();

	$_SESSION['success'] = "All set! Log in to get started!";
	$success = true;
	header("location:/page/home/");
} else{
	$_SESSION['error'] = "We couldn't find that verification key. Please try using the link you recieved in your email.";
	$success = false;
	header("location:/page/home/");
}
