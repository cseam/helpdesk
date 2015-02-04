<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
	<?php
	// load functions
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
	// check authentication
	if (empty($_SESSION['sAMAccountName'])) { prompt_auth($_SERVER['REQUEST_URI']); };
	?>
	<head>
		<?php include_once($_SERVER['DOCUMENT_ROOT'] .'/includes/header.php'); ?>
		<meta http-equiv="refresh" content="600" />
	</head>
	<body>
		<div class="section">
			<div id="branding">
				<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/nav.php'); ?>
			</div>
			<div id="leftpage">
				<div id="stats">
					<h3>Your Performance</h3>
						<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/engineergraph.php'); ?>
				</div>
				<div id="calllist">
					<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/engineerurgentcalls.php'); ?>
					<p class="engineersubnav">
						<a href="#" onclick="showassignedcalls()"><img src="/images/ICONS-yourcalls@2x.png" alt="your calls" title="your calls"  width="16" height="17" /> My Calls</a>
						<a href="#" onclick="showallcalls()"><img src="/images/ICONS-allcalls@2x.png" alt="your calls" title="your calls"  width="16" height="17" /> All Calls</a>
						<a href="#" onclick="showreports()"><img src="/images/ICONS-workrate@2x.png" alt="your calls" title="your calls"  width="16" height="17" /> Reports</a>
					</p>
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
						function showreports() {
						$.ajax(
						{
							type: 'GET',
							url: '/includes/engineerreports.php',
							data: $(this).serialize(),
							beforeSend: function() { $('#engineerscallview').html('<img src="/images/spinny.gif" alt="loading" class="loading"/>'); },
							success: function(data) { $('#engineerscallview').html(data); },
							error: function() { $('#engineerscallview').html('error loading data, please refresh.'); }
						});
						return false;
						};
					</script>
					<span id="engineerscallview"><?php include($_SERVER['DOCUMENT_ROOT'] . '/includes/engineerassignedtoyou.php'); ?></span>
				</div>
				</div>
			<div id="rightpage">
				<div id="call">
					<div id="ajax">
						<?php include($_SERVER['DOCUMENT_ROOT'] . '/includes/engineeryouroldestcall.php'); ?>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>