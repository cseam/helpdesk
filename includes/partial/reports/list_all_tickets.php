<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<h2>View All Tickets</h2>
<div id="ajaxforms">
	<table>
	<thead>
		<tr class="head">
			<!--<th>#</th>-->
			<th>
				<select id="filter" onchange="filterTable()" >
					<option value="0" SELECTED>Location</option>
					<?php
						// populate locations from db
						$STH = $DBH->Prepare("SELECT * FROM location ORDER BY locationName");
						$STH->setFetchMode(PDO::FETCH_OBJ);
						$STH->execute();
						while($row = $STH->fetch()) { ?>
							<option value="<?php echo($row->id);?>"><?php echo($row->locationName);?></option>
					<?php };?>
			</select>
			<script type="text/javascript">
				function filterTable(err) {
					$("tr").show();
						if ($( "select#filter" ).val() !== '0') {
							$("tr").not("."+$( "select#filter" ).val()).hide();
						};
					$("tr.head").show();
				};
			</script>
			</th>
			<th>Status</th>
			<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Title</th>
			<th>Engineer</th>
		</tr>
	</thead>
	<tbody>
	<?php
		if ($_SESSION['engineerHelpdesk'] <= '3') {
			$STH = $DBH->Prepare("SELECT * FROM calls INNER JOIN engineers ON calls.assigned=engineers.idengineers INNER JOIN status ON calls.status=status.id INNER JOIN location ON calls.location=location.id WHERE engineers.helpdesk <= :helpdeskid ORDER BY callID DESC LIMIT 1000");
			$hdid = 3;
		} else {
			$STH = $DBH->Prepare("SELECT * FROM calls INNER JOIN engineers ON calls.assigned=engineers.idengineers INNER JOIN status ON calls.status=status.id INNER JOIN location ON calls.location=location.id WHERE engineers.helpdesk = :helpdeskid ORDER BY callID DESC LIMIT 1000");
			$hdid = $_SESSION['engineerHelpdesk'];
		}
		$STH->bindParam(":helpdeskid", $hdid, PDO::PARAM_STR);
		$STH->setFetchMode(PDO::FETCH_OBJ);
		$STH->execute();
		if ($STH->rowCount() == 0) { echo "<tr><td colspan=4>0 tickets logged</td></tr>";};
		while($row = $STH->fetch()) {
		?>
		<tr class="<?=$row->location;?>">
		<!--<td>#<?=$row->callid;?></td>-->
		<td><span class="smalltxt"><?=$row->locationName;?></span></td>
		<td><?php
			if ($row->status == '2') { echo "<span class='closed'>CLOSED</span>"; }
		elseif ($row->status == '3') { echo("<span class='hold'>HOLD</span>"); }
		else { echo "<span class='open'>" . date("d/m/y", strtotime($row->opened)) . "</span>";} ?></td>
		<td>
			<form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="allcallslist">
				<input type="hidden" id="id" name="id" value="<?=$row->callid;?>" />
				<button name="submit" value="submit" type="submit" class="calllistbutton" title="view call"><?=substr(strip_tags($row->title), 0, 40);?>...</button>
			</form>
		</td>
		<td><?=strstr($row->engineerName," ", true);?></td>


		</tr>
	<? } ?>
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
    </script>