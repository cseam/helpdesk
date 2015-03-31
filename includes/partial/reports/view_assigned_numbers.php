<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<h2>Assigned Numbers</h2>
<p>Opened and assigned tickets not yet closed</p>
<table>
<tr>
	<th>Engineer Name</th>
	<th>Assigned</th>
</tr>
<?php
	if ($_SESSION['engineerHelpdesk'] <= '3') {
		$STH = $DBH->Prepare("SELECT engineerName, Count(assigned) AS HowManyAssigned, sum(case when status=1 THEN 1 ELSE 0 END) AS OpenOnes FROM calls INNER JOIN engineers ON calls.assigned=engineers.idengineers WHERE engineers.helpdesk <= :helpdeskid GROUP BY assigned order by OpenOnes DESC");
		$hdid = 3;
	} else {
		$STH = $DBH->Prepare("SELECT engineerName, Count(assigned) AS HowManyAssigned, sum(case when status=1 THEN 1 ELSE 0 END) AS OpenOnes FROM calls INNER JOIN engineers ON calls.assigned=engineers.idengineers WHERE engineers.helpdesk = :helpdeskid GROUP BY assigned order by OpenOnes DESC");
		$hdid = $_SESSION['engineerHelpdesk'];
	}
	$STH->bindParam(":helpdeskid", $hdid, PDO::PARAM_STR);
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	while($row = $STH->fetch()) {
?>
		<tr>
			<td><?=$row->engineerName;?></td>
			<td><?=$row->OpenOnes;?></td>
		</tr>
		<? } ?>
</table>
