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
			<th>#</th>
			<th>
				<select id="filter" onchange="filterTable()" >
					<option value="0" SELECTED>Location</option>
				<? //populate filter
					$filter = mysqli_query($db, "SELECT * FROM location;");
					while($locations = mysqli_fetch_array($filter))  { ?>
					<option value="<?=$locations['id'];?>"><?=$locations['locationName'];?></option>
				<?}?>
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
			<th>Date</th>
			<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Details</th>
			<th>Engineer</th>
		</tr>
	</thead>
	<tbody>
	<?php
		//only my helpdesks
		if ($_SESSION['engineerHelpdesk'] <= '3') {
			$whereenginners = 'WHERE engineers.helpdesk <= 3';
		} else {
			$whereenginners = 'WHERE engineers.helpdesk='.$_SESSION['engineerHelpdesk'];
		};
		//run select query
		$result = mysqli_query($db, "SELECT * FROM calls INNER JOIN engineers ON calls.assigned=engineers.idengineers INNER JOIN status ON calls.status=status.id INNER JOIN location ON calls.location=location.id ".$whereenginners." ORDER BY callID DESC LIMIT 1000;");
		if (mysqli_num_rows($result) == 0) { echo "<p>All calls Closed</p>";};
		while($calls = mysqli_fetch_array($result))  {
		?>
		<tr class="<?=$calls['location'];?>">
		<td>#<?=$calls['callid'];?></td>
		<td><span class="smalltxt"><?=$calls['locationName'];?></span></td>
		<td>

		<? if ($calls['status'] ==='2') {
			echo "<span class='closed'>Closed</span>";
			} else {
			echo date("d/m/y", strtotime($calls['opened']));
			};
		?></td>
		<td>
			<form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="allcallslist">
				<input type="hidden" id="id" name="id" value="<?=$calls['callid'];?>" />
				<button name="submit" value="submit" type="submit" class="calllistbutton" title="view call"><?=substr(strip_tags($calls['title']), 0, 40);?>...</button>
			</form>
		</td>
		<td><?=strstr($calls['engineerName']," ", true);?></td>


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