
<table>
			<tbody>
<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
	
	$totalcalls = 0;
	$sqlOpencalls = "SELECT COUNT(callid) AS totalcalls FROM calls WHERE helpdesk <= 3 AND status=1";
		$resulttotal = mysqli_query($db, $sqlOpencalls);
			while($looptotal = mysqli_fetch_array($resulttotal)) {
				$totalcalls = $looptotal['totalcalls'];
			};
	
	$totalstars = 0;
	$sqlStars = "SELECT AVG(feedback.satisfaction) AS stars FROM calls INNER JOIN feedback ON feedback.callid=calls.callid WHERE status=2 AND helpdesk <= 3";
		$resultstars = mysqli_query($db, $sqlStars);
			while($loopstars = mysqli_fetch_array($resultstars)) {
				$totalstars = $loopstars['stars'];
			};
	
	$sql ="SELECT sum(case when calls.closed >= DATE_SUB(CURDATE(),INTERVAL 7 DAY) THEN 1 ELSE 0 END) AS Last7 , sum(case when calls.closed >= DATE_SUB(CURDATE(),INTERVAL 1 DAY) THEN 1 ELSE 0 END) AS Last1 FROM calls WHERE helpdesk <= 3";
	$result = mysqli_query($db, $sql);
		while($loop = mysqli_fetch_array($result)) { ?>
<tr>
	<td class="xbig"><?=$totalcalls;?></td>
	<td class="xbig"><?=$loop['Last1'];?></td>
	<td class="xbig"><?=$loop['Last7'];?></td>
	<td class="xbig"><? for ($i = 0; $i < round($totalstars); $i++) { echo "<img src='/images/star.png' alt='star' height='60' width='auto' />"; }; ?></td>
</tr>
<?	} ?>
			</tbody>
			<tfoot>
				<tr>
					<td>Open Calls</td>
					<td>Closed Today</td>
					<td>Closed This Week</td>
					<td>Average Feedback</td>
				</tr>
			</tfoot>
		</table>
