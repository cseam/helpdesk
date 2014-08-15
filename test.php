<?php session_start();?>
<?php
	// load functions
	include_once 'includes/functions.php';
?>
	
	     
         
	
	
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawgoogleChart);
      function drawgoogleChart() {
        var data = google.visualization.arrayToDataTable([
          ['Engineer Name', 'Assigned Calls'],
          <?php 
		//run select query
		$result = mysqli_query($db, "SELECT engineerName, Count(assigned) AS HowMany FROM calls INNER JOIN engineers ON calls.assigned=engineers.idengineers WHERE status='1' GROUP BY assigned order by HowMany;");
		while($calls = mysqli_fetch_array($result))  {
		?>
		['<?=$calls['engineerName'];?>', <?=$calls['HowMany'];?>],
		<? } ?>    
        ]);

        var options = {
          title: '',
          legend: { position: 'right' },
          colors: ['#577d6a','#CCCCCC'],
          pointSize: 4,
          vAxis: {gridlines: { count: 4 },},
          chartArea: {'width': 'auto', 'height': '70%',},
        };

        var chart = new google.visualization.BarChart(document.getElementById('workload'));
        chart.draw(data, options);
        }
    </script>
	<div id="workload" style="width: 100%; float: left;"></div>