<?php
	session_start();
	// load functions
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
	if ($_SESSION['superuser'] !== "1" and $_SESSION['engineerLevel'] !== '2') { die("<script>location.href = '/'</script>"); };
?>
<!DOCTYPE html>
<html lang="en">
	<?php
	// check authentication
	if (empty($_SESSION['sAMAccountName'])) { prompt_auth($_SERVER['REQUEST_URI']); };
	?>
	<head>
		<?php include_once($_SERVER['DOCUMENT_ROOT'] .'/includes/header.php'); ?>
	</head>
	<body>
		<div class="section">
			<div id="branding">
				<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/nav.php'); ?>
				<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/mobilenav.php'); ?>
			</div>
			<div id="leftpage">
				<div id="stats">
					<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/partial/reports/graph_reports_overview.php'); ?>
				</div>
			<div id="calllist">
				<div id="ajaxforms">
					<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/partial/reports/list_reports_view_reports.php'); ?>
				</div>
			</div>
		</div>
	<div id="rightpage">
		<div id="addcall">
			<div id="ajax">
				<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/partial/reports/reports_default_view.php'); ?>
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
				update_div('#stats','reports/graph_reports_overview.php')
			}, 300000);
			
			// Bind sidr to menu
			$('#mobile-menu').sidr({
				name: 'sidr',
				side: 'right'	
			});
		// End DOM ready check
	});
</script>
</body>
</html>