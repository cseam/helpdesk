<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
	<?php
	// load functions
	include 'includes/functions.php';	
	// sql
	
	$sqlstr = "SELECT closeengineerid, DATE_FORMAT(closed, '%a')AS DAY_OF_WEEK FROM calls WHERE closeengineerid = '".$_SESSION['engineerId']."' AND closed >= DATE_SUB(CURDATE(),INTERVAL 7 DAY)"; 
		$engineermon = 0;
		$engineertue = 0;
		$engineerwed = 0;
		$engineerthu = 0;
		$engineerfri = 0;
		$engineersat = 0;
		$engineersun = 0;
		
	// Run Query
		$resultengineer = mysqli_query($db, $sqlstr); 
		while($stats = mysqli_fetch_array($resultengineer))  { 	
			if ($stats['DAY_OF_WEEK'] == "Mon") { ++$engineermon; };
			if ($stats['DAY_OF_WEEK'] == "Tue") { ++$engineertue; };
			if ($stats['DAY_OF_WEEK'] == "Wed") { ++$engineerwed; };
			if ($stats['DAY_OF_WEEK'] == "Thu") { ++$engineerthu; };
			if ($stats['DAY_OF_WEEK'] == "Fri") { ++$engineerfri; };
			if ($stats['DAY_OF_WEEK'] == "Sat") { ++$engineersat; };
			if ($stats['DAY_OF_WEEK'] == "Sun") { ++$engineersun; };
		}

	$sqlstrall = "SELECT closeengineerid, DATE_FORMAT(closed, '%a') AS DAY_OF_WEEK FROM calls WHERE closed >= DATE_SUB(CURDATE(),INTERVAL 7 DAY)"; 

		$allmon = 0;
		$alltue = 0;
		$allwed = 0;
		$allthu = 0;
		$allfri = 0;
		$allsat = 0;
		$allsun = 0;

		$resultall = mysqli_query($db, $sqlstrall); 
		while($stats = mysqli_fetch_array($resultall))  { 
		
			
			if ($stats['DAY_OF_WEEK'] == "Mon") { ++$allmon; };
			if ($stats['DAY_OF_WEEK'] == "Tue") { ++$alltue; };
			if ($stats['DAY_OF_WEEK'] == "Wed") { ++$allwed; };
			if ($stats['DAY_OF_WEEK'] == "Thu") { ++$allthu; };
			if ($stats['DAY_OF_WEEK'] == "Fri") { ++$allfri; };
			if ($stats['DAY_OF_WEEK'] == "Sat") { ++$allsat; };
			if ($stats['DAY_OF_WEEK'] == "Sun") { ++$allsun; };
		}

	
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
          ['Day', 'All', 'Me'],
          ['Sun',  <?=$allsun?>,      <?=$engineersun?>],
          ['Mon',  <?=$allmon?>,      <?=$engineermon?>],
          ['Tue',  <?=$alltue?>,      <?=$engineertue?>],
          ['Wed',  <?=$allwed?>,      <?=$engineerwed?>],
          ['Thu',  <?=$allthu?>,      <?=$engineerthu?>],
          ['Fri',  <?=$allfri?>,      <?=$engineerfri?>],
          ['Sat',  <?=$allsat?>,      <?=$engineersat?>]
        ]);

        var options = {
          title: '',
          legend: { position: 'right' },
          colors: ['#577d6a','#CCCCCC'],
          pointSize: 4,
          vAxis: {gridlines: { count: 4 },},
          chartArea: {'width': 'auto', 'height': '70%',},
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