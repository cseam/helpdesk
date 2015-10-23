<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] .'/includes/functions.php');

	if ($_SESSION['engineerHelpdesk'] <= '3') {
		$STH = $DBH->Prepare("SELECT * FROM calls WHERE helpdesk <= :helpdeskid AND urgency='10' AND status='1'");
		$hdid = 3;
	} else {
		$STH = $DBH->Prepare("SELECT * FROM calls WHERE helpdesk = :helpdeskid AND urgency='10' AND status='1'");
		$hdid = $_SESSION['engineerHelpdesk'];
	}

	$STH = $DBH->Prepare("SELECT * FROM calls WHERE helpdesk <= :helpdeskid AND urgency='10' AND status='1'");
	$hdid = 3;
	$STH->bindParam(":helpdeskid", $hdid, PDO::PARAM_INT);
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	// display results if found
	if($STH->rowCount() > 0) { ?>
<h3>Urgent Tickets</h3>
<div id="ajaxforms">
	<table>
	<tbody>
	<?php while($row = $STH->fetch()) { ?>
		<tr class="urgent">
		<td><?=date("d/m @ H:i", strtotime($row->opened));?></td>
		<td class="view_td"><?=substr(strip_tags($row->title), 0, 90);?>...</td>
		<td>
			<form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="assignedtoyou">
				<input type="hidden" id="id" name="id" value="<?=$row->callid;?>" />
				<input type="image" name="submit" value="submit" src="/public/images/svg/ICONS-urgent.svg" width="24" height="25" class="icon" alt="View ticket" title="View ticket" />
			</form>
		</td>
		</tr>
	<? }; ?>
	</tbody>
	</table>
</div>
<?php
}