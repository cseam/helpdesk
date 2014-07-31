<!DOCTYPE html>
<html lang="en">
	<?php
	// load functions
	include 'includes/functions.php';
	?>
	<head>
		<title><?=$codename;?></title>
		<link rel="shortcut icon" href="clcfavicon.ico" type="image/x-icon" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" /> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="robots" content="nofollow" />
		<link rel="stylesheet" type="text/css" href="css/reset.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		
		<!--Google Graphs-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Calls', 'Number'],
          ['Closed (this week)',     11],
          ['Your calls still open',      2]
        ]);

        var options = {
          title: '',
          pieHole: 0.5,
          colors: ['#577d6a','#CCCCCC'],
          pieSliceText: 'none',
          legend: 'none',
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
      }
      google.setOnLoadCallback(drawChart2);
      function drawChart2() {
        var data = google.visualization.arrayToDataTable([
          ['Day', 'All', 'Your'],
          ['Sun',  14,      0],
          ['Mon',  88,      14],
          ['Tue',  70,      22],
          ['Wed',  66,       11],
          ['Thu',  108,      26],
          ['Fri',  92,      14],
          ['Sat',  24,      0]
        ]);

        var options = {
          title: '',
          legend: { position: 'right' },
          colors: ['#577d6a','#CCCCCC'],
          pointSize: 4,
          vAxis: {gridlines: { count: 3 },textPosition: 'none'},
          chartArea: {'width': 'auto', 'height': '70%', 'left' : 0,},
        };

        var chart = new google.visualization.LineChart(document.getElementById('linechart'));
        chart.draw(data, options);
        }
    </script>
		
		
		
	</head>
	<body>
	<div class="section">
	<h2>Graphs</h2>
	<h3>Performance</h3>
	<div id="piechart" style="width: 20%; float: left; -webkit-box-sizing: border-box;"></div>
	<div id="linechart" style="width: 40%; float: left; -webkit-box-sizing: border-box;"></div>
	<ul style="clear: left;">
		<li><a href="index.php"><?=$codename;?> Home</a></li>
	</ul>	
	</div>

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js" type="text/javascript"></script>	
	<script src="javascript/jquery.js" type="text/javascript"></script>
	</body>
</html>