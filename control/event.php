<?php
$_PATH =  $_SERVER['DOCUMENT_ROOT'];
// re setting user role for testing
$_SESSION['user']['roleID'] = 1;
// SELECT roles for select box
//

$event_id = $_GET['event'];

$stmt = $db->prepare("SELECT event.event_id, event_name, event_desc, event_created,
		event_publish, event_approved, event_modified, event_all_day,
        event_start, event_end, event_image, organization_department.dept_id,
        dept_name, location_organization.location_id, location_name, org_name, org_url
       FROM event
       JOIN organization_event
       ON organization_event.event_id = event.event_id
       JOIN organization
       ON organization_event.org_id = organization.org_id
       JOIN location_event
       ON event.event_id = location_event.event_id
       JOIN location_organization
       ON location_organization.org_id = organization.org_id
       JOIN organization_department
       ON organization_department.org_id = organization.org_id
       WHERE event.event_id = ?
       LIMIT 1");
$stmt->bind_param('s',$event_id);
$stmt->execute();
$stmt->bind_result($event_id, $event_name, $event_desc, $event_created,
                    $event_publish, $event_approved, $event_modified,
                    $event_all_day, $event_start, $event_end, $event_image,
                    $dept_id, $dept_name, $location_id, $location_name,
                    $org_name, $org_url);
$stmt->fetch();
$stmt->close();

if ( $event_end == '0000-00-00 00:00:00' ){
  $event_end = false;
}

$start_day = date('F j, Y', strtotime($event_start));
$start_time = date('g:i A', strtotime($event_start));
if ( $event_end ){
  $end_day = date('F j, Y', strtotime($event_end));
  $end_time = date('g:i A', strtotime($event_end));
}

$event_day;
if ( $event_all_day == 1 ){
  $start_time = "All day event";
  $start_time = '';
}

$event_day = $start_day;
if ( $event_end && $start_day != $end_day ){
    $event_day = $start_day." - ".$end_day;
}
