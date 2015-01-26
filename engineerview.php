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
		<?php include_once 'includes/header.php'; ?>
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