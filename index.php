<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
	<?php
	// load functions
	include_once 'includes/functions.php';
	// check authentication 
	if (empty($_SESSION['sAMAccountName'])) { prompt_auth($_SERVER['REQUEST_URI']); } else { die("<script>location.href = '/add.php'</script>");};

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
		<li><a href="retrospect.php">Retrospect Call</a></li>
		<li><a href="engineerview.php">Engineer View</a></li>
		<li><a href="managerview.php">Manager View</a></li>
	</ul>
	<h3>Development Pages</h3>
	<ul>
		<li><a href="auth/whoami.php">Manual authentication</a></li>	
		<li><a href="engineers.php">Create Engineers</a></li>
		<li><a href="functiontest.php">Function Test (auto assign)</a></li>
	</ul>
	
	
	</div>

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js" type="text/javascript"></script>	
	<script src="javascript/jquery.js" type="text/javascript"></script>
	</body>
</html>