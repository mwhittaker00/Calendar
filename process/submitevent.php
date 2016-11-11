<?php
$_PATH =  $_SERVER['DOCUMENT_ROOT'];
require_once($_PATH.'/functions/init.func.php');
// Process assumes AJAX submission from cal.js
$post = json_encode($_POST);

$title = $_POST['title'];
$start = $_POST['start'];
$end = $_POST['end'];
$allDay = $_POST['allDay'];
$location = $_POST['location'];
$department = $_POST['department'];
$description = $_POST['description'];
/*$image = $_POST['image'];*/
$user = $_SESSION['user']['id'];
$role = $_SESSION['user']['roleID'];
$organization = $_SESSION['org']['id'];

// Set default for event_approved to 0 is user role is 1
// anything higher doesn't need approval
if ( $role <= 1 ){
  $event_approved = 0;
} else{
  $event_approved = 1;
}


// If times are deleted, NaN appears in the time's string.
// If we find this, assume it's intentional and meant to be an all day event.
$startNan;
$endNan;

if ( strpos($start,"NaN") || strpos($end, "NaN") ){
  $allDay = true;
} else{}

$stmt = $db->prepare(
  "INSERT INTO event
  (event_name, event_desc, event_publish, event_approved, event_all_day, event_start, event_end)
    VALUES
  (?,?,CURRENT_TIMESTAMP,?,?,?)");
$stmt->bind_param("ssssss", $title,$description,$event_approved,$allDay,$start,$end);
$stmt->execute();
$insertID = $stmt->insert_id;
$stmt->close();

$stmt = $db->prepare(
  "INSERT INTO person_event
    (person_id, event_id)
  VALUES
    (?,?)");

$stmt->bind_param("ii",$user, $insertID);
$stmt->execute();
$stmt->close();


// If there is a DEPARTMENT value, insent into department_event
//
// Should consider validating that submitted department links to this organization

if ( is_numeric($department) && $department >= 1 ){
  $stmt = $db->prepare("INSERT INTO department_event
                (dept_id,event_id)
                VALUES
                (?,?)");
  $stmt->bind_param("ss",$department,$insertID);
  $stmt->execute();
  $stmt->close();
} else{}

// If there is a LOCATION value, insert into location_event
//
// Consider validating that submitted location links to this organization
if ( is_numeric($location) && $location >= 1 ){
  $stmt = $db->prepare("INSERT INTO location_event
                (location_id,event_id)
                VALUES
                (?,?)");
  $stmt->bind_param("ss",$location,$insertID);
  $stmt->execute();
  $stmt->close();
} else{}

// INSERT event link to ORGANIZATION
$stmt = $db->prepare("INSERT INTO organization_event
                (org_id,event_id)
                VALUES
                (?,?)");
  $stmt->bind_param("ss",$organization,$insertID);
  $stmt->execute();
  $stmt->close();

// Insert links to notifications based on the current user's role.
// If they're a user, insert a link to notification_department so mods can see it.
// If they're mods, don't worry about it.

if ( $event_approved == 0 ){
  // Insert actual notification
  $message = "A new event was submitted by ".$_SESSION['user']['email'].". LINK TO EVENT DISPLAY.";
  $stmt = $db->prepare("INSERT INTO notification
                    (notification_content)
                    VALUES
                    (?)");
  $stmt->bind_param('s',$message)
  $stmt->execute();
  $notificationID = $stmt->insert_id;
  $stmt->close();

  // Insert link to notification_department
  $stmt = $db->prepare("INSERT INTO notification_department
                      (notification_id, org_id)
                      VALUES
                      (?,?)");
  $stmt->bind_param('ss',$notificationID,$organization);
  $stmt->execute();
  $stmt->close();
}
//
// CHECK IF organization IS SET.
// IF SO, ADD THIS EVENT TO THE organization_event TABLE
// IF department IS SET, ADD TO department_event TABLE
// IF $location IS NOT EMPTY, ADD TO location_event TABLE
//
