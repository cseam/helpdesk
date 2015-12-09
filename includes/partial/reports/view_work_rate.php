<?php session_start();?>
<h2>View Work Rate</h2>
<p>All tickets closed in last (X) number of days</p>
<table>
<tr>
	<th>Engineer Name</th>
	<th>30 Days</th>
	<th>7 Days</th>
	<th>24 Hours</th>
</tr>
<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

	if ($_SESSION['engineerHelpdesk'] <= '3') {
		$STH = $DBH->Prepare("SELECT engineerName, sum(case when calls.closed >= DATE_SUB(CURDATE(),INTERVAL 6 DAY) THEN 1 ELSE 0 END) AS Last7 , sum(case when calls.closed >= DATE_SUB(CURDATE(),INTERVAL 1 DAY) THEN 1 ELSE 0 END) AS Last1 , sum(case when calls.closed >= DATE_SUB(CURDATE(),INTERVAL 30 DAY) THEN 1 ELSE 0 END) AS Last30 FROM engineers LEFT JOIN calls ON calls.closeengineerid = engineers.idengineers WHERE engineers.helpdesk <= :helpdeskid GROUP BY engineerName ORDER BY Last30 DESC");
		$hdid = 3;
	} else {
		$STH = $DBH->Prepare("SELECT engineerName, sum(case when calls.closed >= DATE_SUB(CURDATE(),INTERVAL 6 DAY) THEN 1 ELSE 0 END) AS Last7 , sum(case when calls.closed >= DATE_SUB(CURDATE(),INTERVAL 1 DAY) THEN 1 ELSE 0 END) AS Last1 , sum(case when calls.closed >= DATE_SUB(CURDATE(),INTERVAL 30 DAY) THEN 1 ELSE 0 END) AS Last30 FROM engineers LEFT JOIN calls ON calls.closeengineerid = engineers.idengineers WHERE engineers.helpdesk = :helpdeskid GROUP BY engineerName ORDER BY Last30 DESC");
		$hdid = $_SESSION['engineerHelpdesk'];
	}
	$STH->bindParam(":helpdeskid", $hdid, PDO::PARAM_STR);
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	while($row = $STH->fetch()) { ?>

<tr>
	<td><?=$row->engineerName;?></td>
	<td><?=$row->Last30;?></td>
	<td><?=$row->Last7;?></td>
	<td><?=$row->Last1;?></td>
</tr>
<?	} ?>
</table>
<p>Average time engineer takes to close tickets in last 30 days, including out of hours</p>
<table>
<tr>
	<th>Engineer Name</th>
	<th>Avg H:M:S</th>
</tr>
<?php
	if ($_SESSION['engineerHelpdesk'] <= '3') {
		$STH = $DBH->Prepare("
		SELECT engineerName, callid, opened, closed,  SEC_TO_TIME(AVG(TIME_TO_SEC(TIMEDIFF(closed,opened)))) AS avgtimetoclose
		FROM engineers 
		LEFT JOIN calls ON calls.closeengineerid = engineers.idengineers 
		WHERE engineers.helpdesk <= :helpdeskid 
		AND calls.opened != calls.closed
		AND calls.status = 2
		AND calls.closed >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)  
		GROUP BY engineerName
		ORDER BY callid DESC");
		$hdid = 3;
	} else {
		$STH = $DBH->Prepare("
		SELECT engineerName, callid, opened, closed,  SEC_TO_TIME(AVG(TIME_TO_SEC(TIMEDIFF(closed,opened)))) AS avgtimetoclose
		FROM engineers 
		LEFT JOIN calls ON calls.closeengineerid = engineers.idengineers 
		WHERE engineers.helpdesk = :helpdeskid 
		AND calls.opened != calls.closed
		AND calls.status = 2
		AND calls.closed >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
		GROUP BY engineerName
		ORDER BY callid DESC");
		$hdid = $_SESSION['engineerHelpdesk'];		
	}
	
	$STH->bindParam(":helpdeskid", $hdid, PDO::PARAM_STR);
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	while($row = $STH->fetch()) {
?>		
<tr>
	<td><?=$row->engineerName;?></td>
	<td><?=$row->avgtimetoclose;?></td>
	<td><?php 
		
	?></td>
</tr>
<?php } ?>
</table>
