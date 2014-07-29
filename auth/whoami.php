<?php
//set cookie to username so engineer forms know who you are 
// thinking of using apache ntml mod to auth set session var then redirect for dev going to set cookie i can check
// for testing this is a static engineer id but would lookup in db from ntml
include '../includes/functions.php';	

session_start();
$sAMAcountName = $_SERVER['PHP_AUTH_USER'];
 
if ($sAMAcountName == null) {
	echo "<h1>Authentication Error.</h1>";
	echo "<p>Setting session data manually during testing as ntml is off on MAMP</p>";
	echo "<p><a href='http://localhost:8888/helpdesk/'>Home</a></p>";
	$_SESSION['sAMAccountName'] = 'dripsh';
	$_SESSION['engineerLevel'] = '1';
} else {
	$_SESSION['sAMAccountName'] = $_SERVER['PHP_AUTH_USER'];
	$result = mysqli_query($db, "SELECT * FROM engineers WHERE sAMAccountName='". $_SERVER['PHP_AUTH_USER'] ."'");
	while($engineers = mysqli_fetch_array($result))  {
		$_SESSION['engineerLevel'] = $engineers['engineerLevel']);
	}
	echo "<h1>Authentication Success</h1>";
	echo "Session variables set";
	echo "<p><a href='http://localhost:8888/helpdesk/'>Home</a></p>";
}

?>