<?php session_start();?>
<?php
	// load functions
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<p>Chart showing option engineer has set when call has been closed in last 30 days</p>
	<?php
		// filter helpdesks 
		 if ($_SESSION['engineerHelpdesk'] <= '3') {
			$whereenginners = 'WHERE calls.helpdesk <= 3';
		} else {
			$whereenginners = 'WHERE calls.helpdesk='.$_SESSION['engineerHelpdesk'];
		};
		// count reason in last 3 days
		$sql ="SELECT callreasons.reason_name, count(*) AS last7 FROM calls INNER JOIN callreasons ON calls.callreason = callreasons.id ". $whereenginners ." AND calls.status = '2' AND calls.closed >= DATE_SUB(CURDATE(),INTERVAL 30 DAY) GROUP BY callreasons.reason_name;";
		$result = mysqli_query($db, $sql);
			while($loop = mysqli_fetch_array($result)) {
			// setup labels 
				$lables .=  "'".$loop ['reason_name']. ":" . $loop['last7'] . "' ,";
			// series
				$series .= $loop ['last7'] . ",";
			}
	?>
	<script type="text/javascript">
    var data = { 
	    				labels: [<?=$lables?>] ,
	    				series: [<?=$series ?>]
	    			 };
	new Chartist.Pie('.ct-chart', data);
  	</script>
  	<style>
	  	.ct-series-a path { fill: #aaa !important; }
	  	.ct-series-b path { fill: #577d6a !important; }
	  	.ct-series-c path { fill: #ccc !important; }
	  	.ct-series-d path { fill: #577d6a !important; }
	  	.ct-series-e path { fill: #aaa !important; }
	  	.ct-series-f path  { fill: #577d6a !important; }
	  	.ct-series-g path { fill: #ccc !important; }
	  	.ct-series-h path { fill: #577d6a !important; }
	</style>
	<div class="ct-chart ct-perfect-fourth"></div>