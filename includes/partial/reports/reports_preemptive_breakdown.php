<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<h3>PPM Breakdown This Month (all Helpdesks)</h3>
<?php
	$STH = $DBH->Prepare("SELECT pm, count(callid) AS Totals
		FROM calls
		WHERE Month(closed) = :month AND Year(closed) = :year
		GROUP BY pm
		ORDER BY Totals");
	
	$STH->bindParam(':month', date("m"), PDO::PARAM_INT);
	$STH->bindParam(':year', date("o"), PDO::PARAM_INT);
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	
	while($row = $STH->fetch()) {

			SWITCH ($row->pm) {
				CASE '0':
					$pmfriendlyname = 'Reactive Ticket';
					break;
				CASE '1':
					$pmfriendlyname = 'Planned Ticket';
					break;
				DEFAULT:
					$pmfriendlyname = 'Not Classified';
					break;
			};
		$lables .= "'" . $pmfriendlyname . " (" . $row->Totals. ")',";
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

	new Chartist.Pie('#pe_breakdown', data, options);
	
	//END DOM READY
	});
</script>
<div id="pe_breakdown" class="ct-chart ct-square"></div>