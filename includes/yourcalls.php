<div id="ajaxforms">
	<table id="yourcalls">
	<tbody>
	<?php 
		$result = mysqli_query($db, "SELECT * FROM calls WHERE owner='". $_SESSION['sAMAccountName']  ."' ORDER BY callid DESC LIMIT 10");
			if (mysqli_num_rows($result) == 0) { echo "<p>No calls logged, please start by filling in the form on the right.</p>"; };
			while($calls = mysqli_fetch_array($result))  { ?>
		<tr>
		<td>#<?php echo $calls['callid'];?></td>
		<td><?php if ($calls['status'] == '2') { echo "<span class='closed'>CLOSED</span>"; } else { echo date("d/m/y", strtotime($calls['opened']));} ?></td>
		<td class="view_td"><?php echo substr(strip_tags($calls['details']), 0, 120);?>...</td>
		<td>
			<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="yourcallslist">
				<input type="hidden" id="id" name="id" value="<?php echo $calls['callid'];?>" />
				<input type="image" name="submit" value="submit" src="/images/ICONS-view@2x.png" width="24" height="25" class="icon" alt="View Call" title="View Call"/>
			</form>
		</td>
		</tr>
	<? }; ?>
	</tbody>
	</table>
</div>
<script type="text/javascript"> 
	$('.yourcallslist').submit(function(e) {
		$.ajax(
			{
				type: 'post',
				url: '/viewcallpost.php',
				data: $(this).serialize(),
				beforeSend: function()
				{
				$('#ajax').html('<img src="/images/spinny.gif" alt="loading" class="loading"/>');
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