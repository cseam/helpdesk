<?php
  //TODO must be better way to do this this is a faff
  // reset strings
  $mon = $tue = $wed = $thu = $fri = $sat = $sun = $label = $series = $assistlabel = $assists = null;
  // loop stats object to populate strings for closed graph
  foreach($left->sideData["graphdata"] as $key => $value) {
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
  // loop assistdata object to populate strings for assist graph
  foreach($left->sideData["assistdata"] as $key => $value) {
      $assistlabel .= "'" . $key . "',";
      $assists .= $value . ",";
  }
  $assists = rtrim($assists, ",")
?>
<script type="text/javascript">
	function assists() {
		var data = { labels: [<?php echo $assistlabel ?>], series: [[<?php echo $assists ?>]]};
		new Chartist.Bar('#teamperformance', data, options);
		$("#toggle").text("show closed");
		$('#toggle').removeAttr('onclick');
		$('#toggle').attr('onClick', 'closed();');
		$(".key").hide();
		$(".keyassists").fadeIn();
	}
	function closed() {
		var data = { labels: [<?php echo $label ?>], series: [<?php echo $series ?>]};
		new Chartist.Bar('#teamperformance', data, options);
		$("#toggle").text("show assists");
		$('#toggle').removeAttr('onclick');
		$('#toggle').attr('onClick', 'assists();');
		$(".key").fadeIn();
		$(".keyassists").hide();
	}
	var options = {
		fullWidth: true,
		horizontalBars: true,
		stackBars: true,
		reverseData: true,
		axisY: {
			onlyInteger: true,
			offset: 125,
			},
		axisX: {
			onlyInteger: true,
			}
		};

	$(function() {
	// WAIT FOR DOM
		// Draw Bar chartist.js
		closed();
	});
</script>
<div id="teamperformance" class="ct-chart ct-golden-section" style="width: 100%;height:85%;float:left;"></div>
<div style="float:left;margin-top: -10px;margin-right: 10px;">
	<span style="font-size: 0.7rem;color: #aaa;background: #f0f0ef;padding: 0.1rem 0.5rem;cursor: pointer;" onclick="" id="toggle">toggle</span>
</div>
<div style="float:right;margin-top: -10px;margin-right: 10px;">
	<span style="font-size: 0.7rem;color: #aaa;background: #f0f0ef;padding: 0.1rem 0.5rem;" class="keyassists">assists in last 7 days</span>
  <span style="font-size: 0.7rem;color: white;background: #BFCC80;padding: 0.1rem 0.5rem;" class="key"><?php echo(date("j M",strtotime("-6 day")));?></span>
  <span style="font-size: 0.7rem;color: white;background: #FFA38B;padding: 0.1rem 0.5rem;" class="key"><?php echo(date("j M",strtotime("-5 day")));?></span>
  <span style="font-size: 0.7rem;color: white;background: #FDD26E;padding: 0.1rem 0.5rem;" class="key"><?php echo(date("j M",strtotime("-4 day")));?></span>
  <span style="font-size: 0.7rem;color: white;background: #C09C83;padding: 0.1rem 0.5rem;" class="key"><?php echo(date("j M",strtotime("-3 day")));?></span>
  <span style="font-size: 0.7rem;color: white;background: #B8CCEA;padding: 0.1rem 0.5rem;" class="key"><?php echo(date("j M",strtotime("-2 day")));?></span>
  <span style="font-size: 0.7rem;color: white;background: #BFCEC2;padding: 0.1rem 0.5rem;" class="key"><?php echo(date("j M",strtotime("-1 day")));?></span>
  <span style="font-size: 0.7rem;color: white;background: #D1CCBD;padding: 0.1rem 0.5rem;" class="key"><?php echo(date("j M",strtotime("0 day")));?></span>
</div>
