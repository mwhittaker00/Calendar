<?php
$_PATH =  $_SERVER['DOCUMENT_ROOT'];
require_once($_PATH.'/functions/init.func.php');

print_r($_POST);

$email = $_POST['email'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$dept = $_POST['department'];
$role = $_POST['role'];

$error_message = '';
$success = true;
//
// SUPER FUN INPUT DATA VALIDATION STUFF
//

// Make sure value for ROLE is valid

$stmt = $db->prepare("SELECT role_id FROM role
                    WHERE role_id = ?");
$stmt->bind_param("s", $role);
$stmt->execute();
$stmt->store_result();
$role_rows = $stmt->num_rows;
$stmt->close();

if ( $role_rows != 1 ){
  $error_message = "Invalid entry.";
  $success = false;
} else{}

/// Check if email already exists for this organization

$stmt = $db->prepare("SELECT person_id FROM person
                WHERE person_email = ?
                LIMIT 1");
$stmt->bind_param('s',$email);
$stmt->execute();
$stmt->store_result();
$email_rows = $stmt->num_rows;
$stmt->close();

if ( $email_rows > 0 ){
  $error_message = "This email already exists.";
  $success = false;
} else{}

//
// CHECK FOR DEPARTMENT IN organization_department
//

// If we're all clear, add the new user to PERSON
//
// Also add link to person_org
// Add link to person_department

if ( $success ){
  // create hash for person_verificationKey
  $keyHash = md5($email.time());

  // add to PERSON table
  $stmt = $db->prepare("INSERT INTO person
                (person_email,person_fname,person_lname,person_password,person_verificationKey)
                VALUES
                (?,?,?,'0',?)");
  $stmt->bind_param('ssss',$email,$fname,$lname,$keyHash);
  $stmt->execute();
  $userID = $stmt->insert_id;
  $stmt->close();

  // add link tp PERSON_ORG
  $stmt = $db->prepare("INSERT INTO person_org
                  (person_id,org_id,role_id)
                  VALUES
                  (?,?,?)");
  $stmt->bind_param('sss',$userID,$_SESSION['org']['id'],$role);
  $stmt->execute();
  $stmt->close();
}
