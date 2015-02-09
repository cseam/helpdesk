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
		<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'); ?>
	</head>
	<body>
	<?php
	$sqlstr = "SELECT * FROM calls ";
	$sqlstr .= "INNER JOIN engineers ON calls.assigned=engineers.idengineers ";
	$sqlstr .= "INNER JOIN status ON calls.status=status.id ";
	$sqlstr .= "INNER JOIN categories ON calls.category=categories.id ";
	$sqlstr .= "INNER JOIN location ON calls.location=location.id ";
	$sqlstr .= "INNER JOIN helpdesks ON calls.helpdesk=helpdesks.id ";
	$sqlstr .= "WHERE callid =" . check_input($_GET['id']);
	$result = mysqli_query($db, $sqlstr);
	while($calls = mysqli_fetch_array($result))  {
	?>
	<div class="section">
		<div id="branding">
			<?php include($_SERVER['DOCUMENT_ROOT'] . '/includes/nav.php'); ?>
		</div>
		<div id="leftpage">
			<div id="stats">
			<h3>Full Details</h3>
				<?php
				$engineerviews = $ownerviews = 0;
				$viewsql = "SELECT * FROM call_views WHERE callid='".$calls['callid']."'";
				$views = mysqli_query($db, $viewsql);
					while ($rows = mysqli_fetch_array($views))  {
						if ($rows['sAMAccountName'] === $calls['sAMAccountName']) { ++$engineerviews; };
						if ($rows['sAMAccountName'] === $calls['owner']) { ++$ownerviews; };
					};
				?>
				<!--Google Graphs-->
				<script type="text/javascript" src="https://www.google.com/jsapi"></script>
				<script type="text/javascript">
					google.load("visualization", "1", {packages:["corechart"]});
					google.setOnLoadCallback(drawChart);
					function drawChart() {
						var data = google.visualization.arrayToDataTable([
						['Views', 'Number'],
						['Engineer Views',     <?php echo($engineerviews);?>],
						['Owner Views',      <?php echo($ownerviews);?>]
						]);
						var options = {
						title: '',
						pieHole: 0.5,
						colors: ['#577d6a','#CCCCCC'],
						pieSliceText: 'none',
						legend: 'none',
						};
						var chart = new google.visualization.BarChart(document.getElementById('piechart'));
						chart.draw(data, options);
					}
				</script>
				<div id="piechart" style="width: 100%; float: left;"></div>
			</div>
			<div id="calllist">
				<table>
					<tbody>
						<tr>
							<td>Ticket ID</td>
							<td>#<?php echo($calls['callid']);?></td>
						</tr>
						<tr>
							<td>Owner</td>
							<td><?php echo($calls['owner']);?></td>
						</tr>
						<tr>
							<td>Primary Contact Name</td>
							<td><?php echo($calls['name']);?></td>
						</tr>
						<tr>
							<td>Primary Contact Email</td>
							<td><?php echo($calls['email']);?></td>
						</tr>
						<tr>
							<td>Primary Contact Telephone</td>
							<td><?php echo($calls['tel']);?></td>
						</tr>
						<tr>
							<td>Location</td>
							<td><?php echo($calls['locationName']);?></td>
						</tr>
						<tr>
							<td>Room</td>
							<td><?php echo($calls['room']);?></td>
						</tr>
						<tr>
							<td>Category</td>
							<td><?php echo($calls['categoryName']);?> (id:<?php echo($calls['category']);?>)</td>
						</tr>
						<tr>
							<td>Urgency</td>
							<td>
								<?php
									SWITCH ($calls['urgency']) {
									CASE "1":
										echo("Low");
										break;
									CASE "2":
										echo("Normal");
										break;
									CASE "3":
										echo("High");
										break;
									} ?> (<?php echo($calls['urgency']);?>)</td>
						</tr>
						<tr>
							<td>Engineer Assigned</td>
							<td><?php echo($calls['engineerName']);?> - <?php echo($calls['engineerEmail']);?> (id:<?php echo($calls['assigned']);?>)</td>
						</tr>
						<tr>
							<td>Ticket Opened at</td>
							<td><?php echo(date("d/m/y h:s", strtotime($calls['opened'])));?></td>
						</tr>
						<tr>
							<td>Ticket Last Updated at</td>
							<td><?php echo(date("d/m/y h:s", strtotime($calls['lastupdate'])));?></td>
						</tr>
						<tr>
							<td>Ticket Closed at</td>
							<td>
							<?php
								if ($calls['status'] === '1') {
									echo("Call still open.");
								} else {
									echo(date("d/m/y h:s", strtotime($calls['closed'])));
								}?>
							</td>
						</tr>
						<tr>
							<td>Ticket Duration</td>
							<td>
							<?php
								$date1 = strtotime($calls['opened']);
								if ($calls['status'] ==='2') { $date2 = strtotime($calls['closed']); } else { $date2 = time(); };
								$diff = $date2 - $date1;
								$d = ($diff/(60*60*24))%365;
								$h = ($diff/(60*60))%24;
								$m = ($diff/60)%60;
								echo($d." days, ".$h." hours, ".$m." minutes.");
							?>
							</td>
						</tr>
						<tr>
							<td>Status</td>
							<td><?php echo($calls['status']);?> (<?php echo($calls['statusCode']);?>)</td>
						</tr>
						<tr>
							<td>Department</td>
							<td><?php echo($calls['helpdesk_name']);?> (#<?php echo($calls['helpdesk']);?>)</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div id="rightpage">
			<div id="addcall">
				<div id="ajax">
					<h2>Ticket Correspondence</h2>
					<?php echo($calls['details']);?>
					<?php
						// if manager show call feedback if any feedback given.
						if ($_SESSION['engineerLevel'] == '2' & $calls['status'] == '2') {
					?>
					<h2>Ticket Feedback</h2>
					<?php
						// select feedback for this call
						$feedbackstr = "SELECT * FROM feedback WHERE callid='".$calls['callid']."'";
						$feedbackresults = mysqli_query($db, $feedbackstr);
						if (mysqli_num_rows($feedbackresults) == 0) { echo "<p>No feedback given.</p>";};
						while ($rows = mysqli_fetch_array($feedbackresults))  { ?>
						<?php if ($rows['satisfaction'] == 1) { echo "<img src='/images/ICONS-star.png' alt='star' height='17' width='auto' />"; };?>
		<?php if ($rows['satisfaction'] == 2) { echo "<img src='/images/ICONS-star.png' alt='star' height='17' width='auto' /><img src='/images/ICONS-star.png' alt='star' height='17' width='auto' />"; };?>
		<?php if ($rows['satisfaction'] == 3) { echo "<img src='/images/ICONS-star.png' alt='star' height='17' width='auto' /><img src='/images/ICONS-star.png' alt='star' height='17' width='auto' /><img src='/images/ICONS-star.png' alt='star' height='17' width='auto' />"; };?>
		<?php if ($rows['satisfaction'] == 4) { echo "<img src='/images/ICONS-star.png' alt='star' height='17' width='auto' /><img src='/images/ICONS-star.png' alt='star' height='17' width='auto' /><img src='/images/ICONS-star.png' alt='star' height='17' width='auto' /><img src='/images/ICONS-star.png' alt='star' height='17' width='auto' />"; };?>
		<?php if ($rows['satisfaction'] == 5) { echo "<img src='/images/ICONS-star.png' alt='star' height='17' width='auto' /><img src='/images/ICONS-star.png' alt='star' height='17' width='auto' /><img src='/images/ICONS-star.png' alt='star' height='17' width='auto' /><img src='/images/ICONS-star.png' alt='star' height='17' width='auto' /><img src='/images/ICONS-star.png' alt='star' height='17' width='auto' />"; };?>
						<p><?php echo($rows['details']);?></p><p>(<?php echo($rows['opened']);?> - <?php echo($calls['name'])?>)</p>
						<?php	};	?>
				<?php	}; ?>
			</div>
		</div>
	</div>
</div>
<?php }; ?>
</body>
</html>