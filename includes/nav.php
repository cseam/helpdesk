<a href="#" onclick="update_div('#ajax','/form/add_ticket.php');update_div('#stats','/user_welcome.php');update_div('#calllist','/reports/list_your_tickets.php');">Add Ticket</a><br/>
<?php if ($_SESSION['engineerLevel'] === "1") { ?><a href="#" onclick="update_div('#ajax','/reports/view_your_oldest_ticket.php');update_div('#stats','/reports/graph_my_performance.php');update_div('#calllist','/reports/list_engineers_tickets.php');">Engineer View</a><br/><?php }; ?>
<?php if ($_SESSION['engineerLevel'] === "2" or $_SESSION['superuser'] === "1") { ?><a href="#" onclick="update_div('#ajax','/reports/list_open_tickets.php');update_div('#stats','/reports/graph_department_overview.php');update_div('#calllist','/reports/list_manager_reports.php');">Manager View</a><br/><?php }; ?>
<a href="/login/logout.php">Logout</a><br/>
