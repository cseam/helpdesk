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
			<li>Call ID: #<?=$calls['callid'];?></li>
			<li>Primary Contact Name: <?=$calls['name'];?></li>
			<li>Primary Email: <?=$calls['email'];?></li>
			<li>Primary Telephone: <?=$calls['tel'];?></li>
			<li>Engineer Assigned: <?=$calls['assigned'];?> (<?=$calls['engineerName'];?> - <?=$calls['engineerEmail'];?>)</li>
			<li>Call Opened: <?=date("d/m/y h:s", strtotime($calls['opened']));?></li>
			<li>Call Last Update: <?=date("d/m/y h:s", strtotime($calls['lastupdate']));?></li>
			<li>Call Closed: <?=date("d/m/y h:s", strtotime($calls['closed']));?></li>
			<li>Status: <?=$calls['status'];?> (<?=$calls['statusCode'];?>)</li>
			<li>Urgency: <?=$calls['urgency'];?></li>
			<li>Location: <?=$calls['location'];?></li>
			<li>Room: <?=$calls['room'];?></li>
			<li>Category: <?=$calls['category'];?></li>
			<li>Call Details: <?=$calls['details'];?></li>
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