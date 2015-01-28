<?php session_start();?>
<?php
	// load functions
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<table>
	<thead>
		<tr>
			<th>Who</th>
			<th>When</th>
			<th>Where</th>
			<th>Description</th>
			<th>Tags</th>
		</tr>
	</thead>
	<tbody>
<?
$sqlstr = mysqli_query($db, "SELECT * FROM changecontrol INNER JOIN engineers ON changecontrol.engineersid=engineers.idengineers ;");
				while($results = mysqli_fetch_array($sqlstr)) {
						echo "<tr>";
						echo "<td>" . $results['engineerName'] . "</td>";
						echo "<td>" . date("d/m h:s", strtotime($results['stamp'])) . "</td>";
						echo "<td>" . $results['server'] . "</td>";
						echo "<td>" . $results['changemade'] . "</td>";
						echo "<td>" . $results['tags'] . "</td>";
						echo "</tr>";
};
?>
	</tbody>
</table>