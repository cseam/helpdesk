<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<table>
	<tr>
		<th>Engineer Name</th>
		<th>Adverage Feedback Score</th>
		<th>Total Feedback Number</th>
	</tr>
<?
	if ($_SESSION['engineerHelpdesk'] <= '3') {
			$whereenginners = 'WHERE engineers.helpdesk <= 3';
		} else {
			$whereenginners = 'WHERE engineers.helpdesk=' .$_SESSION['engineerHelpdesk'];
	};



	$sqlstr = "SELECT engineerName, AVG(feedback.satisfaction) as FeedbackAVG, COUNT(calls.callid) as FeedbackCOUNT FROM calls INNER JOIN feedback ON feedback.callid=calls.callid INNER JOIN engineers ON engineers.idengineers=calls.closeengineerid ".$whereenginners." GROUP BY calls.closeengineerid;";
	$result = mysqli_query($db, $sqlstr);
		while($loop = mysqli_fetch_array($result)) { ?>
		<tr>
			<td><?=$loop['engineerName'];?></td>
			<td>
			<? if ($loop['FeedbackAVG'] == 1) { echo "<img src='/images/star.png' alt='star' height='17' width='auto' />"; };?>
		<? if ($loop['FeedbackAVG'] == 2) { echo "<img src='/images/star.png' alt='star' height='17' width='auto' /><img src='/images/star.png' alt='star' height='17' width='auto' />"; };?>
		<? if ($loop['FeedbackAVG'] == 3) { echo "<img src='/images/star.png' alt='star' height='17' width='auto' /><img src='/images/star.png' alt='star' height='17' width='auto' /><img src='/images/star.png' alt='star' height='17' width='auto' />"; };?>
		<? if ($loop['FeedbackAVG'] == 4) { echo "<img src='/images/star.png' alt='star' height='17' width='auto' /><img src='/images/star.png' alt='star' height='17' width='auto' /><img src='/images/star.png' alt='star' height='17' width='auto' /><img src='/images/star.png' alt='star' height='17' width='auto' />"; };?>
		<? if ($loop['FeedbackAVG'] == 5) { echo "<img src='/images/star.png' alt='star' height='17' width='auto' /><img src='/images/star.png' alt='star' height='17' width='auto' /><img src='/images/star.png' alt='star' height='17' width='auto' /><img src='/images/star.png' alt='star' height='17' width='auto' /><img src='/images/star.png' alt='star' height='17' width='auto' />"; };?>
			</td>
			<td><?=$loop['FeedbackCOUNT'];?>	</td>
		</tr>
<?};?>
</table>
<br/><br/>
<h2>Feedback Details</h2>
<table>
<tr>
	<th>Call Id</th>
	<th>Satisfaction</th>
	<th>Customer Feedback</th>
</tr>
<?
	$sql ="SELECT *, sum(case when opened >= DATE_SUB(CURDATE(),INTERVAL 1 DAY) THEN 1 ELSE 0 END) AS New FROM feedback  GROUP BY callid ORDER BY id DESC";
	$result = mysqli_query($db, $sql);
		while($loop = mysqli_fetch_array($result)) { ?>
<tr>
	<td><a href="/viewcall.php?id=<?=$loop['callid']?>"><?=$loop['callid']?></a></td>
	<td>
		<? if ($loop['satisfaction'] == 1) { echo "<img src='/images/star.png' alt='star' height='17' width='auto' />"; };?>
		<? if ($loop['satisfaction'] == 2) { echo "<img src='/images/star.png' alt='star' height='17' width='auto' /><img src='/images/star.png' alt='star' height='17' width='auto' />"; };?>
		<? if ($loop['satisfaction'] == 3) { echo "<img src='/images/star.png' alt='star' height='17' width='auto' /><img src='/images/star.png' alt='star' height='17' width='auto' /><img src='/images/star.png' alt='star' height='17' width='auto' />"; };?>
		<? if ($loop['satisfaction'] == 4) { echo "<img src='/images/star.png' alt='star' height='17' width='auto' /><img src='/images/star.png' alt='star' height='17' width='auto' /><img src='/images/star.png' alt='star' height='17' width='auto' /><img src='/images/star.png' alt='star' height='17' width='auto' />"; };?>
		<? if ($loop['satisfaction'] == 5) { echo "<img src='/images/star.png' alt='star' height='17' width='auto' /><img src='/images/star.png' alt='star' height='17' width='auto' /><img src='/images/star.png' alt='star' height='17' width='auto' /><img src='/images/star.png' alt='star' height='17' width='auto' /><img src='/images/star.png' alt='star' height='17' width='auto' />"; };?>
	</td>
	<td><?=substr(strtolower(strip_tags($loop['details'])), 0, 40);?>...</td>
</tr>
<? } ?>
</table>
