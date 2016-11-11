<?php
$_PATH =  $_SERVER['DOCUMENT_ROOT'];
require_once($_PATH.'/functions/init.func.php');

$locName = $_POST['local-name'];
$lowerloc = strtolower($locName);
$message = '';
$success = true;

// See if this location already exists for this organization

$stmt = $db->prepare("SELECT location_id FROM location_organization
                  WHERE LOWER(location_name) = ?
                  AND org_id = ?
                  LIMIT 1");
$stmt->bind_param("ss", $lowerloc,$_SESSION['org']['id']);
$stmt->execute();
$stmt->store_result();
$loc_rows = $stmt->num_rows;
$stmt->close();

if ( $loc_rows >= 1 ){
  $message = "This location already exists.";
  $success = false;
}

if ( $success ){
  $stmt = $db->prepare("INSERT INTO location_organization
                (location_name,org_id)
                VALUES
                (?,?)");
  $stmt->bind_param("ss",$locName,$_SESSION['org']['id']);
  $stmt->execute();
  $locID = $stmt->insert_id;
  $stmt->close();

  $message = "<li>".$locName."</li>";

}

echo $message;
