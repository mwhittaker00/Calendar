<h3><span class='glyphicon glyphicon-cog' aria-hidden='true'></span> Settings</h3>

      <h4>
        Update Information
      </h4>


        <form action="/process/updateprofile/" method="post" id="user-information">

          <div class='form-group'>
            <label for='first-name'>
              Name:
            </label>
            <div class='input-group'>
              <input type='text' class='form-control' id='first-name' name='fname' value="<?=$_SESSION['user']['fname'];?>" placeholder="First Name" maxlength="32"/>
            </div>
            <div class='input-group'>
              <input type='text' class='form-control' id='last-name' name='lname' value="<?=$_SESSION['user']['lname'];?>" placeholder="Last Name" maxlength="32"/>
            </div>
          </div>

          <br />

          <label for='user-avatar'>
            Upload Avatar:
          </label>
          <div class="avatarfile fileinput-new" data-provides="avatarfile">
            <div class="fileinput-preview thumbnail" data-trigger="avatarfile" style="width: 100px; height: 100px;"></div>

              <span class="btn btn-default btn-file">
                <span class="fileinput-new">Select image</span>
                <span class="fileinput-exists">Change</span>
                <input type="file" name="event-picture">
              </span>
              <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>

          </div>

          <br />
          <input type='submit' class='btn btn-default login-button' value='Submit'/>

        </form>


<? if ( isAdmin() ) { ?>

      <h4>
        Departments
      </h4>

        <form id='add-dept-form' action='/process/adddepartment/' method='post'>

          <label for='dept-name'>
            Department Name:*
          </label>
          <div class='input-group'>
            <input type='text' name='dept-name' id='dept-name' class='form-control' maxlength="128" required />
          </div>
          <br />
          <input type='submit' id='dept-submit' name='submit' class='btn btn-default login-button' value='Submit' />
          <div id='dept-message'></div>
          <br />
        </form>


        <h4>
          Add a Location
        </h4>

          <form id='add-location-form' action='/process/addlocation/' method='post'>

            <label for='dept-name'>
              Location Name:*
            </label>
            <div class='input-group'>
              <input type='text' name='local-name' id='local-name' class='form-control' maxlength="128" required />
            </div>
            <br />
            <input type='submit' id='dept-submit' name='submit' class='btn btn-default login-button' value='Submit' />
            <div id='loc-message'></div>
            <br />
          </form>

<? } // end ADMIN check ?>
