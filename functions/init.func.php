<?php
$_PATH =  $_SERVER['DOCUMENT_ROOT'];
session_start();

require_once($_PATH.'/includes/_connect.inc.php');

function parseUri(){
	$uri = $_SERVER['REQUEST_URI'];
	$parts = explode('/',$uri);
	return $parts;
}

require_once($_PATH.'/functions/getView.func.php');

require_once($_PATH.'/functions/processForm.func.php');

function isLoggedIn(){
	// Simple function to make sure user is logged in
	if ( isset($_SESSION['user']['login']) && $_SESSION['user']['login'] === 1 ){
		return true;
	}
	else{
		return false;
	}
}

function isVerified(){
	// make sure user has verified their email address
	if ( isset($_SESSION['user']['verified']) && $_SESSION['user']['verified'] === 1){
		return true;
	}
	else{
		return false;
	}
}

function isMod(){
	// check if user is a mod for the organization they're viewing
	if ( isset($_SESSION['user']['roleID']) && $_SESSION['user']['roleID'] >= 2 ){
		return true;
	}
	else{
		return false;
	}
}

function isAdmin(){
	if ( isset($_SESSION['user']['roleID']) && $_SESSION['user']['roleID'] >= 3 ){
		return true;
	} else{
		return false;
	}
}

function isAccountContact(){
	if ( isset($_SESSION['user']['roleID']) && $_SESSION['user']['roleID'] >= 4 ){
		return true;
	} else{
		return false;
	}
}

function isSameRegion($region){
	// check if the user is in the same region as the player/region being viewed
	if ( isset($_SESSION['region']) && $_SESSION['region'] == $region ){
		return true;
	}
	else{
		return false;
	}
}

function logout(){
	session_start();
	session_unset();
	setcookie('user', null, -1, '/');
	header('Location:/page/home/');
}



function simFail(){
	header('location:/page/fail/');
}

function fetchArray($result)
{
    $array = array();

    if($result instanceof mysqli_stmt)
    {
        $result->store_result();

        $variables = array();
        $data = array();
        $meta = $result->result_metadata();

        while($field = $meta->fetch_field())
            $variables[] = &$data[$field->name]; // pass by reference

        call_user_func_array(array($result, 'bind_result'), $variables);

        $i=0;
        while($result->fetch())
        {
            $array[$i] = array();
            foreach($data as $k=>$v)
                $array[$i][$k] = $v;
            $i++;

            // don't know why, but when I tried $array[] = $data, I got the same one result in all rows
        }
    }
    elseif($result instanceof mysqli_result)
    {
        while($row = $result->fetch_assoc())
            $array[] = $row;
    }

    return $array;
}

?>
