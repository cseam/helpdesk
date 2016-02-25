<?php
	//TODO must be better way to do this this is a faff 
	// reset strings
	$label = "";
	$series = "";
	// loop stats object to populate strings for graph
	foreach($stats as $key => $value) {
		$label .= "'" . $value["engineerName"] . "',";
		$mon .= "'" . $value["mon"] . "',";
		$tue .= "'" . $value["tue"] . "',";
		$wed .= "'" . $value["wed"] . "',";
		$thu .= "'" . $value["thu"] . "',";
		$fri .= "'" . $value["fri"] . "',";
		$sat .= "'" . $value["sat"] . "',";
		$sun .= "'" . $value["sun"] . "',";
	}
	$series .= "[" . rtrim($mon, ",") . "],";
	$series .= "[" . rtrim($tue, ",") . "],";
	$series .= "[" . rtrim($wed, ",") . "],";
	$series .= "[" . rtrim($thu, ",") . "],";
	$series .= "[" . rtrim($fri, ",") . "],";
	$series .= "[" . rtrim($sat, ",") . "],";
	$series .= "[" . rtrim($sun, ",") . "],";
?>
<script type="text/javascript">
	$(function() {
	// WAIT FOR DOM
	// Draw Bar chartist.js
	var data = {
		labels: [<?php echo $label ?>],
		series: [<?php echo $series ?>]
		};
	var options = {
		chartPadding: 15,
		fullWidth: true,
		horizontalBars: true,
		stackBars: true,
		reverseData: true,
		seriesBarDistance: 10,
		axisY: {
			onlyInteger: true,
			offset: 150
			},
		axisX: {
			onlyInteger: true
			}
		};
	new Chartist.Bar('#teamperformance', data, options);
	});
</script>
<div id="teamperformance" class="ct-chart ct-golden-section" style="width: 100%;height:85%;float:left;"></div>
<div style="float:right;margin-top: -20px;margin-right: 8px;">
  <span style="font-size: 0.6rem;color: white;background: #BFCC80;padding: 0.1rem 0.5rem;"><?php echo(date("j/m/Y",strtotime("-6 day")));?></span>
  <span style="font-size: 0.6rem;color: white;background: #FFA38B;padding: 0.1rem 0.5rem;"><?php echo(date("j/m/Y",strtotime("-5 day")));?></span>
  <span style="font-size: 0.6rem;color: white;background: #FDD26E;padding: 0.1rem 0.5rem;"><?php echo(date("j/m/Y",strtotime("-4 day")));?></span>
  <span style="font-size: 0.6rem;color: white;background: #C09C83;padding: 0.1rem 0.5rem;"><?php echo(date("j/m/Y",strtotime("-3 day")));?></span>
  <span style="font-size: 0.6rem;color: white;background: #B8CCEA;padding: 0.1rem 0.5rem;"><?php echo(date("j/m/Y",strtotime("-2 day")));?></span>
  <span style="font-size: 0.6rem;color: white;background: #BFCEC2;padding: 0.1rem 0.5rem;"><?php echo(date("j/m/Y",strtotime("-1 day")));?></span>
  <span style="font-size: 0.6rem;color: white;background: #D1CCBD;padding: 0.1rem 0.5rem;">Today</span>
</div>
