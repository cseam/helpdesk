<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
	<?php
	// load functions
	include 'includes/functions.php';
	?>
	<head>
		<title><?=$codename;?> - Engineer View</title>
		<link rel="shortcut icon" href="clcfavicon.ico" type="image/x-icon" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" /> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="robots" content="nofollow" />
		<link rel="stylesheet" type="text/css" href="css/reset.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
	</head>
	<body>
	<div class="section">
	<div id="branding">
		<a href="add.php">Add Call</a><br/>
		<a href="index.php"><?=$codename;?> Home</a>
	</div>
	
	<div id="leftpage">
	<div id="stats">
		<h3>Performance</h3>
		<?php include 'includes/engineergraph.php'; ?>
	</div>
	<div id="calllist">
		<?php include 'includes/engineerurgentcalls.php'; ?>
		<h3>Assigned to you (<?=$_SESSION['sAMAccountName']?>)</h3>
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
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js" type="text/javascript"></script>	
	<script src="javascript/jquery.js" type="text/javascript"></script>
	</body>
</html>