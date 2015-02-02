<?php session_start();?>
<?php
	// load functions
	include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<h3 class="indent">Oldest Open Calls</h3>
<div id="ajaxforms">
	<table>
	<thead>
		<tr>
			<th>Age</th>
			<th>Assigned</th>
			<th>Snapshot</th>
		</tr>
	</thead>		
	<tbody>
	<?php
		//run select query
		$result = mysqli_query($db, "SELECT * FROM calls INNER JOIN engineers ON calls.assigned=engineers.idengineers INNER JOIN status ON calls.status=status.id WHERE engineers.helpdesk <= 3 AND status='1' ORDER BY callID;");
		if (mysqli_num_rows($result) == 0) { echo "<tr><td colspan='3'>0 Open Calls</td></tr>";};
		while($calls = mysqli_fetch_array($result))  {
		?>
		<tr>
		<td width="45">
		<?php
		$datetime1 = new DateTime(date("Y-m-d", strtotime($calls['opened'])));
		$datetime2 = new DateTime(date("Y-m-d"));
		$interval = date_diff($datetime1, $datetime2);
		echo $interval->format('%a days');
		?>
		</td>
		<td>
			<?=$calls['engineerName'];?>
		</td>
		<td>
			<?=substr(strip_tags($calls['details']), 0, 300);?>...
		</td>
		</tr>
	<? } ?>
	</tbody>
	</table>
</div>