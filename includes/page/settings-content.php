<h3>User Information</h3>

<ul class='list-unstyled'>
  <li><strong>Email: </strong><?=$_SESSION['user']['email'];?></li>
  <li><strong>Name: </strong><?=$_SESSION['user']['fname']." ".$_SESSION['user']['lname'];?></li>
  <li><strong>Role: </strong><?=ucwords($_SESSION['user']['roleName']);?></li>
  <li><strong>Department: </strong><?=$_SESSION['user']['deptName'];?></li>
  <li><strong>Member Since: </strong><?=date("M j, Y", strtotime($_SESSION['user']['created']));?></li>
</ul>
<? if ( isAdmin() ){ ?>

<h3>Departments</h3>
  <ul id='dept-list'>
<? if ( $dept_rows == 0 ){ ?>

  <li><em>No departments have been added yet.</em></li>

<? } // end dept_rows check
else{ // run the departments list ?>


<?for($i = 0; $i < count($dept['id']); $i++) { ?>

  <li><?=ucwords($dept['name'][$i]);?></li>

<? } // end FOR loop ?>



<? } // end ELSE ?>

  </ul>

<? } // end user-role check ?>

<? if ( isAdmin() ){ ?>

<h3>Locations</h3>

<ul id='loc-list'>
<? if ( $loc_rows == 0 ){ ?>

  <li><em>No locations have been added yet.</em></li>

<? } // end dept_rows check
else{ // run the departments list ?>


<?for($i = 0; $i < count($location['id']); $i++) { ?>

  <li><?=ucwords($location['name'][$i]);?></li>

<? } // end FOR loop ?>



<? } // end ELSE ?>

  </ul>

<? } // end user-role check ?>
