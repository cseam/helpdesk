<?php 
	// are there any urgent calls?
	$result = mysqli_query($db, "SELECT * FROM calls WHERE urgency='3' AND status='1'");
	// display results if found
	if(mysqli_num_rows($result) > 0) {
?>
<h3> Urgent Calls</h3>
<div id="ajaxforms">
	<table>
	<tbody>
	<?php 
		while($calls = mysqli_fetch_array($result))  {
		?>
		<tr>
		<td><a href="viewcall.php?id=<?=$calls['callid'];?>">#<?=$calls['callid'];?></a></td>
		<td><?=date("d/m/y h:s", strtotime($calls['opened']));?></td>
		<td class="view_td">
			<form method="post">
				<input type="hidden" id="id" name="id" value="<?=$calls['callid'];?>" />
				<button name="submit" value="submit" type="submit" class="calllistbutton"><?=substr(strip_tags($calls['details']), 0, 145);?>...</button>
			</form>
		</td>
		</tr>
	<? } ?>
	</tbody>
	</table>
</div>
<?php } ?>		
