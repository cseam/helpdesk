<?php
session_start();
include_once '../includes/functions.php';	
$sAMAcountName = $_SERVER['PHP_AUTH_USER'];
 
if (empty($sAMAcountName)) {
	echo "<p class='error'>Not Authenticated (Error) please <a href='/auth/whoami.php'>authenticate</a>.</p>";
} else {
	$result = mysqli_query($db, "SELECT * FROM engineers WHERE sAMAccountName='". $_SERVER['PHP_AUTH_USER'] ."'");
	while($engineers = mysqli_fetch_array($result))  {
		$_SESSION['sAMAccountName'] = $_SERVER['PHP_AUTH_USER'];
		$_SESSION['engineerLevel'] = $engineers['engineerLevel'];
		$_SESSION['engineerId'] = $engineers['idengineers'];
	}
}

?>
