<?php session_start();?>
<?php
	// load functions
	include_once '../includes/functions.php';
	
	$sqlstr = "SELECT * FROM engineers LEFT JOIN engineers_status ON engineers_status.id=engineers.idengineers;";
	$result = mysqli_query($db, $sqlstr);	
	
?>
<table>
<tr>
	<th>Engineer Name</th>
	<th>Status</th>
	<th></th>
</tr>
<?php
	while($calls = mysqli_fetch_array($result))  {
?>
<tr>
	<td><?=$calls['engineerName'];?></td>
	<td>
		<div class="switch">
            <input id="cmn-toggle-<?=$calls['idengineers']?>" class="cmn-toggle cmn-toggle-round" type="checkbox" <? if ($calls['status'] == 1) { ?>checked="true" <?}?>>
            <label for="cmn-toggle-<?=$calls['idengineers']?>"></label>
          </div>
	</td>
	<?
		if ($calls['status'] == NULL or $calls['status'] == 0) { 
			echo "<td>OUT</td>";
		} else {
			echo "<td>IN</td>";
		}?>
</tr>
<?php
	}
?>
</table>