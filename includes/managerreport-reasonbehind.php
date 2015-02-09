<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<p>Chart showing option engineer has set when ticket has been closed in last 30 days</p>
	<?php
		// filter helpdesks
		 if ($_SESSION['engineerHelpdesk'] <= '3') {
			$whereenginners = 'WHERE calls.helpdesk <= 3';
		} else {
			$whereenginners = 'WHERE calls.helpdesk='.$_SESSION['engineerHelpdesk'];
		};
		// count reason in last 3 days
		$sql ="SELECT callreasons.reason_name, count(*) AS last7 FROM calls INNER JOIN callreasons ON calls.callreason = callreasons.id ". $whereenginners ." AND calls.status = '2' AND calls.closed >= DATE_SUB(CURDATE(),INTERVAL 30 DAY) GROUP BY callreasons.reason_name;";
		$result = mysqli_query($db, $sql);
			while($loop = mysqli_fetch_array($result)) {
			// setup labels
				$lables .=  "'".$loop ['reason_name']. "' ,";
			// series
				$series .= $loop ['last7'] . ",";
			};
			$lables = rtrim($lables, " ,");
			$series = rtrim($series, ",");
	?>
	<script type="text/javascript">
	var data = {
		labels: [<?php echo($lables);?>],
		series: [[<?php echo($series);?>]]
	};
	var options = {
		seriesBarDistance: 10,
		reverseData: true,
		horizontalBars: true,
		axisY: { offset: 120 }
	};
	new Chartist.Bar('.ct-chart', data, options);
	</script>
	<div class="ct-chart ct-perfect-fourth"></div>