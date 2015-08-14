<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<h3>Engineer Breakdown This Month</h3>
<?php
	$STH = $DBH->Prepare("SELECT Month(closed) AS MonthNum, helpdesk, assigned, count(callid) AS Totals
		FROM calls
		WHERE status = 2 AND Month(closed) = :month AND Year(closed) = :year
		GROUP BY assigned
		ORDER BY helpdesk DESC");
	
	$STH->bindParam(':month', date("m"), PDO::PARAM_INT);
	$STH->bindParam(':year', date("o"), PDO::PARAM_INT);
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	
	while($row = $STH->fetch()) {
		$lables .= "'" . engineer_friendlyname($row->assigned) . "',";
		$data .= $row->Totals . ",";
	};
	$data = rtrim($data, ",");
	$lables = rtrim($lables, " ,");
?>

<script type="text/javascript">
	$(function() {
	// WAIT FOR DOM
	// Draw Bar chartist.js
	var data = {
		labels: [<?php echo($lables);?>],
		series: [[<?php echo($data);?>]],
		};
	var options = {
		fullWidth: true,
		horizontalBars: true,
		axisY: {
			onlyInteger: true,
			offset: 150
			},
		axisX: {
			onlyInteger: true
			}
		};

	new Chartist.Bar('#engineer_breakdown', data, options);
	
	//END DOM READY
	});
</script>
<div id="engineer_breakdown" class="ct-chart ct-square"></div>