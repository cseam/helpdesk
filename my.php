<!DOCTYPE html>
<html lang="en">
	<?php
	include 'includes/functions.php';
	?>
	<head>
		<title><?=$codename;?> - Add</title>
		<link rel="shortcut icon" href="clcfavicon.ico" type="image/x-icon" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" /> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="robots" content="nofollow" />
		<link rel="stylesheet" type="text/css" href="css/reset.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
	</head>
	<body>
	<div class="section">
	<h2>My Calls</h2>	
	<p>calls for specific engineer, in this case engineerid:<?=$_COOKIE['engineerid'];?></p>
	<p>
	<?php 
	// select calls for current engineer set using cookie engineerid
	// run select query
	$result = mysqli_query($db, "SELECT * FROM calls WHERE assigned =" . $_COOKIE['engineerid']);
	// display results to page
	while($calls = mysqli_fetch_array($result))  {
	?>
		<?=$calls['callid'] ?> -
		<?=$calls['name'] ?> -
		<?=$calls['email'] ?> -
		<?=$calls['tel'] ?> -
		<?=substr($calls['details'], 0, 100) ?> -
		<?=$calls['assigned'] ?> -
		<?=$calls['opened'] ?> -
		<?=$calls['lastupdate'] ?> -
		<?=$calls['closed'] ?> -
		<?=$calls['status'] ?><br />
	<? } ?>
	</p>
	<ul>
		<li><a href="index.php"><?=$codename;?> Home</a></li>
	</ul>
	</div>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js" type="text/javascript"></script>	
	<script src="javascript/jquery.js" type="text/javascript"></script>
	</body>
</html>