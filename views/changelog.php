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
					<h2>ChangeLog</h2>
					<p>Helpdesk develops on a regular basis, to help highlight changes to users this change log shows recent changes to Helpdesk. Development items are also listed and will feature in future builds of helpdesk.</p><p>if you wish to request a feature please log a websites helpdesk, more detailed change details are available on <a href="https://github.com/atomicjam/helpdesk">Github</a></p>
				</div>
				<div id="calllist">
					<h3>Outstanding Development Items</h3>
					<p>in no particular order</p>
						<ul>
							<li>Engineer Coverage Hours</li>
							<li>User Profiles</li>
							<li>Setup & Management Scripts</li>
							<li>Multiple Engineers assigned to one ticket</li>
							<li>Hold & Escalate behaviour simplification</li>
							<li>Reports for Engineers Performance</li>
							<li>Asset Management in Helpdesk</li>
							<li>Permalink to a ticket</li>
							<li>Back Button behaviour fix</li>
							<li>View recent calls for user in ticket</li>
							<li>Terms and conditions on ticket creation</li>
							<li>Ability to switch Helpdesks as manager</li>
							<li>On hover pop-out details on ticket</li>
							<li>Advanced search</li>
							<li>Average durations report</li>
							<li>Ticket timeline</li>
							<li>Managers subscribe to notifications</li>
							<li>Managers customise views</li>
							<li>Edit/Delete Scheduled tasks and change-control</li>
							<li>Update feedback page</li>
						</ul>
				</div>
				</div>
			<div id="rightpage">
				<div id="call">
					<div id="ajax">
						<h3>Change Log</h3>
						<hr/>
						<h4>Oct, 2015 - Adv Search</h4>
							<ul>
								<li>ability to remove scheduled tickets</li>
								<li>updated icon set to SVG</li>
								<li>added changelog page</li>
								<li>added advanced search report</li>
								<li>added working on and job sheets</li>
								<li>added ability to disable engineer</li>
								<li>added backup script</li>
								<li>added accordion menu for managers reports</li>
								<li>added profile pictures to tickets</li>
								<li>added pm calls</li>
							</ul>
						
						<hr/>
						<h4>Aug, 2015 - Reports Area</h4>
							<ul>
								<li>added reports area and moved manager reports over</li>
								<li>added SLA to Db and reports for this</li>
								<li>updated charts with responsive designs</li>
								<li>added mobile specific menus</li>
								<li>added print stylesheet</li>
							</ul>
						
						<hr/>
						<h4>Apr, 2015 - CRON</h4>
							<ul>
								<li>added cron script to run daily tasks</li>
								<li>added escalation feature for engineers</li>
								<li>added ticket hold feature</li>
								<li>added out of hours form</li>
							</ul>
						
						<hr/>
						<h4>Mar, 2015 - PDO</h4>
							<ul>
								<li>switched forms to PDO to stop injection attacks</li>
								<li>added front desk lockers for IT</li>
							</ul>
						
						<hr/>
						<h4>Feb, 2015 - Superusers</h4>
							<ul>
								<li>added super user account who can see everything</li>
								<li>added reason for call</li>
								<li>created digital screen for IT office</li>
								<li>added google analytics</li>
							</ul>
						<hr/>
						<h4>Jan, 2015 - Punchcard</h4>
							<ul>
								<li>added engineer punchcard</li>
								<li>added change control </li>
								<li>added urgent calls</li>
								<li>added cfg file and git ignore on settings files</li>
							</ul>
						
						<hr/>
						<h4>Nov, 2014 - Search</h4>
							<ul>
								<li>added ability to search tickets</li>
								<li>added scheduled tickets</li>
								<li>added custom icons and artwork</li>
								<li>added ticket feedback for managers only</li>
							</ul>
						
						<hr/>
						<h4>Oct, 2014 - LDAP authentication</h4>
							<ul>
								<li>login via ldap now supported</li>
								<li>ability to forward tickets</li>
								<li>ability to add multiple images to ticket</li>
							</ul>
						<hr/>
						<h4>Aug, 2014 - Reports</h4>
							<ul>
								<li>added work rate reports</li>
								<li>added emerging issues reports</li>
								<li>added robots/humans.txt</li>
								<li>Navigationn is now user aware showing only correct links</li>
								<li>updated welcome text</li>
								<li>added basic reports for engineers</li>
								<li>Whenever a ticket is changed stakeholders are emailed</li>
								<li>add file upload to ticket so screenshots can be added</li>
								<li>validation added to new ticket form</li>
								<li>added call duration to tickets</li>
								<li>Added view for users to see their calls</li>
								<li>added location to database</li>
								<li>basic graphs added to engineers view</li>
								<li>updated look and feel styles</li>
							</ul>
						<hr/>
						<h4>Jul, 2014 - View tickets and close tickets</h4>
							<ul>
								<li>New view for engineers</li>
								<li>function to close tickets</li>
								<li>added new fields to add ticket form</li>
								<li>tickets now calculate urgency from fields on form</li>
								<li>Created basic SQL tables</li>
								<li>Spec from Works added to GITHUB</li>
								<li>function to assign tickets to engineers</li>
								<li>add ticket form</li>
								<li>Setup Github Project</li>
								<li>Setup Server</li>
							</ul>
					</div>
				</div>
				
			</div>
		</div>
	<a href="/views/changelog.php" target="_blank" class="changelog">changelog</a>
	</body>
</html>