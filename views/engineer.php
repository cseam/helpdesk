<?php
	session_start();
	// load functions
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
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
			</div>
			<div id="leftpage">
				<div id="stats">
					<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/partial/reports/graph_my_performance.php'); ?>
				</div>
				<div id="calllist">
					<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/partial/reports/list_engineers_tickets.php'); ?>
				</div>
				</div>
			<div id="rightpage">
				<div id="call">
					<div id="ajax">
						<?php include($_SERVER['DOCUMENT_ROOT'] . '/includes/partial/reports/view_your_oldest_ticket.php'); ?>
					</div>
				</div>
			</div>
		</div>


	<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/mobilenav.php'); ?>
	<script type="text/javascript">
	$(function() {
		// Wait for DOM ready state
			// Reload stats and lockers
			setInterval(function() {
				// Do something after 10 min 300000ms
				update_div('#stats','reports/graph_my_performance.php');
				update_div('#calllist','reports/list_engineers_tickets.php')
			}, 600000);
			
			// Bind sidr to menu
			$('#mobile-menu').sidr({
				name: 'sidr',
				side: 'right'	
			});
		// End DOM ready check
	});
	</script>
	<a href="/views/changelog.php" target="_blank" class="changelog">changelog</a>
	</body>
</html>