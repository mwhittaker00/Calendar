<?php
$_PATH =  $_SERVER['DOCUMENT_ROOT'];
require_once($_PATH.'/functions/init.func.php');
// Process assumes AJAX submission from cal.js

$id = $_POST['id'];
$title = $_POST['title'];
$start = $_POST['start'];

if ( isset($_POST['end']) ){
  $end = $_POST['end'];
} else{
  $end = '';
}

$allDay = $_POST['allDay'];
//$location = $_POST['location'];
//$category = $_POST['category'];
$description = $_POST['description'];
/*$image = $_POST['image'];*/
$user = $_SESSION['user']['id'];
$role = $_SESSION['user']['roleID'];
$organization = $_SESSION['org']['id'];

//
// VERIFY THIS ENTRY
// CHECK the database for a link between this user's ID and this event ID
// Either this person has to own the event, or they must be a mod of the same group as this person.
// OR they can be an admin or account contact in this organization
//

// If times are deleted, NaN appears in the time's string.
// If we find this, assume it's intentional and meant to be an all day event.
$startNan;
$endNan;

if ( strpos($start,"NaN") ){
  $allDay = true;
} else{}

$stmt = $db->prepare(
  "UPDATE event
  SET event_name = ?,
    event_desc = ?,
    event_all_day = ?,
    event_start = ?,
    event_end = ?,
    event_modified = CURRENT_TIMESTAMP
  WHERE event_id = ?");
$stmt->bind_param("ssssss", $title,$description,$allDay,$start,$end,$id);
$stmt->execute();
$stmt->close();

echo 'success';
//
// CHECK for category and location information. Update appropriate tables.
//
//
//
// CHECK IF organization IS SET.
// IF SO, ADD THIS EVENT TO THE organization_event TABLE
// IF category IS SET, ADD TO department_event TABLE
// IF $location IS NOT EMPTY, ADD TO location_event TABLE
//
