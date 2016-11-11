<div id='wrapper'><!-- start wrapper for page content -->

<nav class='navbar-fixed-top main-banner banner'>
 <div class='nav-content'>
  <div class="navbar-header">
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
  </div>

  <div class='branding'>
    <a href='/page/home/'>
      <img src='/resources/images/calendar.png' alt='Calendar Logo' class='logo' /> <h2>COOL<strong>name</strong></h2>
    </a>
  </div>

  <div class='banner-nav collapse navbar-collapse' id='navbar-collapse-1'>
    <ul class='nav navbar-nav'>

<?php
// If the user IS logged in, show these links in the nav bar:
if ( isloggedIn()){
 ?>
      <li><a href='/page/home/'><img src='/resources/images/uploads/avatar/<?=$_SESSION['user']['avatar'];?>.jpg' class='avatar avatar-small' /> <?=$displayName;?></a></li>
      <li><a href='/process/logout/'><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
<?php
} // end IF isLoggedIn
// if they are NOT logged in, show these links in the nav bar:
else{
 ?>
      <li><a href='/page/login/'><span class="glyphicon glyphicon-log-in"></span> Log In</a></li>
 <?php
 } // end ELSE
  ?>
    </ul>
  </div>
 </div>
</nav>

<?php
// Displays an error message if one has been set in the session
if ( isset($_SESSION['error']) ){ ?>
  <div class="alert alert-danger" role="alert">
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  <span class="sr-only">Error:</span>
  <br /><Br /><?=$_SESSION['error'];?>
</div>
<?php }

// Displays a success message if one has been set in the session
if ( isset($_SESSION['success']) ){ ?>
  <div class="alert alert-success" role="alert">
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  <span class="sr-only">Success:</span>
  <br /><Br /><?=$_SESSION['success'];?>
</div>
<?php }
unset($_SESSION['success']);
?>
