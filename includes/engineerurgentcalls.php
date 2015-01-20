<?php
	//only my helpdesks
		if ($_SESSION['engineerHelpdesk'] <= '3') {
			$whereenginners = 'WHERE helpdesk <= 3';
		} else {
			$whereenginners = 'WHERE helpdesk='.$_SESSION['engineerHelpdesk'];
		};
	// are there any urgent calls?
	$result = mysqli_query($db, "SELECT * FROM calls ".$whereenginners." AND urgency='3' AND status='1'");
	// display results if found
	if(mysqli_num_rows($result) > 0) {
?>
<h3>Urgent Calls</h3>
<div id="ajaxforms">
	<table>
	<tbody>
	<?php
		while($calls = mysqli_fetch_array($result))  {
		?>
		<tr class="urgent">
		<td>#<?=$calls['callid'];?></td>
		<td><?=date("d/m/y", strtotime($calls['opened']));?><br />
			<?=date("H:i", strtotime($calls['opened']));?></td>
		<td class="view_td"><?=substr(strip_tags($calls['details']), 0, 120);?>...</td>
		<td>
			<form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="assignedtoyou">
				<input type="hidden" id="id" name="id" value="<?=$calls['callid'];?>" />
				<input type="image" name="submit" value="submit" src="/images/ICONS-urgent@2x.png" width="24" height="25" class="icon" alt="View Call" />
			</form>
		</td>
		</tr>
	<? } ?>
	</tbody>
	</table>
</div>
<?php } ?>
