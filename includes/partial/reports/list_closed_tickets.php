<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<div id="ajaxforms">
	<?php
		if ($_SESSION['engineerHelpdesk'] <= '3') {
			$STH = $DBH->Prepare("SELECT * FROM calls INNER JOIN status ON calls.status=status.id INNER JOIN location ON calls.location=location.id WHERE helpdesk <= :helpdeskid AND status ='2' AND assigned !='NULL' ORDER BY calls.closed DESC LIMIT 1000");
			$hdid = 3;
		} else {
			$STH = $DBH->Prepare("SELECT * FROM calls INNER JOIN status ON calls.status=status.id INNER JOIN location ON calls.location=location.id WHERE helpdesk = :helpdeskid AND status ='2' AND assigned !='NULL' ORDER BY calls.closed DESC LIMIT 1000");
			$hdid = $_SESSION['engineerHelpdesk'];
		}
		$STH->bindParam(":helpdeskid", $hdid, PDO::PARAM_STR);
		$STH->setFetchMode(PDO::FETCH_OBJ);
		$STH->execute();
		echo ("<h3>Last " . $STH->rowCount() . " Closed Tickets</h3><table><tbody>");
		if ($STH->rowCount() == 0) { echo "<p>No Open Tickets</p>";};
		while($row = $STH->fetch()) {
		?>
		<tr>
		<td>
			#<?php echo $row->callid; ?>
		</td>
		<td><img src="/public/images/<?=$row->iconlocation;?>" alt="<?=$row->locationName;?>" title="<?=$row->locationName;?>" width="24px" height="auto"/></td>
		<td>
			<?php if ($row->closeengineerid !== NULL) { echo(strstr(engineer_friendlyname($row->closeengineerid)," ", true)); } else { echo("NULL"); };?>
		</td>
		<td width="45">
		<?php echo date("d/m/y", strtotime($row->closed)); ?>
		</td>
		<td>
			<form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="viewpost">
				<input type="hidden" id="id" name="id" value="<?=$row->callid;?>" />
				<button name="submit" value="submit" type="submit" class="calllistbutton" title="view call"><?=substr(strip_tags($row->title), 0, 65);?>...</button>
			</form>
		</td>
		</tr>
	<? } ?>
	</tbody>
	</table>
</div>
	<script type="text/javascript">
     $('.viewpost').submit(function(e) {
    	$.ajax(
			{
				type: 'post',
				url: '/includes/partial/form/view_ticket.php',
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