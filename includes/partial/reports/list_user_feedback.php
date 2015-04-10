<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<h2>Feedback</h2>
<table>
	<tr>
		<th>Engineer Name</th>
		<th>Average Feedback Score</th>
		<th>Total Feedback Number</th>
	</tr>
<?php
	if ($_SESSION['engineerHelpdesk'] <= '3') {
		$STH = $DBH->Prepare("SELECT engineerName, AVG(feedback.satisfaction) as FeedbackAVG, COUNT(calls.callid) as FeedbackCOUNT FROM calls INNER JOIN feedback ON feedback.callid=calls.callid INNER JOIN engineers ON engineers.idengineers=calls.closeengineerid WHERE engineers.helpdesk <= :helpdeskid GROUP BY calls.closeengineerid");
		$hdid = 3;
	} else {
		$STH = $DBH->Prepare("SELECT engineerName, AVG(feedback.satisfaction) as FeedbackAVG, COUNT(calls.callid) as FeedbackCOUNT FROM calls INNER JOIN feedback ON feedback.callid=calls.callid INNER JOIN engineers ON engineers.idengineers=calls.closeengineerid WHERE engineers.helpdesk = :helpdeskid GROUP BY calls.closeengineerid");
		$hdid = $_SESSION['engineerHelpdesk'];
	}
	$STH->bindParam(":helpdeskid", $hdid, PDO::PARAM_STR);
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	if ($STH->rowCount() == 0) { echo "<tr><td colspan=3>0 feedback logged</td></tr>";};
	while($row = $STH->fetch()) { ?>
		<tr>
			<td><?=$row->engineerName;?></td>
			<td><? for ($i = 0; $i < round($row->FeedbackAVG); $i++) { echo("<img src='/public/images/ICONS-star.png' alt='star' height='60' width='auto' />"); }; ?></td>
			<td><?=$row->FeedbackCOUNT;?></td>
		</tr>
<?};?>
</table>
<br/><br/>
<h3>Feedback Details</h3>
<table>
<tr>
	<th>Ticket Id</th>
	<th>Satisfaction</th>
	<th>Customer Feedback</th>
</tr>
<?
	$STH = $DBH->Prepare("SELECT *, sum(case when opened >= DATE_SUB(CURDATE(),INTERVAL 1 DAY) THEN 1 ELSE 0 END) AS New FROM feedback  GROUP BY callid ORDER BY id DESC");
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	if ($STH->rowCount() == 0) { echo "<tr><td colspan=3>0 feedback details</td></tr>";};
	while($row = $STH->fetch()) { ?>
<tr>
	<td><a href="/viewcall.php?id=<?=$row->callid?>"><?=$row-callid?></a></td>
	<td><? for ($i = 0; $i < round($row->satisfaction); $i++) { echo("<img src='/public/images/ICONS-star.png' alt='star' height='60' width='auto' />"); }; ?></td>
	<td><?=substr(strtolower(strip_tags($row->details)), 0, 40);?>...</td>
</tr>
<? } ?>
</table>
