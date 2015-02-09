<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<!DOCTYPE HTML>
<html lang="en"  id="digitalsign">
	<head>
		<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
		<!-- included local jquery as box doesnt have inet access -->
		<script src="/javascript/jquery-2.1.3.min.js" type="text/javascript"></script>
	</head>
	<body>
	<div class="section">
	<div id="branding">
	</div>
	<div id="leftpage">

		<div id="digitalsign-stats">
			<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/digitalsigns/includes/stats.php'; ?>
		</div>
		<script type="text/javascript">
			function update_stats() {
				$.ajax({
						type: 'GET',
						url: '/digitalsigns/includes/stats.php',
						data: $(this).serialize(),
						beforeSend: function() { $('#digitalsign-stats').html('<img src="/images/ICONS-spinny.gif" alt="loading" class="loading"/>'); },
						success: function(data) { $('#digitalsign-stats').html(data); },
						error: function() { $('#digitalsign-stats').html('error loading data, please wait.'); }
					});
				return false;
			};
			setInterval(update_stats, 120000);
		</script>

		<div id="topengineers">
			<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/digitalsigns/includes/topengineers.php'; ?>
		</div>
		<script type="text/javascript">
			function update_topengineers() {
				$.ajax({
						type: 'GET',
						url: '/digitalsigns/includes/topengineers.php',
						data: $(this).serialize(),
						beforeSend: function() { $('#topengineers').html('<img src="/images/ICONS-spinny.gif" alt="loading" class="loading"/>'); },
						success: function(data) { $('#topengineers').html(data); },
						error: function() { $('#topengineers').html('error loading data, please wait.'); }
					});
				return false;
			};
			setInterval(update_topengineers, 300000);
		</script>
		<div id="issues">
			<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/digitalsigns/includes/issues.php'; ?>
		</div>
		<script type="text/javascript">
			function update_issues() {
				$.ajax({
						type: 'GET',
						url: '/digitalsigns/includes/issues.php',
						data: $(this).serialize(),
						beforeSend: function() { $('#issues').html('<img src="/images/ICONS-spinny.gif" alt="loading" class="loading"/>'); },
						success: function(data) { $('#issues').html(data); },
						error: function() { $('#issues').html('error loading data, please wait.'); }
					});
				return false;
			};
			setInterval(update_issues, 600000);
		</script>

	</div>
	<div id="rightpage">
	<div id="call">
		<div id="ajax">
			<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/digitalsigns/includes/opencalls.php'; ?>
		</div>
		<script type="text/javascript">
			function update_calls() {
				$.ajax({
						type: 'GET',
						url: '/digitalsigns/includes/opencalls.php',
						data: $(this).serialize(),
						beforeSend: function() { $('#ajax').html('<img src="/images/ICONS-spinny.gif" alt="loading" class="loading"/>'); },
						success: function(data) { $('#ajax').html(data); },
						error: function() { $('#ajax').html('error loading data, please wait.'); }
					});
				return false;
			};
			setInterval(update_calls, 180000);
		</script>
	</div>
	</div>
	</div>
	</body>
</html>