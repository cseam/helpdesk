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
	<div id="branding"></div>
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
	</body>
</html>