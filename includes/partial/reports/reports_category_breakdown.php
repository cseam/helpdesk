<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<h3>Category Breakdown This Month</h3>
<?php
	$STH = $DBH->Prepare("SELECT Month(closed) AS MonthNum, helpdesk, category, count(callid) AS Totals
		FROM calls
		WHERE status = 2 AND Month(closed) = :month AND Year(closed) = :year
		GROUP BY category
		ORDER BY Totals");
	
	$STH->bindParam(':month', date("m"), PDO::PARAM_INT);
	$STH->bindParam(':year', date("o"), PDO::PARAM_INT);
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	
	while($row = $STH->fetch()) {
		$lables .= "'" . category_friendlyname($row->category) . " (" .helpdesk_friendlyname($row->helpdesk). ")',";
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
			offset: 250
			},
		axisX: {
			onlyInteger: true
			}
		};

	new Chartist.Bar('#category_breakdown', data, options);
	
	//END DOM READY
	});
</script>
<div id="category_breakdown" class="ct-chart ct-square"></div>