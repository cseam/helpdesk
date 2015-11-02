<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

	if($_POST['helpdesk']) { $helpdesk =" AND calls.helpdesk = :searchhelpdeskid "; };
	if($_POST['status']) { $status =" AND calls.status = :searchstatus "; };
	if($_POST['ticketid']) { $ticketnumber =" AND calls.callid = :ticketid "; };
	if($_POST['engineer']) { $engineer =" AND calls.assigned = :engineer "; };
	if($_POST['location']) { $location =" AND calls.location = :locationid "; };
	if($_POST['user']) { $samacc =" AND calls.owner = :samacc "; };

	$STH = $DBH->Prepare("
		SELECT * FROM calls
		INNER JOIN engineers ON calls.assigned = engineers.idengineers
		INNER JOIN status ON calls.status = status.id
		WHERE (
			details LIKE :search
			OR title LIKE :search
		)
		$helpdesk
		$status
		$ticketnumber
		$engineer
		$location
		ORDER BY callid DESC
		LIMIT 100");

	$term = "%".$_POST['term']."%";
	$STH->bindParam(":search", $term, PDO::PARAM_STR);
	$STH->bindParam(":searchhelpdeskid", $_POST['helpdesk'], PDO::PARAM_STR);
	$STH->bindParam(":searchstatus", $_POST['status'], PDO::PARAM_STR);
	$STH->bindParam(":ticketid", $_POST['ticketid'], PDO::PARAM_STR);
	$STH->bindParam(":engineer", $_POST['engineer'], PDO::PARAM_STR);
	$STH->bindParam(":locationid", $_POST['locationid'], PDO::PARAM_STR);
	$STH->bindParam(":samacc", $_POST['user'], PDO::PARAM_STR);
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();

	?>
<table>
	<tbody>
<?php	while($row = $STH->fetch()) { ?>
	<tr>
		<td>#<?php echo($row->callid);?></td>
		<td>
		<?php if ($row->status ==='2') {
			echo "<span class='closed'>Closed</span>";
			} else {
			echo date("d/m/y", strtotime($row->opened));
			};
		?></td>
		<td><?=strstr($row->engineerName," ", true);?></td>
		<td>
			<form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="searchresultsview" >
				<input type="hidden" id="id" name="id" value="<?=$row->callid;?>" />
				<div style="margin-top:10px;float: left;"><?=substr(strip_tags($row->title), 0, 40);?>...</div>
				<input type="image" name="submit" value="submit" src="/public/images/svg/ICONS-view.svg" width="24" height="25" class="icon" alt="View ticket" />
			</form>
		</td>
		</tr>
<?  }; ?>
	</tbody>
</table>
<?php echo("<p>" . $STH->rowCount() . " results returned.</p>");?>
<script type="text/javascript">
	$('.searchresultsview').submit(function(e) {
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