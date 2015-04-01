<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<h3>Department Performance (by day)</h3>
<?php
	$STH = $DBH->Prepare("SELECT engineerName, sum(case when DATE(calls.closed) = DATE_SUB(CURDATE(),INTERVAL 1 DAY) THEN 1 ELSE 0 END) AS mo, sum(case when DATE(calls.closed) = DATE_SUB(CURDATE(),INTERVAL 2 DAY) THEN 1 ELSE 0 END) AS tu, sum(case when DATE(calls.closed) = DATE_SUB(CURDATE(),INTERVAL 3 DAY) THEN 1 ELSE 0 END) AS we, sum(case when DATE(calls.closed) = DATE_SUB(CURDATE(),INTERVAL 4 DAY) THEN 1 ELSE 0 END) AS th, sum(case when DATE(calls.closed) = DATE_SUB(CURDATE(),INTERVAL 5 DAY) THEN 1 ELSE 0 END) AS fr, sum(case when DATE(calls.closed) = DATE_SUB(CURDATE(),INTERVAL 6 DAY) THEN 1 ELSE 0 END) AS sa, sum(case when DATE(calls.closed) = DATE_SUB(CURDATE(),INTERVAL 7 DAY) THEN 1 ELSE 0 END) AS su, sum(case when calls.closed >= DATE_SUB(CURDATE(),INTERVAL 7 DAY) THEN 1 ELSE 0 END) AS last7 FROM engineers LEFT JOIN calls ON calls.closeengineerid = engineers.idengineers WHERE engineers.helpdesk <= :helpdeskid GROUP BY engineerName ORDER BY last7 DESC");

	if ($_SESSION['engineerHelpdesk'] <= '3') {
		$hdid = 3;
	} else {
		$hdid = $_SESSION['engineerHelpdesk'];
	};

	$STH->bindParam(":helpdeskid", $hdid, PDO::PARAM_STR);
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	while($row = $STH->fetch()) {
		$lables .= "'" . $row->engineerName . "',";
		$datamo .= $row->mo . ",";
		$datatu .= $row->tu . ",";
		$datawe .= $row->we . ",";
		$datath .= $row->th . ",";
		$datafr .= $row->fr . ",";
		$datasa .= $row->sa . ",";
		$datasu .= $row->su . ",";
	};
	$datamo = rtrim($datamo, ",");
	$datatu = rtrim($datatu, ",");
	$datawe = rtrim($datawe, ",");
	$datath = rtrim($datath, ",");
	$datafr = rtrim($datafr, ",");
	$datasa = rtrim($datasa, ",");
	$datasu = rtrim($datasu, ",");
	$lables = rtrim($lables, " ,");
	$ticketsin = callsinlastday();
	$ticketsout = callsclosedinlastday();
?>
<style>
	.ct-series-a line {
		stroke: #577d6a !important;
	}
	.ct-series-b line {
		stroke: #5AAB65 !important;
	}
	.ct-series-c line {
		stroke: #B1FFD8 !important;
	}
	.ct-series-d line {
		stroke: #2C4036 !important;
	}
	.ct-series-e line {
		stroke: #A0E5C3 !important;
	}
	.ct-series-f line {
		stroke: #677D6A !important;
	}
	.ct-series-g line {
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
			[<?php echo($datamo);?>],
			[<?php echo($datatu);?>],
			[<?php echo($datawe);?>],
			[<?php echo($datath);?>],
			[<?php echo($datafr);?>],
			[<?php echo($datasa);?>],
			[<?php echo($datasu);?>]
			]
		};
	var options = {
		chartPadding: 5,
		fullWidth: true,
		horizontalBars: true,
		stackBars: true,
		reverseData: true,
		axisY: {
			offset: 100
			}
		};

	new Chartist.Bar('#teamperformance', data, options);
	//END DOM READY
	});
</script>
<div id="teamperformance" class="ct-chart ct-golden-section" style="width: 100%;height:85%;float:left;"></div>