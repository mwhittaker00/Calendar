<h3><span class='glyphicon glyphicon-user' aria-hidden='true'></span> Users</h3>

<h4>Add a user</h4>

<form id='add-user-form' action='/process/adduser/' method='post'>

  <label for='add-user-email'>
    Email Address:*
  </label>
  <div class='input-group'>
    <input type='email' id='add-user-email' class='form-control' maxlength="128" required />
  </div>

  <label for='add-user-name'>
    Name:
  </label>
  <div class='input-group'>
    <input type='text' class='form-control' id='add-user-fname' name='fname' placeholder="First Name" maxlength="32"/>
  </div>
  <div class='input-group'>
    <input type='text' class='form-control' id='add-user-lname' name='lname' placeholder="Last Name" maxlength="32"/>
  </div>

  <label for='add-user-department'>
    Department:
  </label>
  <div class='input-group'>

        <select class='form-control' id='add-user-department' name='user-department'>

<? if ( $dept_rows == 0 ){ ?>

          <option></option>

<? } // end dept_rows check
else{ // run the departments list ?>

<?for($i = 0; $i < count($dept['id']); $i++) { ?>

          <option value="<?=$dept['id'][$i];?>"><?=$dept['name'][$i];?></option>

<? } // end FOR loop
} // end ELSE ?>

        </select>
      </div>

  <label for='add-user-role'>
    Role:*
  </label>
  <div class='input-group'>
    <select class='form-control' name='user-role' id='add-user-role'>

<?for($i = 0; $i < count($roles['id']); $i++) { ?>

    <option value='<?=$roles['id'][$i];?>'><?=ucfirst($roles['name'][$i]);?></option>

<? } ?>
    </select>

  </div>
  <br />
  <input type='submit' id='add-user-submit' class='btn btn-default login-button' value='Submit' />
</form>
