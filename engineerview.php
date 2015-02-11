<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
	<?php
	// load functions
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
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
					<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/partial/reports/list_urgent_tickets.php'); ?>
					<p class="engineersubnav">
						<a href="#" onclick="update_div('#engineerscallview','reports/list_assigned_tickets.php');"><img src="/images/ICONS-yourcalls@2x.png" alt="your tickets" title="your tickets"  width="16" height="17" /> My Tickets</a>
						<a href="#" onclick="update_div('#engineerscallview','reports/list_open_tickets_for_a_helpdesk.php');"><img src="/images/ICONS-allcalls@2x.png" alt="your tickets" title="your tickets"  width="16" height="17" /> All Tickets</a>
						<a href="#" onclick="update_div('#engineerscallview','reports/list_engineer_reports.php');"><img src="/images/ICONS-workrate@2x.png" alt="your tickets" title="your tickets"  width="16" height="17" /> Reports</a>
					</p>
					<span id="engineerscallview"><?php include($_SERVER['DOCUMENT_ROOT'] . '/includes/partial/reports/list_assigned_tickets.php'); ?></span>
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