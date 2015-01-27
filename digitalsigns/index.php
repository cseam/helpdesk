<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
	<?php
	// load functions
	include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
	?>
	<head>
		<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
	</head>
	<body>
	<div class="section">
	<div id="branding">
	</div>
	<div id="leftpage">
	<div id="stats">
		<p>
			<ul>
				<li>Number of Calls Open</li>
				<li>Number of Calls Closed Today/Yesterday/Last 5 Days</li>
				<li>Average Helpdesk Feedback star rating</li>
			</ul>
		</p>	
	</div>
	<div id="calllist">
		<p>
			<ul>
				<li>Top Helpdesk Engineers Ranking List</li>
				<li>Emerging issues list</li>
			</ul>
		</p>
	</div>
	</div>
	<div id="rightpage">
	<div id="call">
		<div id="ajax">
			<p>
				<ul>
					<li>List of Open Calls who they are assigned too and age of call</li>
				</ul>
			</p>
		</div>
	</div>
	</div>
	</div>
	</body>
</html>