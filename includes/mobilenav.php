<div id="sidr">
<h3>Controls</h3>
	<a href="#" onclick="update_div('#ajax','/form/add_ticket.php');update_div('#stats','/user_welcome.php');update_div('#calllist','reports/list_your_tickets.php');$.sidr('close', 'sidr');">Add Ticket</a><br/>
<?php if ($_SESSION['engineerLevel'] === "1") { ?><a href="#" onclick="update_div('#ajax','reports/view_your_oldest_ticket.php');update_div('#stats','reports/graph_my_performance.php');update_div('#calllist','reports/list_engineers_tickets.php');$.sidr('close', 'sidr');">Engineer View</a><br/><?php }; ?>
<?php if ($_SESSION['engineerLevel'] === "2" or $_SESSION['superuser'] === "1") { ?><a href="#" onclick="update_div('#ajax','reports/manager_default_view.php');update_div('#stats','reports/graph_department_overview.php');update_div('#calllist','reports/list_manager_reports.php');$.sidr('close', 'sidr');">Manager View</a><br/><?php }; ?>
<?php if ($_SESSION['engineerLevel'] === "2" or $_SESSION['superuser'] === "1") { ?><a href="#" onclick="update_div('#ajax','reports/reports_default_view.php');update_div('#stats','reports/graph_reports_overview.php');update_div('#calllist','reports/list_reports_view_reports.php');$.sidr('close', 'sidr');">Reports View</a><br/><?php }; ?>
<a href="/login/logout.php" class="logout">Log out</a><br/>
<br/>	
<?php if ($_SESSION['engineerLevel'] === "1") { ?>
<h3>My Tickets</h3>
	<a href="#" onclick="update_div('#calllist','reports/list_engineers_tickets.php');update_div('#engineerscallview','reports/list_assigned_tickets.php');$.sidr('close', 'sidr');"><img src="/public/images/ICONS-yourcalls@2x.png" alt="your tickets" title="your tickets"  width="16" height="17" /> Assigned Tickets</a><br/>
	<a href="#" onclick="update_div('#calllist','reports/list_engineers_tickets.php');update_div('#engineerscallview','reports/list_open_tickets_for_a_helpdesk.php');$.sidr('close', 'sidr');"><img src="/public/images/ICONS-allcalls@2x.png" alt="your tickets" title="your tickets"  width="16" height="17" /> Departments Tickets</a><br/>
	<a href="#" onclick="update_div('#engineerscallview','reports/list_my_performance_objectives.php');update_div('#engineerscallview','reports/list_engineer_reports.php');$.sidr('close', 'sidr');"><img src="/public/images/ICONS-allcalls@2x.png" alt="Performance Objectives" title="Performance Objectives"  width="16" height="17" />Performance Objectives</a><br/>
	<a href="#" onclick="update_div('#calllist','reports/list_engineers_tickets.php');update_div('#engineerscallview','reports/list_engineer_reports.php');$.sidr('close', 'sidr');"><img src="/public/images/ICONS-workrate@2x.png" alt="your tickets" title="your tickets"  width="16" height="17" /> Reports</a><br/>
<?php }; ?>
</div>