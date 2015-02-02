<?php session_start();?>
<? //check auth level
	if ($_SESSION['superuser'] !== "1" and $_SESSION['engineerLevel'] !== '2') { die("<script>location.href = '/index.php'</script>"); };?>
<!DOCTYPE html>
<html lang="en">
	<?php
	// load functions
	include_once('includes/functions.php');
	include_once('includes/reportfunctions.php');
	// check authentication
	if (empty($_SESSION['sAMAccountName'])) { prompt_auth($_SERVER['REQUEST_URI']); };
	?>
	<head>
		<?php include_once 'includes/header.php'; ?>
		<meta http-equiv="refresh" content="600" />
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
		 if ($_SESSION['engineerHelpdesk'] <= '3') {
			$whereenginners = 'WHERE engineers.helpdesk <= 3';
		} else {
			$whereenginners = 'WHERE engineers.helpdesk='.$_SESSION['engineerHelpdesk'];
		};
		$sql ="SELECT engineerName, sum(case when calls.closed >= DATE_SUB(CURDATE(),INTERVAL 7 DAY) THEN 1 ELSE 0 END) AS Last7 FROM engineers LEFT JOIN calls ON calls.closeengineerid = engineers.idengineers " . $whereenginners . " GROUP BY engineerName ORDER BY Last7 DESC;";
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
          ['Opened (24h)', <?=callsinlastday()+0.00000000001?>],
          ['Closed (24h)', <?=callsclosedinlastday()+0.00000000001?>]
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
		<?php

			// minutes in array
			$call_time =  array(2 , 10, 150, 10, 66, 89);
			$average_call_time = array_sum($call_time) / count($call_time) * 60;
			$d = ($average_call_time/(60*60*24))%365;
			$h = ($average_call_time/(60*60))%24;
			$m = ($average_call_time/60)%60;
			//echo "<p>Average call duration " . $d ." days, ".$h." hours, ".$m." minutes.</p>";
		?>



	</div>
	<div id="calllist">
		<div id="ajaxforms">

		<form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="reportlist">
		<button type="submit" value="View" name="btn" id="btn" class="reportname">View Open Calls</button>
		<input type="hidden" id="report" name="report" value="0" />
		<input type="image" id="btn" name="btn" value="View" src="/images/ICONS-view@2x.png" width="24" height="25" class="icon" alt="View Open Calls" title="View Open Calls" />
		</form>
		<form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="reportlist">
		<button type="submit" value="View" name="btn" id="btn" class="reportname">View All Calls</button>
		<input type="hidden" id="report" name="report" value="1" />
		<input type="image" id="btn" name="btn" value="View" src="/images/ICONS-allcalls@2x.png" width="24" height="25" class="icon" alt="View All Calls" title="View All Calls" />
		</form>
		<form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="reportlist">
		<button type="submit" value="View" name="btn" id="btn" class="reportname">View Oldest Call</button>
		<input type="hidden" id="report" name="report" value="2" />
		<input type="image" id="btn" name="btn" value="View" src="/images/ICONS-oldestcall@2x.png" width="24" height="25" class="icon" alt="View Oldest Call" title="View Oldest Call" />
		</form>
		<form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="reportlist">
		<button type="submit" value="View" name="btn" id="btn" class="reportname">Calls Assigned #</button>
		<input type="hidden" id="report" name="report" value="3" />
		<input type="image" id="btn" name="btn" value="View" src="/images/ICONS-assignnotclosed@2x.png" width="24" height="25" class="icon" alt="Calls Assigned" title="Calls Assigned"/>
		</form>
			<form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="reportlist">
		<button type="submit" value="View" name="btn" id="btn" class="reportname">Engineer Work Rate</button>
		<input type="hidden" id="report" name="report" value="4" />
		<input type="image" id="btn" name="btn" value="View" src="/images/ICONS-workrate@2x.png" width="24" height="25" class="icon" alt="Engineer Work Rate" title="Engineer Work Rate"/>
		</form>
		<form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="reportlist">
		<button type="submit" value="View" name="btn" id="btn" class="reportname">User Feedback</button>
		<input type="hidden" id="report" name="report" value="5" />
		<input type="image" id="btn" name="btn" value="View" src="/images/ICONS-userfeedback@2x.png" width="24" height="25" class="icon" alt="User Feedback" title="User Feedback"/>
		</form>
		<form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="reportlist">
		<button type="submit" value="View" name="btn" id="btn" class="reportname">Punchcard in/out</button>
		<input type="hidden" id="report" name="report" value="6" />
		<input type="image" id="btn" name="btn" value="View" src="/images/ICONS-punchcard@2x.png" width="24" height="25" class="icon" alt="Punch Card" title="Punch Card" />
		</form>
		<form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="reportlist">
		<button type="submit" value="View" name="btn" id="btn" class="reportname">Emerging Issues</button>
		<input type="hidden" id="report" name="report" value="7" />
		<input type="image" id="btn" name="btn" value="View" src="/images/ICONS-issues@2x.png" width="24" height="25" class="icon" alt="Emerging Issues" title="Emerging Issues"/>
		</form>
		<form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="reportlist">
		<button type="submit" value="View" name="btn" id="btn" class="reportname">Search Calls</button>
		<input type="hidden" id="report" name="report" value="8" />
		<input type="image" id="btn" name="btn" value="View" src="/images/ICONS-search@2x.png" width="24" height="25" class="icon" alt="Search Calls" title="Search Calls"/>
		</form>
		<form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="reportlist">
		<button type="submit" value="View" name="btn" id="btn" class="reportname">Scheduled Tasks</button>
		<input type="hidden" id="report" name="report" value="9" />
		<input type="image" id="btn" name="btn" value="View" src="/images/ICONS-scheduledtask@2x.png" width="24" height="24" class="icon" alt="Scheduled Tasks" title="Scheduled Tasks"/>
		</form>
		<form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="reportlist">
		<button type="submit" value="View" name="btn" id="btn" class="reportname">Add Change Control</button>
		<input type="hidden" id="report" name="report" value="10" />
		<input type="image" id="btn" name="btn" value="View" src="/images/ICONS-addchangecontrol@2x.png" width="24" height="25" class="icon" alt="Add Change Control" title="Add Change Control"/>
		</form>
		<form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="reportlist">
		<button type="submit" value="View" name="btn" id="btn" class="reportname">View Change History</button>
		<input type="hidden" id="report" name="report" value="11" />
		<input type="image" id="btn" name="btn" value="View" src="/images/ICONS-changecontrol@2x.png" width="24" height="25" class="icon" alt="View Change Control" title="View Change Control"/>
		</form>
		<form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="reportlist">
		<button type="submit" value="View" name="btn" id="btn" class="reportname">Tag Control</button>
		<input type="hidden" id="report" name="report" value="12" />
		<input type="image" id="btn" name="btn" value="View" src="/images/ICONS-tag@2x.png" width="24" height="25" class="icon" alt="Tag Control" title="Tag Control"/>
		</form>
		<form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="reportlist">
		<button type="submit" value="View" name="btn" id="btn" class="reportname">Awaiting Invoice</button>
		<input type="hidden" id="report" name="report" value="13" />
		<input type="image" id="btn" name="btn" value="View" src="/images/ICONS-invoice@2x.png" width="24" height="25" class="icon" alt="Awaiting Invoice" title="Awaiting Invoice"/>
		</form>
		<form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="reportlist">
		<button type="submit" value="View" name="btn" id="btn" class="reportname">IT Reception Screen</button>
		<input type="hidden" id="report" name="report" value="14" />
		<input type="image" id="btn" name="btn" value="View" src="/images/ICONS-digitalscreen@2x.png" width="24" height="25" class="icon" alt="IT Screen" title="IT Screen"/>
		</form>
		<form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="reportlist">
		<button type="submit" value="View" name="btn" id="btn" class="reportname">Reason Behind Issues</button>
		<input type="hidden" id="report" name="report" value="15" />
		<input type="image" id="btn" name="btn" value="View" src="/images/ICONS-reason@2x.png" width="24" height="25" class="icon" alt="Null" title="Null" />
		</form>

		</div>
	</div>
	</div>
	<div id="rightpage">
		<div id="addcall">
			<div id="ajax">
				<?php include('includes/managerreport-default.php'); ?>
			</div>
		</div>
	</div>
	</div>
	<script type="text/javascript">
     $('.reportlist').submit(function(e) {
    	$.ajax(
			{
				type: 'post',
				url: '/includes/managerviewreport.php',
				data: $(this).serialize(),
				beforeSend: function()
				{
				$('#ajax').html('<img src="/images/spinny.gif" alt="loading" class="loading"/>');
    			},
				success: function(data)
				{
				$('#ajax').html(data);
    			},
				error: function()
				{
				$('#ajax').html('error loading data, please refresh.');
    			}
			});
       e.preventDefault();
       return false;
    });
    </script>
	</body>
</html>










