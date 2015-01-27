<h3>Emerging Issues</h3>
<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<table>
<tr>
	<th>Location / Room</th>
	<th>Calls Logged</th>
</tr>
<?
	$issuescount = 0;
	$sql ="SELECT COUNT(*) AS Number_of_Calls,c.location AS Location, l.locationName AS Location_Name FROM calls AS c LEFT JOIN location as l ON c.location = l.id WHERE engineers.helpdesk <= 3 AND opened >= DATE_SUB(CURDATE(),INTERVAL 7 DAY) AND location != 1 GROUP BY location HAVING COUNT(*)>=3 ORDER BY Number_of_Calls DESC";
	$result = mysqli_query($db, $sql);
		while($loop = mysqli_fetch_array($result)) { ?>
<tr>
	<td><?=$loop['Location_Name']?></td>
	<td><?=$loop['Number_of_Calls']?></td>
</tr>
<? } ?>
<?
	$sql ="SELECT COUNT(*) AS Number_of_Calls, room AS Room FROM calls WHERE engineers.helpdesk <= 3 AND opened >= DATE_SUB(CURDATE(),INTERVAL 7 DAY) GROUP BY room HAVING COUNT(*) >=3 ORDER BY Number_of_Calls DESC";
	$result = mysqli_query($db, $sql);
		while($loop = mysqli_fetch_array($result)) { ?>
<tr>
	<td><?=$loop['Room']?></td>
	<td><?=$loop['Number_of_Calls']?></td>
</tr>
<? } ?>

<? 
	if ($issuescount === 0) { echo "<tr><td colspan=2>None Detected</td></tr>"; };
?>
</table>