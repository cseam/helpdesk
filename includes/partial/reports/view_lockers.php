<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<div id="ajaxforms">

<h2>Lockers</h2>
	<table>
	<thead>
		<tr class="head">
			<th>Locker<br/>#</th>
			<th>Laptop Status</th>
			<th>Laptop Owner</th>
			<th>Ticket <br/>Details</th>
			<th style="text-align:right;">View Ticket</th>
			<th style="text-align:right;">Return Laptop</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$STH = $DBH->Prepare("SELECT * FROM calls INNER JOIN engineers ON calls.assigned=engineers.idengineers INNER JOIN status ON calls.status=status.id INNER JOIN location ON calls.location=location.id WHERE lockerid > 0 ORDER BY lockerid");
		$STH->setFetchMode(PDO::FETCH_OBJ);
		$STH->execute();
		if ($STH->rowCount() == 0) { echo "<tr><td colspan=5>0 items in lockers</td></tr>";};
		while($row = $STH->fetch()) {
		?>
		<tr>
		<td><?php echo($row->lockerid);?></td>
		<td><?php if ($row->status === '2') {echo("<span class=lockerready>Ready</span>");} else {echo("In Progress");};?></td>
		<td><?php echo($row->name);?></td>
		<td><?php echo($row->title); ?></td>
		<td>
			<form action="<?php echo($_SERVER['PHP_SELF']);?>" method="post" class="allcallslist">
				<input type="hidden" id="id" name="id" value="<?php echo($row->callid);?>" />
				<input type="image" id="btn" name="btn" value="View" src="/public/images/ICONS-view@2x.png" class="icon" width="24" height="25" alt="View details" title="View details" />
			</form>
		</td>
		<td>
			<form action="<?php echo($_SERVER['PHP_SELF']);?>" method="post" class="returntouser">
				<input type="hidden" id="id" name="id" value="<?php echo($row->callid);?>" />
				<input type="image" id="btn" name="btn" value="View" src="/public/images/ICONS-forward@2x.png" class="icon" width="24" height="25" alt="return to user" title="return to user" />
			</form>
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
    });

    </script>