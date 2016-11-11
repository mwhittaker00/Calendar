<?php

if ( isLoggedIn() ){
  header("Location:/page/calendar/");
}
else{
  header("Location:/page/login/");
}
