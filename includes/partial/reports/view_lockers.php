<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<div id="ajaxforms">
	<table>
	<thead>
		<tr class="head">
			<th>Locker</th>
			<th>Status</th>
			<th>Owner</th>
			<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Details</th>
			<th style="text-align:right;">Return</th>
		</tr>
	</thead>
	<tbody>
	<?php
		if ($_SESSION['engineerHelpdesk'] <= '3') {
			$STH = $DBH->Prepare("SELECT * FROM calls INNER JOIN engineers ON calls.assigned=engineers.idengineers INNER JOIN status ON calls.status=status.id INNER JOIN location ON calls.location=location.id WHERE lockerid > 0 AND calls.helpdesk <= :helpdeskid ORDER BY lockerid");
			$hdid = 3;
		} else {
			$STH = $DBH->Prepare("SELECT * FROM calls INNER JOIN engineers ON calls.assigned=engineers.idengineers INNER JOIN status ON calls.status=status.id INNER JOIN location ON calls.location=location.id WHERE lockerid > 0 AND calls.helpdesk = :helpdeskid ORDER BY lockerid");
			$hdid = $_SESSION['engineerHelpdesk'];
		}
		$STH->bindParam(":helpdeskid", $hdid, PDO::PARAM_STR);
		$STH->setFetchMode(PDO::FETCH_OBJ);
		$STH->execute();
		if ($STH->rowCount() == 0) { echo "<tr><td colspan=5>0 items in lockers</td></tr>";};
		while($row = $STH->fetch()) {
		?>
		<tr>
		<td><?php echo($row->lockerid);?></td>
		<td><?php if ($row->status === '2') {echo("<span class=lockerready>Ready</span>");} else {echo("In Progress");};?></td>
		<td><?php echo($row->name);?></td>
		<td>
			<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="allcallslist">
				<input type="hidden" id="id" name="id" value="<?php echo $row->callid;?>" />
				<input type="submit" name="submit" value="<?php echo(substr(strip_tags($row->title), 0, 20));?>" alt="View ticket" title="View ticket" class="calllistbutton"/>
			</form>
		</td>
		<td>
			<?php if ($row->status === '2') { ?>
			<form action="<?php echo($_SERVER['PHP_SELF']);?>" method="post" class="returntouser">
				<input type="hidden" id="locker" name="locker" value="<?php echo($row->lockerid);?>" />
				<input type="hidden" id="owner" name="owner" value="<?php echo($row->name);?>" />
				<input type="hidden" id="id" name="id" value="<?php echo($row->callid);?>" />
				<input type="image" id="btn" name="btn" value="View" src="/public/images/svg/ICONS-forward.svg" class="icon" width="24" height="25" alt="return to user" title="return to user" />
			</form>
			<?php } ?>
		</td>
		</tr>
	<?php }; ?>
	</tbody>
	</table>
</div>
	<script type="text/javascript">
    $('.allcallslist').submit(function(e) {
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

     $('.returntouser').submit(function(e) {
	 	if (confirm("\nPlease Confirm \nLocker :#"+ this.locker.value +" \nOwner : "+ this.owner.value + "\n\nReturn this item?")) {
    	$.ajax(
			{
				type: 'post',
				url: '/includes/partial/post/locker_return.php',
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
       } else {
	   return false;
	   };
    });

    </script>