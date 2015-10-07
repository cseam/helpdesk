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
					<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/partial/user_welcome.php'); ?>
				</div>
				<div id="calllist">
					<?php include($_SERVER['DOCUMENT_ROOT'] . '/includes/partial/reports/list_your_tickets.php'); ?>
				</div>
				</div>
			<div id="rightpage">
				<div id="call">
					<div id="ajax">
						<?php include($_SERVER['DOCUMENT_ROOT'] . '/includes/partial/form/add_ticket.php'); ?>
					</div>
				</div>
			</div>
		</div>
		
	<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/mobilenav.php'); ?>
	<script type="text/javascript">
	$(function() {
		// Wait for DOM ready state
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