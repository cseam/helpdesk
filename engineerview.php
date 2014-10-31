<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
	<?php
	// load functions
	include_once 'includes/functions.php';
	// check authentication 
	if (empty($_SESSION['sAMAccountName'])) { prompt_auth($_SERVER['REQUEST_URI']); };
	?>
	<head>
		<title><?=$codename;?> - Engineer View</title>
		<link rel="shortcut icon" href="clcfavicon.ico" type="image/x-icon" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" /> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta http-equiv="refresh" content="300" />
		<meta name="robots" content="nofollow" />
		<link rel="stylesheet" type="text/css" href="css/reset.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js" type="text/javascript"></script>	
		<script src="javascript/jquery.js" type="text/javascript"></script>
	</head>
	<body>
	<div class="section">
	<div id="branding">
		<?php include 'includes/nav.php'; ?>
	</div>
	
	<div id="leftpage">
	<div id="stats">
		<h3>Your Performance</h3>
		<?php include 'includes/engineergraph.php'; ?>
	</div>
	<div id="calllist">
		<?php include 'includes/engineerurgentcalls.php'; ?>
		<h3>Calls Assigned to you</h3>
		<?php include 'includes/engineerassignedtoyou.php'; ?>
	</div>
	</div>
	<div id="rightpage">
	<div id="call">
		<div id="ajax">
			<?php include 'includes/engineeryouroldestcall.php'; ?>
		</div>
	</div>
	</div>
	</div>
	</body>
</html>