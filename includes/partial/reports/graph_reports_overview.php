<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<h3>Tickets Closed (all helpdesks)</h3>
<?php
		$STH = $DBH->Prepare("SELECT Month(closed) AS MonthNum, helpdesk, count(callid) AS Totals
			FROM calls
			WHERE status = 2 AND Year(closed) = :year
			GROUP BY Month(closed)
			ORDER BY MonthNum, helpdesk");
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->bindParam(':year', date("o"), PDO::PARAM_INT);
	$STH->execute();
	
	while($row = $STH->fetch()) {
		$lables .= "' " . date("F", mktime(0, 0, 0, $row->MonthNum, 10)) . " ',";
		$data .= $row->Totals . ",";
	};
	$data = rtrim($data, ",");
	$lables = rtrim($lables, " ,");
?>
<style>
	.ct-series-a path {
		stroke: #577d6a !important;
	}
	.ct-line {
		stroke-width: 2px !important;
	}
	.ct-series-a .ct-point  {
		stroke: #577d6a !important;
		stroke-width: 8px !important;
	}
</style>

<script type="text/javascript">
	$(function() {
	// WAIT FOR DOM
	// Draw Bar chartist.js
	var data = {
		labels: [<?php echo($lables);?>],
		series: [[<?php echo($data);?>]],
		};
	var options = {
			chartPadding: 30,		
		};

	new Chartist.Line('#reportspie', data, options);
	
	//END DOM READY
	});
</script>
<div id="reportspie" class="ct-chart ct-golden-section" style="width: 100%;height:85%;float:left;"></div>