<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<h3>Department Performance</h3>
<?php
	// Prep chart Data
	if ($_SESSION['engineerHelpdesk'] <= '3') { $whereenginners = 'WHERE engineers.helpdesk <= 3'; } else { $whereenginners = 'WHERE engineers.helpdesk='.$_SESSION['engineerHelpdesk']; };

	$sql ="SELECT engineerName, sum(case when calls.closed >= DATE_SUB(CURDATE(),INTERVAL 7 DAY) THEN 1 ELSE 0 END) AS Last7 FROM engineers LEFT JOIN calls ON calls.closeengineerid = engineers.idengineers " . $whereenginners . " GROUP BY engineerName ORDER BY Last7 DESC;";
	$result = mysqli_query($db, $sql);
		while($loop = mysqli_fetch_array($result)) {

				$lables .= "'" . $loop['engineerName'] . "',";
				$data .= $loop['Last7'] . ",";
		};
		$data = rtrim($data, ",");
		$lables = rtrim($lables, " ,");
		$ticketsin = callsinlastday();
		$ticketsout = callsclosedinlastday();
?>
<style>
	.ct-bar {
		stroke: #577d6a !important;
		stroke-width: 10px !important;
	}
	.ct-series-b path {
		stroke: #577d6a !important;
	}
	.ct-series-a path {
		stroke: #ccc !important;
	}
</style>
<script type="text/javascript">
	$(function() {
	// WAIT FOR DOM
	// Draw Bar chartist.js
	var data = {
		labels: [<?php echo($lables);?>],
		series: [
			{
			data: [<?php echo($data);?>]
			}
			]
		};
	var options = {
		chartPadding: 5,
		seriesBarDistance: 10,
		horizontalBars: true,
		reverseData: true,
		axisY: {
			offset: 100
		}
		};
	new Chartist.Bar('#teamperformance', data, options);
	// Draw Pie chartist.js

	var pieData = {

		series: [<?php echo($ticketsin);?>,<?php echo($ticketsout);?>]

		};

	var pieOptions = {
		chartPadding: 5,
		donut: true,
		donutWidth: 30
	};

	new Chartist.Pie('#howbusy', pieData, pieOptions);
	//END DOM READY
	});
</script>
<div id="teamperformance" class="ct-chart ct-golden-section" style="width: 60%;float:left;"></div>
<div id="howbusy" class="ct-chart ct-perfect-fourth" style="width:40%; float: left;"></div>