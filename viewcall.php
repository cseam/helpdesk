<!DOCTYPE html>
<html lang="en">
	<?php
	// load functions
	include 'includes/functions.php';
	?>
	<head>
		<title><?=$codename;?> - All Calls</title>
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
	<?=environ();?>
	</div>
	
	<h2>View Call with ID: <?=check_input($_GET['id']);?> </h2>
	<p>
	<?php 
	// select calls for ID
	// run select query
	$sqlstr = "SELECT * FROM calls ";
	$sqlstr .= "INNER JOIN engineers ON calls.assigned=engineers.idengineers ";
	$sqlstr .= "INNER JOIN status ON calls.status=status.id ";
	$sqlstr .= "WHERE callid =" . check_input($_GET['id']);
	$result = mysqli_query($db, $sqlstr);
	
	// display results to page
	while($calls = mysqli_fetch_array($result))  {
	
	?>
		<ul>
			<li>ID: #<?=$calls['callid'];?></li>
			<li>NAME:<?=$calls['name'];?></li>
			<li>EMAIL:<?=$calls['email'];?></li>
			<li>TEL:<?=$calls['tel'];?></li>
			<li>ASSIGNED:<?=$calls['assigned'];?> (<?=$calls['engineerName'];?> - <?=$calls['engineerEmail'];?>)</li>
			<li>OPENED:<?=$calls['opened'];?></li>
			<li>LAST UPDATE:<?=$calls['lastupdate'];?></li>
			<li>CLOSED:<?=$calls['closed'];?></li>
			<li>STATUS:<?=$calls['status'];?> (<?=$calls['statusCode'];?>)</li>
			<li>URGENCY:<?=$calls['urgency'];?></li>
			<li>LOCATION:<?=$calls['location'];?></li>
			<li>ROOM:<?=$calls['room'];?></li>
			<li>CATEGORY:<?=$calls['category'];?></li>
			<li>DETAILS:<?=$calls['details'];?></li>
		</ul>
	<?
	
		}
	?>
	</p>
	
	
	<ul>
		<li><a href="index.php"><?=$codename;?> Home</a></li>
	</ul>
	</div>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js" type="text/javascript"></script>	
	<script src="javascript/jquery.js" type="text/javascript"></script>
	</body>
</html>