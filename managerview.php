<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
	<?php
	// load functions
	include_once('includes/functions.php');
	include_once('includes/reportfunctions.php');
	
	?>
	<head>
		<title><?=$codename;?> - Managers View</title>
		<link rel="shortcut icon" href="clcfavicon.ico" type="image/x-icon" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" /> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="robots" content="nofollow" />
		<link rel="stylesheet" type="text/css" href="css/reset.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
	</head>
	<body>
	<div class="section">
	<div id="branding">
		<?php include 'includes/nav.php'; ?>
	</div>
	
	<div id="leftpage">
	<div id="stats">
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
		$sql ="SELECT engineerName, sum(case when calls.closed >= DATE_SUB(CURDATE(),INTERVAL 7 DAY) THEN 1 ELSE 0 END) AS Last7 FROM engineers LEFT JOIN calls ON calls.closeengineerid = engineers.idengineers GROUP BY engineerName ORDER BY Last7 DESC";
		$result = mysqli_query($db, $sql);
	while($loop = mysqli_fetch_array($result)) {
	echo "['" . $loop ['engineerName'] . "', " . $loop['Last7'] . ", 'Closed ". $loop['Last7'] ." calls in last 7 days',],";		
	}		
	?>
    
     ]);
      
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
          ['Calls', 'Calls'],
          ['Opened (24h)', <?=callsinlastday()?>],
          ['Closed (24h)', <?=callsclosedinlastday()?>]
        ]);

        var options = {
          title: '',
          legend: { position: 'none' },
          colors: ['#CCCCCC','#577d6a',],
          pointSize: 4,
          vAxis: {gridlines: { count: 4 },},
          chartArea: {'width': 'auto', 'height': '70%',},
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('linechart'));
        chart.draw(data, options);
        }
      	</script>
      	<div id="piechart" style="width: 40%; float: left;"></div>
      	<div id="linechart" style="width: 60%; float: left;"></div>
		<?php
		 
			// minutes in array
			$call_time =  array(2 , 10, 150, 10, 66, 89);
			$average_call_time = array_sum($call_time) / count($call_time) * 60; 
			$d = ($average_call_time/(60*60*24))%365;
			$h = ($average_call_time/(60*60))%24;
			$m = ($average_call_time/60)%60;
			echo "<p>Average call duration " . $d ." days, ".$h." hours, ".$m." minutes.</p>";
		?>
		
		
		
	</div>
	<div id="calllist">
		<div id="ajaxforms">
			<table>
				<tbody>
					<tr>
						<td>Open Calls</td>
						<td style="text-align: right;">
							<form method="post">
							<input type="hidden" id="id" name="id" value="0" />
							<button name="submit" value="submit" type="submit" class="calllistbutton">View</button>
							</form>
						</td>
					</tr>
					<tr>
						<td>All Calls</td>
						<td style="text-align: right;">
							<form method="post">
							<input type="hidden" id="id" name="id" value="1" />
							<button name="submit" value="submit" type="submit" class="calllistbutton">View</button>
							</form>
						</td>
					</tr>
					<tr>
						<td>Oldest Call</td>
						<td style="text-align: right;">
							<form method="post">
							<input type="hidden" id="id" name="id" value="2" />
							<button name="submit" value="submit" type="submit" class="calllistbutton">View</button>
							</form>
						</td>
					</tr>
					<!--
					<tr>
						<td>Engineer Workload</td>
						<td style="text-align: right;">
							<form method="post">
							<input type="hidden" id="id" name="id" value="3" />
							<button name="submit" value="submit" type="submit" class="calllistbutton">View</button>
							</form>
						</td>
					</tr>
					-->
					<tr>
						<td>Work Rate</td>
						<td style="text-align: right;">
							<form method="post">
							<input type="hidden" id="id" name="id" value="4" />
							<button name="submit" value="submit" type="submit" class="calllistbutton">View</button>
							</form>
						</td>
					</tr>
					<tr>
						<td>User Feedback</td>
						<td style="text-align: right;">
							<form method="post">
							<input type="hidden" id="id" name="id" value="5" />
							<button name="submit" value="submit" type="submit" class="calllistbutton">View</button>
							</form>
						</td>
					</tr>
					<tr>
						<td>Punchcard In/Out</td>
						<td style="text-align: right;">
							<form method="post">
							<input type="hidden" id="id" name="id" value="6" />
							<button name="submit" value="submit" type="submit" class="calllistbutton">View</button>
							</form>
						</td>
					</tr>
					<tr>
						<td>Emerging Issues</td>
						<td style="text-align: right;">
							<form method="post">
							<input type="hidden" id="id" name="id" value="7" />
							<button name="submit" value="submit" type="submit" class="calllistbutton">View</button>
							</form>
						</td>
					</tr>
			</tbody>
			</table>
		</div>
	</div>
	</div>
	<div id="rightpage">
		<div id="addcall">
			<div id="ajax">
				<?php include('includes/managerdefault.php'); ?>
			</div>
		</div>
	</div>
	</div>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js" type="text/javascript"></script>	
	<script src="javascript/jquery.js" type="text/javascript"></script>
	<script type="text/javascript">
    // Ajax form submit
    $('form').submit(function(e) {
        // Post the form data to viewcall
        $.post('includes/managerviewreport.php', $(this).serialize(), function(resp) {
            // return response data into div
            $('#ajax').html(resp);
        });
        // Cancel the actual form post so the page doesn't refresh
        e.preventDefault();
        return false;
    });     
    </script>
	</body>
</html>









