<?php include 'includes/whoami.php'; ?>
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
	<ul>
		<li><a href="add.php">Add Call Form</a></li>
		<li><a href="my.php">My Calls</a></li>
		<li><a href="all.php">All Calls</a></li>
		<li><a href="engineers.php">Engineers</a></li>
		<li><a href="next.php">Next Function</a></li>
		<li><a href="assign.php">Assign Function</a></li>
	</ul>
	
	</div>

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js" type="text/javascript"></script>	
	<script src="javascript/jquery.js" type="text/javascript"></script>
	</body>
</html>