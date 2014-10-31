<?php session_start();?>
<?php
	// load functions
	include_once '../includes/functions.php';
?>
<h3>Assigned Calls Not Yet Closed</h3>
<ul>
          <?php 
		//run select query
		$result = mysqli_query($db, "SELECT engineerName, Count(assigned) AS HowManyAssigned, sum(case when status=1 THEN 1 ELSE 0 END) AS OpenOnes FROM calls INNER JOIN engineers ON calls.assigned=engineers.idengineers GROUP BY assigned order by OpenOnes DESC;");
		while($calls = mysqli_fetch_array($result))  {
		?>
		<li><?=$calls['engineerName'];?> - <?=$calls['OpenOnes'];?></li>	
		<? } ?>
</ul>

