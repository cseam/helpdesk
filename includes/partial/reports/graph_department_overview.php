<h3>Department Performance</h3>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
	google.load("visualization", "1", {packages:["corechart"]});
	google.setOnLoadCallback(drawChart);
	function drawChart() {
		var dataTable = new google.visualization.DataTable();
		dataTable.addColumn('string', 'Calls');
		dataTable.addColumn('number', 'Number');
		dataTable.addColumn({type: 'string', role: 'tooltip'});
		// A column for custom tooltip content
		dataTable.addRows([
		<?php
			if ($_SESSION['engineerHelpdesk'] <= '3') {
				$whereenginners = 'WHERE engineers.helpdesk <= 3';
			} else {
				$whereenginners = 'WHERE engineers.helpdesk='.$_SESSION['engineerHelpdesk'];
			};
			$sql ="SELECT engineerName, sum(case when calls.closed >= DATE_SUB(CURDATE(),INTERVAL 7 DAY) THEN 1 ELSE 0 END) AS Last7 FROM engineers LEFT JOIN calls ON calls.closeengineerid = engineers.idengineers " . $whereenginners . " GROUP BY engineerName ORDER BY Last7 DESC;";
			$result = mysqli_query($db, $sql);
				while($loop = mysqli_fetch_array($result)) {
					echo("['" . $loop ['engineerName'] . "', " . $loop['Last7'] . ", 'Closed ". $loop['Last7'] ." calls in last 7 days',],");
				};
		?>]);
			var options = {
				title: '',
				colors: ['#CCCCCC','#577d6a',],
				legend: 'none',
				chartArea: {left : 75,},
			};
			var chart = new google.visualization.BarChart(document.getElementById('piechart'));
				chart.draw(dataTable, options);
			}
	google.setOnLoadCallback(drawChart2);
	function drawChart2() {
		var data = google.visualization.arrayToDataTable([
			['Tickets', 'Tickets'],
			['Opened (24h)', <?php echo(callsinlastday());?>],
			['Closed (24h)', <?php echo(callsclosedinlastday());?>]
		]);
		var options = {
			title: '',
			legend: { position: 'none' },
			colors: ['#577d6a','#CCCCCC',],
			pieSliceText: 'none',
			pointSize: 4,
			vAxis: {gridlines: { count: 4 },},
			pieHole: 0.5,
			chartArea: {'width': 'auto', 'height': '70%',},
		};
		var chart = new google.visualization.PieChart(document.getElementById('linechart'));
		chart.draw(data, options);
		}
</script>
<div id="piechart" style="width: 40%; float: left;"></div>
<div id="linechart" style="width: 60%; float: left;"></div>