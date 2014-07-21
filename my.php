<!DOCTYPE html>
<html lang="en">
	<?php
	// load functions
	include 'includes/functions.php';
	?>
	<head>
		<title><?=$codename?> - Add</title>
		<link rel="shortcut icon" href="clcfavicon.ico" type="image/x-icon" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" /> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="robots" content="nofollow" />
		<link rel="stylesheet" type="text/css" href="css/reset.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
	</head>
	<body>
	<div class="section">
	
	<div class="enviro">
	<?php
	// check environment
	echo environ();
	?>
	</div>
	<h2>My Calls</h2>
	
	<p>calls for specific engineer, in this case engineerid:<?php echo $_COOKIE['engineerid']?></p>
	<p>
	<?php 
	// select calls for current engineer set using cookie engineerid
	// run select query
	$result = mysqli_query($db, "SELECT * FROM calls WHERE assigned =" . $_COOKIE['engineerid']);
	// display results to page
	while($calls = mysqli_fetch_array($result))  {
		
			$outputstr = $calls['callid'] . " - ";
			$outputstr .= $calls['name'] . " - ";
			$outputstr .= $calls['email'] . " - ";
			$outputstr .= $calls['title'] . " - ";
			$outputstr .= $calls['details'] . " - ";
			$outputstr .= $calls['assigned'] . " - ";
			$outputstr .= $calls['opened'] . " - ";
			$outputstr .= $calls['lastupdate'] . " - ";
			$outputstr .= $calls['closed'] . " - ";
			$outputstr .= $calls['status'] . "<br/>";
			echo $outputstr;
		}
	?>
	</p>
	<ul>
		<li><a href="index.php"><?=$codename?> Home</a></li>
	</ul>
	
	</div>

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js" type="text/javascript"></script>	
	<script src="javascript/jquery.js" type="text/javascript"></script>
	</body>
</html>