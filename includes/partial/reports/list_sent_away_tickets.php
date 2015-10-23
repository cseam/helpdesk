<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<div id="ajaxforms">
	<?php
		if ($_SESSION['engineerHelpdesk'] <= '3') {
			$STH = $DBH->Prepare("SELECT * FROM calls INNER JOIN engineers ON calls.assigned=engineers.idengineers INNER JOIN status ON calls.status=status.id INNER JOIN location ON calls.location=location.id WHERE engineers.helpdesk <= :helpdeskid AND status ='5' ORDER BY callID");
			$hdid = 3;
		} else {
			$STH = $DBH->Prepare("SELECT * FROM calls INNER JOIN engineers ON calls.assigned=engineers.idengineers INNER JOIN status ON calls.status=status.id INNER JOIN location ON calls.location=location.id WHERE engineers.helpdesk = :helpdeskid AND status ='5' ORDER BY callID");
			$hdid = $_SESSION['engineerHelpdesk'];
		}
		$STH->bindParam(":helpdeskid", $hdid, PDO::PARAM_STR);
		$STH->setFetchMode(PDO::FETCH_OBJ);
		$STH->execute();
		echo ("<h3>" . $STH->rowCount() . " - Tickets sent away off site</h3><table><tbody>");
		if ($STH->rowCount() == 0) { echo "<p>No sent away off site tickets</p>";};
		while($row = $STH->fetch()) {
		?>
		
		<tr>
			<td class="hdtitle">
			#<?php echo $row->callid; ?>
			</td>
			<td colspan="3" class="hdtitle">
			<form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="viewpost">
				<input type="hidden" id="id" name="id" value="<?=$row->callid;?>" />
				<button name="submit" value="submit" type="submit" class="calllistbutton" title="view call"><?=substr(strip_tags($row->title), 0, 75);?></button>
			</form>
			</td>
		</tr>
		<tr>
			<td><img src="/public/images/<?=$row->iconlocation;?>" alt="<?=$row->locationName;?>" title="<?=$row->locationName;?>" width="24px" height="auto"/></td>
			
			<td>
				<?php
				if ($row->status == '2') { echo "<span class='closed'>CLOSED</span>"; }
				elseif ($row->status == '3') { echo("<span class='hold'>ON HOLD</span>"); }
				elseif ($row->status == '4') { echo("<span class='escalated'>ESCALATED</span>"); }
				elseif ($row->status == '5') { echo("<span class='hold'>SENT AWAY</span>"); }
				else { echo "<span class='open'>" . date("d/m/y", strtotime($row->opened)) . "</span>";} 
				?>
			</td>
			<td>
				<?php if ($row->assigned !== NULL) { echo(engineer_friendlyname($row->assigned)); } else { echo("NULL"); };?>
			</td>
			<td>
			<?php
			$datetime1 = new DateTime(date("Y-m-d", strtotime($row->opened)));
			$datetime2 = new DateTime(date("Y-m-d"));
			$interval = date_diff($datetime1, $datetime2);
			echo $interval->format('%a days');
			?>
			</td>
			<td>
			<form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="reassign">
				<input type="hidden" id="id" name="id" value="<?=$row->callid;?>" />
				<input name="submit" value="" type="image" src="/public/images/svg/ICONS-assign.svg" width="24" height="25" class="icon" alt="assign engineer"  title="assign engineer" />
			</form>
			</td>
			<td>
				<form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="forward">
				<input type="hidden" id="id" name="id" value="<?=$row->callid;?>" />
				<input name="submit" value="" type="image" src="/public/images/svg/ICONS-forward.svg" width="24" height="25" class="icon" alt="forward ticket"  title="forward ticket"/>
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

	$('.reassign').submit(function(e) {
    	$.ajax(
			{
				type: 'post',
				url: '/includes/partial/post/reassign_ticket.php',
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

  	$('.forward').submit(function(e) {
    	$.ajax(
			{
				type: 'post',
				url: '/includes/partial/post/forward_ticket.php',
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
