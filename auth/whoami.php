<?php
//set cookie to username so engineer forms know who you are 
// thinking of using apache ntml mod to auth set session var then redirect for dev going to set cookie i can check
// for testing this is a static engineer id but would lookup in db from ntml
	
session_start();
 
if ($sAMAcountName == null) {
	$_SESSION['sAMAccountName']='noNTLM';
	echo "Setting session sAMAccountName to '" . $_SESSION['sAMAccountName'] . "' as ntml isnt working. (for testing)";
} else {
	$_SESSION['sAMAccountName']=$_SERVER['PHP_AUTH_USER'];
	echo "Setting session sAMAccountName to " . $_SERVER['PHP_AUTH_USER'];
}

?>