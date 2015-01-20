<?php session_start();?>
<?php
	// load functions
	include_once '../includes/functions.php';
?>
<p>Opened and assigned calls not yet closed</p>
<table>
<tr>
	<th>Engineer Name</th>
	<th>Assigned</th>
</tr>
<?php
		//only my helpdesks
		if ($_SESSION['engineerHelpdesk'] <= '3') {
			$whereenginners = 'WHERE engineers.helpdesk <= 3';
		} else {
			$whereenginners = 'WHERE engineers.helpdesk='.$_SESSION['engineerHelpdesk'];
		};
		//run select query
		$result = mysqli_query($db, "SELECT engineerName, Count(assigned) AS HowManyAssigned, sum(case when status=1 THEN 1 ELSE 0 END) AS OpenOnes FROM calls INNER JOIN engineers ON calls.assigned=engineers.idengineers ".$whereenginners." GROUP BY assigned order by OpenOnes DESC;");
		while($calls = mysqli_fetch_array($result))  {
		?>
		<tr>
			<td><?=$calls['engineerName'];?></td>
			<td><?=$calls['OpenOnes'];?></td>
		</tr>
		<? } ?>
</table>
