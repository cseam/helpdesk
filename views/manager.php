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
			</div>
			<div id="leftpage">
				<div id="stats">
					<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/partial/reports/graph_department_overview.php'); ?>
				</div>
			<div id="calllist">
				<div id="ajaxforms">
					<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/partial/reports/list_manager_reports.php'); ?>
				</div>
			</div>
		</div>
	<div id="rightpage">
		<div id="addcall">
			<div id="ajax">
				<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/partial/reports/list_open_tickets.php'); ?>
			</div>
		</div>
	</div>
</div>
</body>
</html>