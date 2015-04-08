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
		<meta http-equiv="refresh" content="900">
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
	</body>
</html>