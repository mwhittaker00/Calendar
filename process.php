<?php
$_PATH =  $_SERVER['DOCUMENT_ROOT'];

require_once($_PATH.'/functions/init.func.php');

if ( isset($_GET['method']) ){
		if ( $_GET['method'] == 'logout' ){
			logout();
		}
		$script = $_GET['method'];
		processForm($_PATH,$script,$db);
}


else{
	simFail();
}

?>
