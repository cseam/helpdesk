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
		<h3 id="hAssignedtoyou">Calls Assigned - <a href="#" onclick="showassignedcalls()">you</a> / <a href="#" onclick="showallcalls()">all</a></h3>
			<script type="text/javascript">
				function showallcalls() {
					$.ajax(
						{
						type: 'GET',
						url: '/includes/engineerviewallcalls.php',
						data: $(this).serialize(),
						beforeSend: function() { $('#engineerscallview').html('<img src="/images/spinny.gif" alt="loading" class="loading"/>'); },
						success: function(data) { $('#engineerscallview').html(data); },
						error: function() { $('#engineerscallview').html('error loading data, please refresh.'); }
					});
				return false;
				};
				function showassignedcalls() {
					$.ajax(
						{
						type: 'GET',
						url: '/includes/engineerassignedtoyou.php',
						data: $(this).serialize(),
						beforeSend: function() { $('#engineerscallview').html('<img src="/images/spinny.gif" alt="loading" class="loading"/>'); },
						success: function(data) { $('#engineerscallview').html(data); },
						error: function() { $('#engineerscallview').html('error loading data, please refresh.'); }
					});
				return false;
				};
			</script>
			<span id="engineerscallview"><?php include 'includes/engineerassignedtoyou.php'; ?></span>
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