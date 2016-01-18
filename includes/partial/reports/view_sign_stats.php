<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

	// Set Defaults
	$totalcalls = 0;
	$totalstars = 0;
	$topengineer = 'null';
	$topengineeralltime = 'null';
	$ticketcount = '0';
	$avgtickettime = '0';
	$laptopfixedcount = '0';

	// Populate vars from db
	// Count total open calls
	$STH = $DBH->Prepare("SELECT COUNT(callid) AS totalcalls FROM calls WHERE helpdesk <= 3 AND status=1");
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	while($row = $STH->fetch()) {
		$totalcalls = $row->totalcalls;
	}
	// Count total tickets
	$STH = $DBH->Prepare("SELECT COUNT(callid) AS ticketcount FROM calls WHERE helpdesk <= 3");
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	while($row = $STH->fetch()) {
		$ticketcount = $row->ticketcount;
	}
	// Laptops Fixed
	$STH = $DBH->Prepare("SELECT COUNT(callid) AS laptopfixed FROM calls WHERE category = 11 AND status=2");
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	while($row = $STH->fetch()) {
		$laptopfixedcount = $row->laptopfixed;
	}
	// Avg Feedback
	$STH = $DBH->Prepare("SELECT AVG(feedback.satisfaction) AS stars FROM calls INNER JOIN feedback ON feedback.callid=calls.callid WHERE status=2 AND helpdesk <= 3");
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	while($row = $STH->fetch()) {
		$totalstars = $row->stars;
	}
	// Top engineer this week
	$STH = $DBH->Prepare("SELECT closeengineerid, Count(callid) as count FROM calls WHERE closed >= DATE_SUB(CURDATE(),INTERVAL 6 DAY) AND status=2 AND helpdesk <=3 GROUP BY closeengineerid ORDER BY count DESC LIMIT 1");
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	while($row = $STH->fetch()) {
		$topengineer = engineer_friendlyname($row->closeengineerid);
	}
	// Top engineer of all time
	$STH = $DBH->Prepare("SELECT closeengineerid, Count(callid) as count FROM calls WHERE closed >= DATE_SUB(CURDATE(),INTERVAL 10 YEAR) AND status=2 AND helpdesk <=3 GROUP BY closeengineerid ORDER BY count DESC LIMIT 1");
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	while($row = $STH->fetch()) {
		$topengineeralltime = engineer_friendlyname($row->closeengineerid);
	}
	// Avg Ticket Time
	$STH = $DBH->Prepare("SELECT callid, AVG(DATEDIFF(opened, closed)) AS avgticketdays FROM calls WHERE status=2");
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	while($row = $STH->fetch()) {
		$avgtickettime = abs(ROUND($row->avgticketdays));
	}


?>
	<table>
		<tbody>
<?php

	$STH = $DBH->Prepare("SELECT sum(case when calls.closed >= DATE_SUB(CURDATE(),INTERVAL 6 DAY) THEN 1 ELSE 0 END) AS Last7, sum(case when calls.closed >= DATE_SUB(CURDATE(),INTERVAL 0 DAY) THEN 1 ELSE 0 END) AS Last1 FROM calls WHERE helpdesk <= 3");
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	while($row = $STH->fetch()) { ?>
		<tr>
			<td class="xbig"><?php echo($totalcalls);?></td>
			<td class="xbig"><?=$row->Last1;?></td>
			<td class="xbig"><?=$row->Last7;?></td>
			<td class="xbig"><? for ($i = 0; $i < round($totalstars); $i++) { echo "<img src='/public/images/svg/ICONS-star.svg' alt='star' height='40' width='auto' />"; }; ?></td>
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
	<p></p>
	<table>
		<tbody>
			<tr>
				<td class="xbig"><?=$ticketcount?></td>
				<td class="xbig"><?=$avgtickettime?></td>
				<td class="xbig"><?=$laptopfixedcount?></td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<td>Total Tickets <br/> Closed</td>
				<td>Average Ticket <br />Time in Days</td>
				<td>Total Laptops <br/> Fixed</td>
			</tr>
		</tfoot>
	</table>
	<p></p>
	<table>
		<tbody>
			<tr>
				<td class="mbig"><?=$topengineer?></td>
				<td class="mbig"><?=$topengineeralltime?></td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<td>Top Engineer This Week</td>
				<td>Top Engineer of All Time</td>
			</tr>
		</tfoot>
	</table>

