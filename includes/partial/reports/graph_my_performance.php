<h3>Your Performance</h3>
<?php
	session_start();
	// load functions
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

	// Get all calls engineer closed by day
	$STH = $DBH->Prepare("SELECT closeengineerid, DATE_FORMAT(closed, '%a')AS DAY_OF_WEEK FROM calls WHERE closeengineerid = :closeid AND closed >= DATE_SUB(CURDATE(),INTERVAL 7 DAY)");
	$STH->bindParam(":closeid", $_SESSION['engineerId'], PDO::PARAM_INT);
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	$engineermon = $engineertue = $engineerwed = $engineerthu = $engineerfri = $engineersat = $engineersun = 0;
	while($row = $STH->fetch()) {
			SWITCH ($row->DAY_OF_WEEK) {
				CASE "Mon":
					++$engineermon;
					break;
				CASE "Tue":
					++$engineertue;
					break;
				CASE "Wed":
					++$engineerwed;
					break;
				CASE "Thu":
					++$engineerthu;
					break;
				CASE "Fri":
					++$engineerfri;
					break;
				CASE "Sat":
					++$engineersat;
					break;
				CASE "Sun":
					++$engineersun;
					break;
			}
		}

	// Get all calls closed for line chart
	$STH = $DBH->Prepare("SELECT closeengineerid, DATE_FORMAT(closed, '%a') AS DAY_OF_WEEK FROM calls WHERE closed >= DATE_SUB(CURDATE(),INTERVAL 7 DAY)");
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	$allmon = $alltue = $allwed = $allthu = $allfri = $allsat = $allsun = 0;
	while($row = $STH->fetch()) {
			SWITCH ($row->DAY_OF_WEEK) {
				CASE "Mon":
					++$allmon;
					break;
				CASE "Tue":
					++$alltue;
					break;
				CASE "Wed":
					++$allwed;
					break;
				CASE "Thu":
					++$allthu;
					break;
				CASE "Fri":
					++$allfri;
					break;
				CASE "Sat":
					++$allsat;
					break;
				CASE "Sun":
					++$allsun;
					break;
			}
		}

	// Get all calls closed by engineer this week for pie
	$STH = $DBH->Prepare("SELECT closeengineerid FROM calls WHERE closed >= DATE_SUB(CURDATE(),INTERVAL 7 DAY) AND closeengineerid = :closeid");
	$STH->bindParam(":closeid", $_SESSION['engineerId'], PDO::PARAM_INT);
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	$allpie = 0;
	while($row = $STH->fetch()) {
		++$allpie;
	}
	// Get all open calls by engineer
	$STH = $DBH->Prepare("SELECT assigned FROM calls WHERE status = '1' AND assigned = :closeid");
	$STH->bindParam(":closeid", $_SESSION['engineerId'], PDO::PARAM_INT);
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	$allopen = 0;
	while($row = $STH->fetch()) {
		++$allopen;
	}
?>
<style>
	.ct-series-b path {
		stroke: #ccc !important;
	}
	.ct-series-a path {
		stroke: #577d6a !important;
	}
	.ct-line {
		stroke-width: 2px !important;
	}
	.ct-series-b .ct-point  {
		stroke: #ccc !important;
		stroke-width: 5px !important;
	}
	.ct-series-a .ct-point  {
		stroke: #577d6a !important;
		stroke-width: 5px !important;
	}
</style>
<script type="text/javascript">
	$(function() {
	// WAIT FOR DOM

	// Draw Bar chartist.js
	var data = {
		labels: ['Su','Mo','Tu','We','Th','Fr','Sa'],
		series: [
				[<?=$engineersun?>,<?=$engineermon?>,<?=$engineertue?>,<?=$engineerwed?>,<?=$engineerthu?>,<?=$engineerfri?>,<?=$engineersat?>],
				[<?=$allsun?>,<?=$allmon?>,<?=$alltue?>,<?=$allwed?>,<?=$allthu?>,<?=$allfri?>,<?=$allsat?>]
			]
		};
	var options = {
		showPoint: true,
		lineSmooth: false,
		fullWidth: true,
		chartPadding: { right: 20, left: 10, bottom: 10 },
		axisX: {
			showGrid: false
		},
		axisY: {
			showLabel: false
		}
		};

	var chart = new Chartist.Line('#weekstats', data, options);

	chart.on('draw', function(data) {
		if(data.type === 'line' || data.type === 'area') {
			data.element.animate({
				d: {
				begin: 2000 * data.index,
				dur: 2000,
				from: data.path.clone().scale(1, 0).translate(0, data.chartRect.height()).stringify(),
				to: data.path.clone().stringify(),
				easing: Chartist.Svg.Easing.easeOutQuint
				}
			});
		}
	});

	// Draw Pie chartist.js
	var pieData = {
		series: [<?=$allopen?>,<?=$allpie?>]
		};

	var pieOptions = {
		chartPadding: {top: 20, right:5, bottom:5, left:5},
		donut: true,
		showLabel: false,
		donutWidth: 20
	};

	new Chartist.Pie('#myperformance', pieData, pieOptions);
	//END DOM READY
	});
</script>
<div id="myperformance" class="ct-chart ct-perfect-fourth" style="width:40%; float: left;"></div>
<div id="weekstats" class="ct-chart ct-golden-section" style="width: 60%;float:left;"></div>