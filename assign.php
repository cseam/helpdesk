<!DOCTYPE html>
<html lang="en">
	<?php
	// load functions
	include 'includes/functions.php';
	?>
	<head>
		<title><?=$codename?> - Assigned</title>
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
	<h2>Update Engineer Assigned</h2>
	
	<p>function calculates and returns the next engineer looking at the assign engineers table.</p>
	
	<?php
	// check environment
	echo next_engineer();
	?>
	
	<ul>
		<li><a href="index.php"><?=$codename?> Home</a></li>
	</ul>
	
	</div>

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js" type="text/javascript"></script>	
	<script src="javascript/jquery.js" type="text/javascript"></script>
	</body>
</html>