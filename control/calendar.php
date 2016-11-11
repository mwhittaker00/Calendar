<?php
$_PATH =  $_SERVER['DOCUMENT_ROOT'];
// re setting user role for testing
// SELECT roles for select box
//
$stmt = $db->prepare(
  "SELECT role_id, role_name FROM role");
$stmt->execute();

$stmt->bind_result($role_id, $role_name);
$roles = array();
while ($stmt->fetch()){
  $roles['id'][] = $role_id;
  $roles['name'][] = $role_name;
}

$stmt->close();

// SELECT users for this organization
// There will be some hierarchy to consider later:
// If the user is an admin or higher, select all users for this organization
// If the user is a moderator or lower, only select admins or higher, or people who are in the same department

// for now, let's just select everybody in the same organization

$stmt = $db->prepare("SELECT person.person_id, person_email, person_fname, person_lname, role_name, dept_name
          FROM person
          JOIN person_org
          ON person.person_id = person_org.person_id
          JOIN role
          ON role.role_id = person_org.role_id
          JOIN person_department
          ON person.person_id = person_department.person_id
          INNER JOIN organization_department
          ON person_department.dept_id = organization_department.dept_id
          WHERE person_org.org_id = ?
          ORDER BY role.role_id DESC");
$stmt->bind_param('s',$_SESSION['org']['id']);
$stmt->execute();
$stmt->bind_result($person_id,$person_email,$person_fname,$person_lname,$person_role,$dept_name);
$person = array();
while ($stmt->fetch()){
  $person['id'][] = $person_id;
  $person['email'][] = $person_email;
  $person['fname'][] = $person_fname;
  $person['lname'][] = $person_lname;
  $person['role'][] = $person_role;
  $person['dept'][] = $dept_name;

  if ( file_exists($_PATH.'/resources/images/uploads/avatar/'.$person_id.'.jpg') ){
    $person['image'][] = $person_id;
  } else{
    $person['image'][] = 'default';
  }
}
$stmt->close();

//
// SELECT a list of the organization's current departments for SETTINGS tab
//

$stmt = $db->prepare("SELECT dept_id, dept_name
                  FROM organization_department
                  WHERE org_id = ?
                  ORDER BY dept_name ASC");
$stmt->bind_param('s',$_SESSION['org']['id']);
$stmt->execute();
$stmt->bind_result($dept_id,$dept_name);
$stmt->store_result();
$dept_rows = $stmt->num_rows;
if ( $dept_rows > 0 ){
  $dept = array();
  while ($stmt->fetch()){
    $dept['id'][] = $dept_id;
    $dept['name'][] = $dept_name;
  }
}

$stmt->close();

//
// SELECT a list of the organization's current locations for SETTINGS tab
//

$stmt = $db->prepare("SELECT location_id, location_name
                  FROM location_organization
                  WHERE org_id = ?
                  ORDER BY location_name ASC");
$stmt->bind_param('s',$_SESSION['org']['id']);
$stmt->execute();
$stmt->bind_result($loc_id,$loc_name);
$stmt->store_result();
$loc_rows = $stmt->num_rows;
if ( $loc_rows > 0 ){
  $location = array();
  while ($stmt->fetch()){
    $location['id'][] = $loc_id;
    $location['name'][] = $loc_name;
  }
}

$stmt->close();
