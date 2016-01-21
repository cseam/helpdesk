<?php
	session_start();

	if (empty($_SESSION['sAMAccountName'])) { $_SESSION['sAMAccountName'] = 'DigitalSign'; };

	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<!DOCTYPE HTML>
<html lang="en" id="digitalsign">
	<head>
		<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
	</head>
	<body>
	<div class="section">
	<div id="leftpage">
		<div id="digitalsign-stats">
			<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/partial/reports/view_sign_stats.php'; ?>
		</div>

	</div>
	<div id="rightpage">
		<div id="call">
			<div id="ajax">
				<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/partial/reports/view_lockers.php'; ?>
			</div>
		</div>
	</div>
	</div>

	<script type="text/javascript">
	$(function() {
		// Wait for DOM ready state
			// Reload stats and lockers
			setInterval(function() {
				// Do something after 5 min 300000ms
				update_div('#digitalsign-stats','reports/view_sign_stats.php');
				update_div('#ajax','reports/view_lockers.php')
			}, 300000);
		// End DOM ready check
	});
	</script>



	</body>
</html>