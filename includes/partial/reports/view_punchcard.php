<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<h2>Punchcard</h2>
<?php if ($_SERVER['REQUEST_METHOD']== "POST" & $_POST['toggle'] == TRUE) { ?>
<?
	// Remove all status for engineers just submitted
	$STH = $DBH->Prepare("DELETE FROM engineers_status WHERE id = :id");
	$STH->bindParam(":id", $_POST['id'], PDO::PARAM_INT);
	$STH->execute();
	// get toggle status
	$whichtoggle = "cmn-toggle-" . $_POST['id'];
	if ($_POST[$whichtoggle] == 'on') {
		$togglevalue = 1;
	} else {
		$togglevalue = 0;
	}
	// Update status with changes from form
	$STH = $DBH->Prepare("INSERT INTO engineers_status (id, status) VALUES (:id , :toggle)");
	$STH->bindParam(":id", $_POST['id'], PDO::PARAM_INT);
	$STH->bindParam(":toggle", $togglevalue, PDO::PARAM_INT);
	$STH->execute();
	// Update timestamp with changes
	$STH = $DBH->Prepare("INSERT INTO engineers_punchcard (engineerid, direction, stamp) VALUES (:id , :toggle, :date)");
	$STH->bindParam(":id", $_POST['id'], PDO::PARAM_INT);
	$STH->bindParam(":toggle", $togglevalue, PDO::PARAM_INT);
	$STH->bindParam(":date", date("c"), PDO::PARAM_INT);
	$STH->execute();
	 } ?>


<?php
	if ($_SESSION['engineerHelpdesk'] <= '3') {
		$STH = $DBH->Prepare("SELECT * FROM engineers LEFT JOIN engineers_status ON engineers_status.id=engineers.idengineers WHERE engineers.helpdesk <= :helpdeskid");
		$hdid = 3;
	} else {
		$STH = $DBH->Prepare("SELECT * FROM engineers LEFT JOIN engineers_status ON engineers_status.id=engineers.idengineers WHERE engineers.helpdesk = :helpdeskid");
		$hdid = $_SESSION['engineerHelpdesk'];
	}
	$STH->bindParam(":helpdeskid", $hdid, PDO::PARAM_STR);
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();?>
<table>
<tr>
	<th>Engineer Name</th>
	<th>Status</th>
	<th>IN / OUT</th>
	<th>Date - Time</th>
</tr>
<?php
	while($row = $STH->fetch()) {
?>
<tr>
	<td><?=$row->engineerName;?></td>
	<td>
		<div class="switch" style="float:left;">
			<form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="toggleform" >
				<input type="hidden" id="toggle" name="toggle" value="TRUE" />
				<input type="hidden" id="id" name="id" value="<?=$row->idengineers;?>" />
				<input id="cmn-toggle-<?=$row->idengineers?>" name="cmn-toggle-<?=$row->idengineers?>" class="cmn-toggle cmn-toggle-round" type="checkbox" <? if ($row->status == 1) { ?>checked="true" <?}?>>
				<label for="cmn-toggle-<?=$row->idengineers?>"></label>
			</form>
		</div>
		</td>
		<td>
			<?php
				$STHloop = $DBH->Prepare("SELECT * FROM engineers_punchcard WHERE engineerid = :engineersid ORDER BY id DESC LIMIT 1");
				$STHloop->bindParam(":engineersid", $row->idengineers, PDO::PARAM_STR);
				$STHloop->setFetchMode(PDO::FETCH_OBJ);
				$STHloop->execute();
				while($rowloop = $STHloop->fetch()) {
					if ($rowloop->direction == 0) { echo "OUT ";} else { echo "IN ";};
				?>
		</td>
		<td>
			<?=date("d/m - h:ia", strtotime($rowloop->stamp));?>
		</td>
		<?php } ?>
</tr>
<?php
	}
?>
</table>
<script type="text/javascript">
	$('.toggleform').change(function(e) {
		$.ajax(
			{
				type: 'post',
				url: '/includes/partial/reports/view_punchcard.php',
				data: $(this).serialize(),
				success: function(data)
				{
				$('#ajax').html(data);
			},
				error: function()
				{
				$('#ajax').html('error loading data, please refresh.');
			}
			});
		e.preventDefault();
		return false;
	});
</script>