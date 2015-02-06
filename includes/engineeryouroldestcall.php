	<?php
	// select calls for ID
	// run select query
	$sqloldeststr = "SELECT * FROM calls ";
	$sqloldeststr .= "INNER JOIN engineers ON calls.assigned=engineers.idengineers ";
	$sqloldeststr .= "INNER JOIN status ON calls.status=status.id ";
	$sqloldeststr .= "INNER JOIN location ON calls.location=location.id ";
	$sqloldeststr .= "WHERE status='1' AND assigned='". $_SESSION['engineerId'] . "' ";
	$sqloldeststr .= "ORDER BY opened ";
	$sqloldeststr .= "LIMIT 1";
	$oldestresult = mysqli_query($db, $sqloldeststr);
	// display results to page
	
	if (mysqli_num_rows($oldestresult) == 0) { echo("<h3>0 assigned calls</h3>"); };
	while($call = mysqli_fetch_array($oldestresult))  {
	?>
	<div id="calldetails">
	<form action="updatecall.php" method="post" enctype="multipart/form-data">
	<input type="hidden" id="id" name="id" value="<?=$call['callid'];?>" />
	<input type="hidden" id="details" name="details" value="<?=$call['details'];?>" />
	<h2>Oldest Call Details #<?=$call['callid'];?></h2>
	<h3><?=$call['title'];?></h3>
	<p class="callheader">created by <a href="mailto:<?=$call['email'];?>"><?=$call['name'];?></a> (<?=$call['tel'];?>)</p>	
	<p class="callheader">for <?=$call['room'];?> - <?=$call['locationName'];?></p>
	<p class="callheader">Open for 
					<?php
						$date1 = strtotime($calls['opened']);
						if ($calls['status'] ==='2') { $date2 = strtotime($calls['closed']); } else { $date2 = time(); };
						$diff = $date2 - $date1;
						$d = ($diff/(60*60*24))%365;
						$h = ($diff/(60*60))%24;
						$m = ($diff/60)%60;
						echo $d." days, ".$h." hours, ".$m." minutes.";
					?></p>
	<?php if (!empty($call['attachmentname'])) { ?><p><img src="/uploads/<?=$call['attachmentname'];?>" width="100%" /></p><? }; ?>
	<hr />
	<?php
	 $additional_field_sql = "SELECT * FROM call_additional_results WHERE callid = ".$call['callid'].";";
	 $additional_field_result = mysqli_query($db, $additional_field_sql); 
	 while ($items = mysqli_fetch_array($additional_field_result)) { ?>
	 <p class="callheader"><?=$items['label']?> - <?=$items['value']?></p>	 
	<? } ?>
	<p class="callbody"><?=$call['details'];?></p>
	<p><textarea name="updatedetails" id="updatedetails" rows="10" cols="40"></textarea></p>
	<p><label for="attachment" style="width: 190px">Picture or Screenshot</label><input type="file" name="attachment" accept="image/*" style="background-color: transparent;" id="attachment"></p>
	
	
	<?php if ($_SESSION['engineerId'] !== null) {?>
	<?	
		// filter for engineers helpdesks
		if ($_SESSION['engineerHelpdesk'] <= '3') {
			$whereenginners = 'WHERE helpdesk_id <= 3';
		} else {
			$whereenginners = 'WHERE helpdesk_id='.$_SESSION['engineerHelpdesk']."'";
		};
	?>
	<fieldset>
		<legend>Engineer Controls</legend>
	<span class="engineercontrols">
			<label for="callreason">Reason behind issue</label>
			<select id="callreason" name="callreason" required>
				<option value="" SELECTED>Please Select</option>
				<?php
				$callreasons = mysqli_query($db, "SELECT * FROM callreasons ".$whereenginners." ORDER BY reason_name;");
				while($option = mysqli_fetch_array($callreasons)) { ?>
					<option value="<?=$option['id'];?>"><?=$option['reason_name'];?></option>
				<? } ?>
			</select>
			<label for="quickresponse">Quick Response</label>
			<select id="quickresponse" name="quickresponse" required>
				<option value="" SELECTED>Please Select</option>
					<?php
				$quickresponses = mysqli_query($db, "SELECT * FROM quick_responses ".$whereenginners." ORDER BY quick_response;");
				while($option = mysqli_fetch_array($quickresponses)) { ?>
					<option value="<?=$option['quick_response'];?>"><?=$option['quick_response'];?></option>
				<? } ?>
			</select>
			<script type="text/javascript">
			$("#quickresponse").change(function(e) {
				 $('#updatedetails').val($('#quickresponse').val() + ', ' + $('#updatedetails').val());
				});
			</script>
	</span>
	</fieldset>
	<?php } ?>
	<p class="buttons">
		<button name="close" value="close" type="submit">Close Call</button>
		<button name="update" value="update" type="submit">Update Call</button>
	</p>
	<p class="callfooter">Call Opened <?=date("d/m/y h:s", strtotime($call['opened']));?><br />Last Update <?=date("d/m/y h:s", strtotime($call['lastupdate']));?></p>
	</form>
	</div>
	<?php } ?>
