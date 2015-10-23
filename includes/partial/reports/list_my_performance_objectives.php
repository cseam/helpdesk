<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<div id="ajaxforms">
<p class="note">Showing all open performance objectives set for <?php echo(engineer_friendlyname($_SESSION['engineerId']));?></p>
	<table>
	<tbody>
	<?php
		$STH = $DBH->Prepare("SELECT * FROM performance_review_objectives WHERE engineerid = :assigned AND status !='2'");
		$STH->bindParam(":assigned", $_SESSION['engineerId'], PDO::PARAM_STR);
		$STH->setFetchMode(PDO::FETCH_OBJ);
		$STH->execute();
		if ($STH->rowCount() == 0) { echo "<p>0 performance objectives set</p>";};
		while($row = $STH->fetch()) {
		?>
			<tr>
				<td>
					<form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="assignedtoyou">
						<input type="hidden" id="id" name="id" value="<?=$row->id;?>" />
						<input type="submit" name="submit" value="<?=substr(strip_tags($row->title), 0, 50);?>..." alt="View objective" title="View objective" class="calllistbutton"/>
					</form>
				
				
				</td>
				<td><?php echo($row->progress); ?>%</td>
				<td><?php echo(date("M Y", strtotime($row->datedue))); ?></td>
				<td>
					<form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="assignedtoyou">
						<input type="hidden" id="id" name="id" value="<?=$row->id;?>" />
						<input type="image" name="submit" value="submit" src="/public/images/svg/ICONS-view.svg" width="24" height="25" class="icon" alt="View objective" title="View objective" />
					</form>
				</td>
			</tr>
		<? }; ?>
	</tbody>
	</table>
</div>

<script type="text/javascript">
	$('.assignedtoyou').submit(function(e) {
		$.ajax(
			{
				type: 'post',
				url: '/includes/partial/form/view_objective.php',
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