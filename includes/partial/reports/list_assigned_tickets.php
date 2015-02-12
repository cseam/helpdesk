<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<div id="ajaxforms">
<p class="note">Showing all open tickets for <?php echo(engineer_friendlyname($_SESSION['engineerId']));?></p>
	<table>
	<tbody>
	<?php
		//run select query
		$result = mysqli_query($db, "SELECT * FROM calls WHERE assigned='". $_SESSION['engineerId']  ."' AND status='1'");
		if (mysqli_num_rows($result) == 0) {
			echo "<p>0 assigned calls</p>";
			};
		while($calls = mysqli_fetch_array($result))  {
		?>
		<tr>
		<td>#<?=$calls['callid'];?></td>
		<td><?=date("d/m/y", strtotime($calls['opened']));?></td>
		<td class="view_td"><?=substr(strip_tags($calls['title']), 0, 90);?>...</td>
		<td>
			<form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="assignedtoyou">
				<input type="hidden" id="id" name="id" value="<?=$calls['callid'];?>" />
				<input type="image" name="submit" value="submit" src="/images/ICONS-view@2x.png" width="24" height="25" class="icon" alt="View ticket" title="View ticket" />
			</form>
		</td>
		</tr>
	<? } ?>
	</tbody>
	</table>
</div>
<script type="text/javascript">
	$('.assignedtoyou').submit(function(e) {
		$.ajax(
			{
				type: 'post',
				url: '/includes/partial/post/view_ticket.php',
				data: $(this).serialize(),
				beforeSend: function()
				{
				$('#ajax').html('<img src="/images/ICONS-spinny.gif" alt="loading" class="loading"/>');
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