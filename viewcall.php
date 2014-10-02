<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
	<?php
	// load functions
	include_once 'includes/functions.php';
	// check authentication 
	if (empty($_SESSION['sAMAccountName'])) { prompt_auth($_SERVER['REQUEST_URI']); };
	?>
	<head>
		<title><?=$codename;?> - Full Call Details</title>
		<link rel="shortcut icon" href="clcfavicon.ico" type="image/x-icon" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" /> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="robots" content="nofollow" />
		<link rel="stylesheet" type="text/css" href="css/reset.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
	</head>
	<body>
	<?php 
	$sqlstr = "SELECT * FROM calls ";
	$sqlstr .= "INNER JOIN engineers ON calls.assigned=engineers.idengineers ";
	$sqlstr .= "INNER JOIN status ON calls.status=status.id ";
	$sqlstr .= "INNER JOIN categories ON calls.category=categories.id ";
	$sqlstr .= "INNER JOIN location ON calls.location=location.id ";
	$sqlstr .= "WHERE callid =" . check_input($_GET['id']);
	$result = mysqli_query($db, $sqlstr);
	while($calls = mysqli_fetch_array($result))  {
	?>
	
	
		<div class="section">
	<div id="branding">
		<?php include 'includes/nav.php'; ?>
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
          ['Engineer Views',     <?=$engineerviews?>],
          ['Owner Views',      <?=$ownerviews?>]
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
					<td>Call ID</td>
					<td>#<?=$calls['callid'];?></td>
				</tr>
				<tr>
					<td>Primary Contact Name</td>
					<td><?=$calls['name'];?></td>
				</tr>
				<tr>
					<td>Primary Contact Email</td>
					<td><?=$calls['email'];?></td>
				</tr>
				<tr>
					<td>Primary Contact Telephone</td>
					<td><?=$calls['tel'];?></td>
				</tr>
				<tr>
					<td>Location</td>
					<td><?=$calls['locationName'];?></td>
				</tr>
				<tr>
					<td>Room</td>
					<td><?=$calls['room'];?></td>
				</tr>
				<tr>
					<td>Category</td>
					<td><?=$calls['categoryName'];?> (id:<?=$calls['category'];?>)</td>
				</tr>
				<tr>
					<td>Urgency</td>
					<td>
					<?php SWITCH ($calls['urgency']) {
							CASE "1":
							echo "Low";
							break;
							CASE "2":
							echo "Normal";
							break;
							CASE "3":
							echo "High";
							break;
							} ?> (<?=$calls['urgency'];?>)</td>
				</tr>
				<tr>
					<td>Engineer Assigned</td>
					<td><?=$calls['engineerName'];?> - <?=$calls['engineerEmail'];?> (id:<?=$calls['assigned'];?>)</td>
				</tr>
				<tr>
					<td>Call Opened at</td>
					<td><?=date("d/m/y h:s", strtotime($calls['opened']));?></td>
				</tr>
				<tr>
					<td>Call Last Updated at</td>
					<td><?=date("d/m/y h:s", strtotime($calls['lastupdate']));?></td>
				</tr>
				<tr>
					<td>Call Closed at</td>
					<td>
					<?php
						if ($calls['status'] === '1') {
							echo "Call still open.";							
						} else {
							echo date("d/m/y h:s", strtotime($calls['closed']));
						}
					?>
					</td>
				</tr>
				<tr>
					<td>Call Duration</td>
					<td>
					<?php
						$date1 = strtotime($calls['opened']);
						if ($calls['status'] ==='2') { $date2 = strtotime($calls['closed']); } else { $date2 = time(); };
						$diff = $date2 - $date1;
						$d = ($diff/(60*60*24))%365;
						$h = ($diff/(60*60))%24;
						$m = ($diff/60)%60;
						echo $d." days, ".$h." hours, ".$m." minutes.";
					?>
					</td>
				</tr>
				<tr>
					<td>Status</td>
					<td><?=$calls['status'];?> (<?=$calls['statusCode'];?>)</td>
				</tr>
			</tbody>
		</table>
	</div>
	</div>
	<div id="rightpage">
		<div id="addcall">
			<div id="ajax">
				<h2>Call Correspondence</h2>
				<?=$calls['details'];?>
			</div>
		</div>
	</div>
	</div>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js" type="text/javascript"></script>	
	<script src="javascript/jquery.js" type="text/javascript"></script>
	<? } ?>
	</body>
</html>