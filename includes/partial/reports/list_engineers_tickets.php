<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/partial/reports/list_urgent_tickets.php'); ?>
<p class="engineersubnav">
	<a href="#" onclick="update_div('#engineerscallview','reports/list_assigned_tickets.php');"><img src="/public/images/ICONS-yourcalls@2x.png" alt="your tickets" title="your tickets"  width="16" height="17" /> My Tickets</a>
	<a href="#" onclick="update_div('#engineerscallview','reports/list_open_tickets_for_a_helpdesk.php');"><img src="/public/images/ICONS-allcalls@2x.png" alt="your tickets" title="your tickets"  width="16" height="17" /> Departments Tickets</a>
	<a href="#" onclick="update_div('#engineerscallview','reports/list_engineer_reports.php');"><img src="/public/images/ICONS-workrate@2x.png" alt="your tickets" title="your tickets"  width="16" height="17" /> Reports</a>
</p>
<span id="engineerscallview"><?php include($_SERVER['DOCUMENT_ROOT'] . '/includes/partial/reports/list_assigned_tickets.php'); ?></span>
