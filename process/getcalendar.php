<?php
$_PATH =  $_SERVER['DOCUMENT_ROOT'];
include($_PATH.'/functions/init.func.php');
$user = $_SESSION['user']['id'];
$stmt = $db->prepare("SELECT event.event_id AS 'id',
        event_name AS 'title',
        event_desc AS 'description',
        event_start AS 'start',
        event_end AS 'end',
        event_all_day AS 'allDay',
        event_approved AS 'approved'
      FROM event
      JOIN organization_event
      ON event.event_id = organization_event.event_id
      WHERE organization_event.org_id = ?
      AND event_publish <= CURRENT_TIMESTAMP");

$stmt->bind_param("s",$_SESSION['org']['id']);
$stmt->execute();

$stmt->execute();
$rows = fetchArray($stmt);

$stmt->free_result();
$stmt->close();

echo json_encode($rows);
 ?>
