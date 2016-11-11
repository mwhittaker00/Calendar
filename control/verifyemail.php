<?php
$_PATH =  $_SERVER['DOCUMENT_ROOT'];
if ( isLoggedIn() || isVerified()){
  header('location:/page/home/');
}

if ( (isset($_GET['key']) && isset($_GET['use']))
      || ( isset($_SESSION['registered']) && $_SESSION['registered'] === 1)
      ){

    require_once($_PATH."/process/verifyemail.php");


}else{
  header('location:/page/home/');
}
