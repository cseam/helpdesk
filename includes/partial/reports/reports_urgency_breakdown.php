<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<h3>Urgency Breakdown This Month</h3>
<?php
	$STH = $DBH->Prepare("SELECT urgency, helpdesk, count(callid) AS Totals
		FROM calls
		WHERE status = 2 AND Month(closed) = :month AND Year(closed) = :year
		GROUP BY urgency
		ORDER BY urgency");
	
	$STH->bindParam(':month', date("m"), PDO::PARAM_INT);
	$STH->bindParam(':year', date("o"), PDO::PARAM_INT);
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	
	while($row = $STH->fetch()) {
		$lables .= "' " . urgency_friendlyname($row->urgency) . " (" . $row->Totals . ") ',";
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
		chartPadding: 50,
		labelOffset: 50,
		labelDirection: 'explode',
			labelInterpolationFnc: function(value) {
			return value
			}
		};

	new Chartist.Pie('#urgencychart', data, options);
	
	//END DOM READY
	});
</script>
<div id="urgencychart" class="ct-chart ct-golden-section"></div>


