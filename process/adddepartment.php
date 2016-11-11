<?php
$_PATH =  $_SERVER['DOCUMENT_ROOT'];
require_once($_PATH.'/functions/init.func.php');

$deptName = $_POST['dept-name'];
$lowerDept = strtolower($deptName);
$message = '';
$success = true;

// See if this department already exists for this organization

$stmt = $db->prepare("SELECT dept_id FROM organization_department
                  WHERE LOWER(dept_name) = ?
                  AND org_id = ?
                  LIMIT 1");
$stmt->bind_param("ss", $lowerDept,$_SESSION['org']['id']);
$stmt->execute();
$stmt->store_result();
$dept_rows = $stmt->num_rows;
$stmt->close();

if ( $dept_rows >= 1 ){
  $message = "This department already exists.";
  $success = false;
}

if ( $success ){
  $stmt = $db->prepare("INSERT INTO organization_department
                (dept_name,org_id)
                VALUES
                (?,?)");
  $stmt->bind_param("ss",$deptName,$_SESSION['org']['id']);
  $stmt->execute();
  $deptID = $stmt->insert_id;
  $stmt->close();

  $message = "<option value='".$deptID."'>".$deptName."</option>";

}

echo $message;
