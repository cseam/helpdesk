<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
	<?php
	// load functions
	include_once 'includes/functions.php';	
	
	// Get engineer calls closed for line chart
	$sqlstr = "SELECT closeengineerid, DATE_FORMAT(closed, '%a')AS DAY_OF_WEEK FROM calls WHERE closeengineerid = '".$_SESSION['engineerId']."' AND closed >= DATE_SUB(CURDATE(),INTERVAL 7 DAY)"; 
	$engineermon = $engineertue = $engineerwed = $engineerthu = $engineerfri = $engineersat = $engineersun = 0;	
	$resultengineer = mysqli_query($db, $sqlstr); 
		while($stats = mysqli_fetch_array($resultengineer))  { 	
			SWITCH ($stats['DAY_OF_WEEK']) {
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
	$sqlstrall = "SELECT closeengineerid, DATE_FORMAT(closed, '%a') AS DAY_OF_WEEK FROM calls WHERE closed >= DATE_SUB(CURDATE(),INTERVAL 7 DAY)"; 
	$allmon = $alltue = $allwed = $allthu = $allfri = $allsat = $allsun = 0;
	$resultall = mysqli_query($db, $sqlstrall); 
		while($stats = mysqli_fetch_array($resultall))  { 
			SWITCH ($stats['DAY_OF_WEEK']) {
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
	$sqlstrpieall = "SELECT closeengineerid FROM calls WHERE closed >= DATE_SUB(CURDATE(),INTERVAL 7 DAY) AND closeengineerid = '".$_SESSION['engineerId']."'";
	$allpie = 0;
	$resultpieall = mysqli_query($db, $sqlstrpieall); 
		while($stats = mysqli_fetch_array($resultpieall))  {
			++$allpie;	
		}
	// Get all open calls by engineer 
	$sqlstrpieopen = "SELECT assigned FROM calls WHERE status = '1' AND assigned = '".$_SESSION['engineerId']."'";
	$allopen = 0;
	$resultpieopen = mysqli_query($db, $sqlstrpieopen); 
		while($stats = mysqli_fetch_array($resultpieopen))  {
			++$allopen;
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
          ['Closed (this week)',     <?=$allpie?>],
          ['Your calls still open',      <?=$allopen?>]
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
	<h3>Your Performance</h3>
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