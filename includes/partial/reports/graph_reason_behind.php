<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<h2>Reason Behind Tickets</h2>
<p>Chart showing option engineer has set when ticket has been closed in last 30 days</p>
	<?php
		if ($_SESSION['engineerHelpdesk'] <= '3') {
			$STH = $DBH->Prepare("SELECT callreasons.reason_name, count(*) AS last7 FROM calls INNER JOIN callreasons ON calls.callreason = callreasons.id WHERE calls.helpdesk <= :helpdeskid AND calls.status='2' AND calls.closed >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) GROUP BY callreasons.reason_name");
			$hdid = 3;
		} else {
			$STH = $DBH->Prepare("SELECT callreasons.reason_name, count(*) AS last7 FROM calls INNER JOIN callreasons ON calls.callreason = callreasons.id WHERE calls.helpdesk = :helpdeskid AND calls.status='2' AND calls.closed >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) GROUP BY callreasons.reason_name");
			$hdid = $_SESSION['engineerHelpdesk'];
		};
		$STH->bindParam(":helpdeskid", $hdid, PDO::PARAM_STR);
		$STH->setFetchMode(PDO::FETCH_OBJ);
		$STH->execute();
		while($row = $STH->fetch()) {
			// setup labels
				$lables .=  "'".$row->reason_name."' ,";
			// series
				$series .= $row->last7.",";
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
	new Chartist.Bar('#reasonBehind', data, options);
	</script>
<style>
	#reasonBehind .ct-bar {
		stroke: #577d6a !important;
		stroke-width: 30px !important;
	}
</style>
<div id="reasonBehind" class="ct-chart ct-perfect-fourth"></div>