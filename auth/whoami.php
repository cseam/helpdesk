<?php session_start();	
$sAMAcountName = $_SERVER['PHP_AUTH_USER'];
include_once '../includes/functions.php';
 
if (empty($sAMAcountName)) {
	echo "<p class='error'>Not Authenticated (Error)</p>";
} else {
	$result = mysqli_query($db, "SELECT * FROM engineers WHERE sAMAccountName='". $_SERVER['PHP_AUTH_USER'] ."'");
	while($engineers = mysqli_fetch_array($result))  {
		$_SESSION['sAMAccountName'] = $_SERVER['PHP_AUTH_USER'];
		$_SESSION['engineerLevel'] = $engineers['engineerLevel'];
		$_SESSION['engineerId'] = $engineers['idengineers'];
		$_SESSION['engineerHelpdesk'] = $engineers['helpdesk'];
	}
	die("<script>location.href = '".$_GET['return']."'</script>");
}
?>
