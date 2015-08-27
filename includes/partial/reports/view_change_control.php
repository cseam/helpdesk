<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<h2>Change Control</h2>
<p class="buttons"><button onclick="update_div('#ajax','reports/add_change_control.php')">Add Change Control</button><button onclick="update_div('#ajax','reports/view_tags.php')">Add Tags</button></p>
<table>
	
	<tbody>
<?php
	if ($_SESSION['engineerHelpdesk'] <= '3') {
		$STH = $DBH->Prepare("SELECT * FROM changecontrol INNER JOIN engineers ON changecontrol.engineersid=engineers.idengineers WHERE changecontrol.helpdesk <= :helpdeskid ORDER BY id DESC");
		$hdid = 3;

	} else {
		$STH = $DBH->Prepare("SELECT * FROM changecontrol INNER JOIN engineers ON changecontrol.engineersid=engineers.idengineers WHERE changecontrol.helpdesk = :helpdeskid ORDER BY id DESC");
		$hdid = $_SESSION['engineerHelpdesk'];

	}
	$STH->bindParam(":helpdeskid", $hdid, PDO::PARAM_STR);
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	if ($STH->rowCount() == 0) { echo "<tr><td colspan=5>0 changes logged</td></tr>";};
	while($row = $STH->fetch()) { ?>
<tr>
	<td>
		<strong><?=substr(strip_tags($row->server), 0, 25);?></strong><br/><?= date("d/m @ h:s", strtotime($row->stamp)) ?>
	</td>
	<td>
		<form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="viewchange">
			<input type="hidden" id="id" name="id" value="<?=$row->id;?>" />
			<input type="submit" name="submit" value="<?=substr(strip_tags($row->changemade), 0, 50);?>..." alt="View Change" title="View Change" class="calllistbutton"/>
		</form>
	</td>
</tr>
<?php } ?>
	</tbody>
</table>

<script type="text/javascript">
	$('.viewchange').submit(function(e) {
		$.ajax(
			{
				type: 'post',
				url: '/includes/partial/form/view_changecontrol.php',
				data: $(this).serialize(),
				beforeSend: function()
				{
				$('#ajax').html('<img src="/public/images/ICONS-spinny.gif" alt="loading" class="loading"/>');
				},
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