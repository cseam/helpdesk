<?php 
	include_once('../includes/functions.php');
?>
<table>
<tr>
	<th>New</th>
	<th>Call Id</th>
	<th>Satisfaction</th>
	<th>Customer Feedback</th>
</tr>
<?	
	$sql ="SELECT *, sum(case when opened >= DATE_SUB(CURDATE(),INTERVAL 1 DAY) THEN 1 ELSE 0 END) AS New FROM feedback  GROUP BY callid ORDER BY id DESC";
	$result = mysqli_query($db, $sql);
		while($loop = mysqli_fetch_array($result)) { ?>
<tr>
	<td><?=$loop['New'];?></td>
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
