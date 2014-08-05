<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
	<?php
	// load functions
	include 'includes/functions.php';
	?>
	<head>
		<title><?=$codename;?></title>
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
	<h2>Codename: <?=$codename;?></h2>
	<p><?=$codename;?> webapp forms & wireframes, variables displayed for debugging.</p>
	
	<h3>Prototype</h3>
	<ul>
		<li><a href="add.php">Add Call</a></li>
		<li><a href="engineerview.php">Engineer View</a></li>
	</ul>
	<h3>Authentication</h3>
	<ul>
		<li><a href="auth/whoami.php">Engineer authentication</a></li>	
	</ul>
	<h3>Dev Pages</h3>
	<ul>
		<li><a href="all.php">All calls</a></li>
		<li><a href="open.php">Open calls</a></li>
		<li><a href="my.php">All my calls</a></li>
		<li><a href="myopen.php">My open calls</a></li>
		<li><a href="engineers.php">Engineers</a></li>
		<li><a href="assigntests.php">Assign function tests</a></li>
		<li><a href="graphs.php">Graph/stats tests</a></li>
	</ul>
	
	
	</div>

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js" type="text/javascript"></script>	
	<script src="javascript/jquery.js" type="text/javascript"></script>
	</body>
</html>