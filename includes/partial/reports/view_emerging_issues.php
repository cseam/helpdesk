<h2>Emerging Issues</h2>
<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<p>Issues logged by area in last 7 days, high numbers may indicate a problem in that house, room or location</p>
<table>
<tr>
	<th>Location / Room</th>
	<th>Tickets Logged</th>
</tr>
<?
	if ($_SESSION['engineerHelpdesk'] <= '3') {
		$STH = $DBH->Prepare("SELECT COUNT(*) AS Number_of_Calls,c.location AS Location, l.locationName AS Location_Name FROM calls AS c LEFT JOIN location as l ON c.location = l.id WHERE engineers.helpdesk <= :helpdeskid AND opened >= DATE_SUB(CURDATE(),INTERVAL 7 DAY) AND location != 1 GROUP BY location HAVING COUNT(*)>=3 ORDER BY Number_of_Calls DESC");
		$hdid = 3;
	} else {
		$STH = $DBH->Prepare("SELECT COUNT(*) AS Number_of_Calls,c.location AS Location, l.locationName AS Location_Name FROM calls AS c LEFT JOIN location as l ON c.location = l.id WHERE engineers.helpdesk = :helpdeskid AND opened >= DATE_SUB(CURDATE(),INTERVAL 7 DAY) AND location != 1 GROUP BY location HAVING COUNT(*)>=3 ORDER BY Number_of_Calls DESC");
		$hdid = $_SESSION['engineerHelpdesk'];
	}
	$STH->bindParam(":helpdeskid", $hdid, PDO::PARAM_STR);
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	if ($STH->rowCount() == 0) { echo "<tr><td colspan=2>0 issues detected by locations</td></tr>";};
	while($row = $STH->fetch()) { ?>
<tr>
	<td><?=$row->Location_Name?></td>
	<td><?=$row->Number_of_Calls?></td>
</tr>
<? } ?>
<?
	if ($_SESSION['engineerHelpdesk'] <= '3') {
		$STH = $DBH->Prepare("SELECT COUNT(*) AS Number_of_Calls, room AS Room FROM calls WHERE engineers.helpdesk <= :helpdeskid AND opened >= DATE_SUB(CURDATE(),INTERVAL 7 DAY) GROUP BY room HAVING COUNT(*) >=3 ORDER BY Number_of_Calls DESC");
		$hdid = 3;
	} else {
		$STH = $DBH->Prepare("SELECT COUNT(*) AS Number_of_Calls, room AS Room FROM calls WHERE engineers.helpdesk = :helpdeskid AND opened >= DATE_SUB(CURDATE(),INTERVAL 7 DAY) GROUP BY room HAVING COUNT(*) >=3 ORDER BY Number_of_Calls DESC");
		$hdid = $_SESSION['engineerHelpdesk'];
	}
	$STH->bindParam(":helpdeskid", $hdid, PDO::PARAM_STR);
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	if ($STH->rowCount() == 0) { echo "<tr><td colspan=2>0 issues detected by room</td></tr>";};
	while($row = $STH->fetch()) { ?>
<tr>
	<td><?=$row->Room?></td>
	<td><?=$row->Number_of_Calls?></td>
</tr>
<? } ?>
</table>