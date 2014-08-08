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
	while($call = mysqli_fetch_array($oldestresult))  {
	?>
	<div id="calldetails">
	<form action="updatecall.php" method="post">
	<input type="hidden" id="id" name="id" value="<?=$call['callid'];?>" />
	<input type="hidden" id="details" name="details" value="<?=$call['details'];?>" />
	<h2>Oldest Call Details #<?=$call['callid'];?><a href="viewcall.php?id=<?=$call['callid'];?>" class="calllink">full details</a></h2>
	<p class="callheader">created by <a href="mailto:<?=$call['email'];?>"><?=$call['name'];?></a> (<?=$call['tel'];?>)</p>	
	<p class="callheader">for <?=$call['room'];?> - <?=$call['locationName'];?></p>
	<p class="callheader">duration 
					<?php
						$date1 = strtotime($calls['opened']);
						if ($calls['status'] ==='2') { $date2 = strtotime($calls['closed']); } else { $date2 = time(); };
						$diff = $date1 - $date2;
						$d = ($diff/(60*60*24))%365;
						$h = ($diff/(60*60))%24;
						$m = ($diff/60)%60;
						echo $d." days, ".$h." hours, ".$m." minutes.";
					?></p>
	<?php if (!empty($call['attachmentname'])) { ?><p><img src="/uploads/<?=$call['attachmentname'];?>" width="100%" /></p><? }; ?>
	<p class="callbody"><?=$call['details'];?></p>
	<p><textarea name="updatedetails" id="updatedetails" rows="10" cols="40"></textarea></p>
	<p class="buttons">
		<button name="close" value="close" type="submit">Close Call</button>
		<button name="update" value="update" type="submit">Update Call</button>
	</p>
	<p class="callfooter">Call Opened <?=date("d/m/y h:s", strtotime($call['opened']));?><br />Last Update <?=date("d/m/y h:s", strtotime($call['lastupdate']));?></p>
	</form>
	</div>
	<?php } ?>
