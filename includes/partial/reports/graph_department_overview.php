<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<h3>Total Closed (Cumulative last 7 days)</h3>
<?php
	if ($_SESSION['engineerHelpdesk'] <= '3') {
		$hdid = 3;
		$STH = $DBH->Prepare("SELECT engineerName,
		sum(case when DATE(calls.closed) = DATE_SUB(CURDATE(),INTERVAL 0 DAY) THEN 1 ELSE 0 END) AS mo,
		sum(case when DATE(calls.closed) = DATE_SUB(CURDATE(),INTERVAL 1 DAY) THEN 1 ELSE 0 END) AS tu,
		sum(case when DATE(calls.closed) = DATE_SUB(CURDATE(),INTERVAL 2 DAY) THEN 1 ELSE 0 END) AS we,
		sum(case when DATE(calls.closed) = DATE_SUB(CURDATE(),INTERVAL 3 DAY) THEN 1 ELSE 0 END) AS th,
		sum(case when DATE(calls.closed) = DATE_SUB(CURDATE(),INTERVAL 4 DAY) THEN 1 ELSE 0 END) AS fr,
		sum(case when DATE(calls.closed) = DATE_SUB(CURDATE(),INTERVAL 5 DAY) THEN 1 ELSE 0 END) AS sa,
		sum(case when DATE(calls.closed) = DATE_SUB(CURDATE(),INTERVAL 6 DAY) THEN 1 ELSE 0 END) AS su,
		sum(case when calls.closed >= DATE_SUB(CURDATE(),INTERVAL 6 DAY) THEN 1 ELSE 0 END) AS last7
		FROM engineers
		LEFT JOIN calls ON calls.closeengineerid = engineers.idengineers
		WHERE engineers.helpdesk <= :helpdeskid
		AND engineers.disabled=0
		GROUP BY engineerName
		ORDER BY last7 DESC");
	} else {
		$hdid = $_SESSION['engineerHelpdesk'];
		$STH = $DBH->Prepare("SELECT engineerName,
		sum(case when DATE(calls.closed) = DATE_SUB(CURDATE(),INTERVAL 0 DAY) THEN 1 ELSE 0 END) AS mo,
		sum(case when DATE(calls.closed) = DATE_SUB(CURDATE(),INTERVAL 1 DAY) THEN 1 ELSE 0 END) AS tu,
		sum(case when DATE(calls.closed) = DATE_SUB(CURDATE(),INTERVAL 2 DAY) THEN 1 ELSE 0 END) AS we,
		sum(case when DATE(calls.closed) = DATE_SUB(CURDATE(),INTERVAL 3 DAY) THEN 1 ELSE 0 END) AS th,
		sum(case when DATE(calls.closed) = DATE_SUB(CURDATE(),INTERVAL 4 DAY) THEN 1 ELSE 0 END) AS fr,
		sum(case when DATE(calls.closed) = DATE_SUB(CURDATE(),INTERVAL 5 DAY) THEN 1 ELSE 0 END) AS sa,
		sum(case when DATE(calls.closed) = DATE_SUB(CURDATE(),INTERVAL 6 DAY) THEN 1 ELSE 0 END) AS su,
		sum(case when calls.closed >= DATE_SUB(CURDATE(),INTERVAL 6 DAY) THEN 1 ELSE 0 END) AS last7
		FROM engineers
		LEFT JOIN calls ON calls.closeengineerid = engineers.idengineers
		WHERE engineers.helpdesk = :helpdeskid
		AND engineers.disabled=0
		GROUP BY engineerName
		ORDER BY last7 DESC");
	};

	$STH->bindParam(":helpdeskid", $hdid, PDO::PARAM_STR);
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	while($row = $STH->fetch()) {
		$lables .= "' " . $row->engineerName . " ',";
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
		stroke: #BFCC80 !important;
	}
	.ct-series-b line {
		stroke: #FFA38B !important;
	}
	.ct-series-c line {
		stroke: #FDD26E !important;
	}
	.ct-series-d line {
		stroke: #C09C83 !important;
	}
	.ct-series-e line {
		stroke: #B8CCEA !important;
	}
	.ct-series-f line {
		stroke: #BFCEC2 !important;
	}
	.ct-series-g line {
		stroke: #D1CCBD !important;
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
		chartPadding: 20,
		fullWidth: true,
		horizontalBars: true,
		stackBars: true,
		reverseData: true,
		seriesBarDistance: 10,
		axisY: {
			onlyInteger: true,
			offset: 100
			},
		axisX: {
			onlyInteger: true
			}	
		};

	new Chartist.Bar('#teamperformance', data, options);
	
	//END DOM READY
	});
</script>
<div id="teamperformance" class="ct-chart ct-golden-section" style="width: 100%;height:85%;float:left;"></div>
<div style="float:right;margin-top: -25px;margin-right: 20px;">	
<span style="font-size: 0.6rem;color: white;background: #BFCC80;padding: 0.2rem 0.5rem;"><?php echo(date("j/m/y",strtotime("-6 day")));?></span>
<span style="font-size: 0.6rem;color: white;background: #FFA38B;padding: 0.2rem 0.5rem;"><?php echo(date("j/m/y",strtotime("-5 day")));?></span>
<span style="font-size: 0.6rem;color: white;background: #FDD26E;padding: 0.2rem 0.5rem;"><?php echo(date("j/m/y",strtotime("-4 day")));?></span>
<span style="font-size: 0.6rem;color: white;background: #C09C83;padding: 0.2rem 0.5rem;"><?php echo(date("j/m/y",strtotime("-3 day")));?></span>
<span style="font-size: 0.6rem;color: white;background: #B8CCEA;padding: 0.2rem 0.5rem;"><?php echo(date("j/m/y",strtotime("-2 day")));?></span>
<span style="font-size: 0.6rem;color: white;background: #BFCEC2;padding: 0.2rem 0.5rem;"><?php echo(date("j/m/y",strtotime("-1 day")));?></span>
<span style="font-size: 0.6rem;color: white;background: #D1CCBD;padding: 0.2rem 0.5rem;">Today</span>
</div>


