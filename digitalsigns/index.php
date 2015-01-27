<?php session_start();?>
<!DOCTYPE HTML>
<html lang="en"  id="digitalsign">
	<?php
	// load functions
	include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
	?>
	<head>
		<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
		<meta http-equiv="refresh" content="30">
	</head>
	<body>
	<div class="section">
	<div id="branding">
	</div>
	<div id="leftpage">
		<table id="digitalsign-stats">
			<tbody>
				<tr>
					<td class="xbig">10</td>
					<td class="xbig">10</td>
					<td class="xbig">10</td>
					<td class="xbig">10</td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td>Open Calls</td>
					<td>Closed Today</td>
					<td>Closed This Week</td>
					<td>Average Feedback (out of 5)</td>
				</tr>
			</tfoot>
		</table>
		<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/digitalsigns/includes/topengineers.php'; ?>
		<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/digitalsigns/includes/issues.php'; ?>
	</div>
	<div id="rightpage">
	<div id="call">
		<div id="ajax">
			<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/digitalsigns/includes/opencalls.php'; ?>
		</div>
	</div>
	</div>
	</div>
	</body>
</html>