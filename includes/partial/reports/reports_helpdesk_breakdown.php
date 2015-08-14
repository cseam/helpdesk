<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<h3>Closed this month</h3>
<?php
	$STH = $DBH->Prepare("SELECT Month(closed) AS MonthNum, helpdesk, count(callid) AS Totals
		FROM calls
		WHERE status = 2 AND Month(closed) = :month AND Year(closed) = :year
		GROUP BY helpdesk, Month(closed)
		ORDER BY helpdesk, MonthNum");
	
	$STH->bindParam(':month', date("m"), PDO::PARAM_INT);
	$STH->bindParam(':year', date("o"), PDO::PARAM_INT);
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	
	while($row = $STH->fetch()) {
		$lables .= "' " . helpdesk_friendlyname($row->helpdesk) . "(" . $row->Totals . ") ',";
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
		series: [<?php echo($data);?>],
		};
	var options = {
		donut: true,
		chartPadding: 30,
		labelOffset: 50,
		labelDirection: 'explode',
			labelInterpolationFnc: function(value) {
			return value
			}
		};

	new Chartist.Pie('#helpdesk_breakdown', data, options);
	
	//END DOM READY
	});
</script>
<div id="helpdesk_breakdown" class="ct-chart ct-golden-section"></div>


