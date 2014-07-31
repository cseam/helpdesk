<?php
//set cookie to username so engineer forms know who you are 
// thinking of using apache ntml mod to auth set session var then redirect for dev going to set cookie i can check
// for testing this is a static engineer id but would lookup in db from ntml
include '../includes/functions.php';	

session_start();
$sAMAcountName = $_SERVER['PHP_AUTH_USER'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
		<title><?=$codename;?> - Assign Function test Engineer</title>
		<link rel="shortcut icon" href="clcfavicon.ico" type="image/x-icon" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" /> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="robots" content="nofollow" />
		<link rel="stylesheet" type="text/css" href="/css/reset.css" />
		<link rel="stylesheet" type="text/css" href="/css/style.css" />
	</head>
	<body>
	<div class="section">
	

<?php
 
if ($sAMAcountName == null) {
	echo "<h2>Authentication Error.</h2>";
} else {
	$result = mysqli_query($db, "SELECT * FROM engineers WHERE sAMAccountName='". $_SERVER['PHP_AUTH_USER'] ."'");
	while($engineers = mysqli_fetch_array($result))  {
		$_SESSION['sAMAccountName'] = $_SERVER['PHP_AUTH_USER'];
		$_SESSION['engineerLevel'] = $engineers['engineerLevel'];
		$_SESSION['engineerId'] = $engineers['idengineers'];
	}
	echo "<h2>Authentication Success</h2>";
	echo "<p>Session variables set</p>";
}

?>

<ul>
		<li><a href="/"><?=$codename;?> Home</a></li>
	</ul>
	
	</div>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js" type="text/javascript"></script>	
	<script src="javascript/jquery.js" type="text/javascript"></script>
	</body>
</html>
