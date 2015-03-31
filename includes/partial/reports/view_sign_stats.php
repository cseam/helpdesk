<table>
<tbody>
<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

	$totalcalls = 0;
	$STH = $DBH->Prepare("SELECT COUNT(callid) AS totalcalls FROM calls WHERE helpdesk <= 3 AND status=1");
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	while($row = $STH->fetch()) {
		$totalcalls = $row->totalcalls;
	}

	$totalstars = 0;
	$STH = $DBH->Prepare("SELECT AVG(feedback.satisfaction) AS stars FROM calls INNER JOIN feedback ON feedback.callid=calls.callid WHERE status=2 AND helpdesk <= 3");
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	while($row = $STH->fetch()) {
		$totalcalls = $row->stars;
	}

	$STH = $DBH->Prepare("SELECT sum(case when calls.closed >= DATE_SUB(CURDATE(),INTERVAL 7 DAY) THEN 1 ELSE 0 END) AS Last7 , sum(case when calls.closed >= DATE_SUB(CURDATE(),INTERVAL 1 DAY) THEN 1 ELSE 0 END) AS Last1 FROM calls WHERE helpdesk <= 3");
	while($row = $STH->fetch()) { ?>
<tr>
	<td class="xbig"><?=$totalcalls;?></td>
	<td class="xbig"><?=$row->Last1;?></td>
	<td class="xbig"><?=$row->Last7;?></td>
	<td class="xbig"><? for ($i = 0; $i < round($totalstars); $i++) { echo "<img src='/public/images/ICONS-star.png' alt='star' height='60' width='auto' />"; }; ?></td>
</tr>
<?	} ?>
			</tbody>
			<tfoot>
				<tr>
					<td>Open Tickets</td>
					<td>Closed Today</td>
					<td>Closed This Week</td>
					<td>Average Feedback</td>
				</tr>
			</tfoot>
		</table>