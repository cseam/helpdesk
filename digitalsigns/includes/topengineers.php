<table>
<tr>
	<th>Top Engineers</th>
	<th>Month</th>
	<th>Week</th>
	<th>Day</th>
</tr>
<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

	$sql ="SELECT engineerName, sum(case when calls.closed >= DATE_SUB(CURDATE(),INTERVAL 7 DAY) THEN 1 ELSE 0 END) AS Last7 , sum(case when calls.closed >= DATE_SUB(CURDATE(),INTERVAL 1 DAY) THEN 1 ELSE 0 END) AS Last1 , sum(case when calls.closed >= DATE_SUB(CURDATE(),INTERVAL 30 DAY) THEN 1 ELSE 0 END) AS Last30 FROM engineers LEFT JOIN calls ON calls.closeengineerid = engineers.idengineers WHERE engineers.helpdesk <= 3 GROUP BY engineerName ORDER BY Last30 DESC";
	$result = mysqli_query($db, $sql);
		while($loop = mysqli_fetch_array($result)) { ?>

<tr>
	<td><?=$loop['engineerName'];?></td>
	<td><?=$loop['Last30'];?></td>
	<td><?=$loop['Last7'];?></td>
	<td><?=$loop['Last1'];?></td>
</tr>
<?	} ?>
</table>