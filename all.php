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
	
	<h2>* From Calls Table</h2>
	<p>
	<table>
	<thead>
		<tr>
			<th>Call ID</th>
			<th>Opened</th>
			<th>Details</th>
		</tr>
	</thead>
	<tbody>
	<?php 
		//list current engineers
		//run select query
		$result = mysqli_query($db, "SELECT * FROM calls");
	
		while($calls = mysqli_fetch_array($result))  {
			$outputstr = "<tr>";
			$outputstr .= "<td>#" . $calls['callid'] . "</td>";
			$outputstr .= "<td>" . date("d/m/y h:s", strtotime($calls['opened'])) . "</td>";
			$outputstr .= "<td><a href='viewcall.php?id=" . $calls['callid'] . "'>" . substr($calls['details'], 0, 100) . "</a></td>";
			$outputstr .= "</tr>";
			echo $outputstr;
		}
	?>
	</tbody>
	</table>
	</p>
	
	
	<ul>
		<li><a href="index.php"><?=$codename;?> Home</a></li>
	</ul>
	</div>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js" type="text/javascript"></script>	
	<script src="javascript/jquery.js" type="text/javascript"></script>
	</body>
</html>