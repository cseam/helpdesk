<?php session_start();?>
<?php
	// load functions
	include_once '../includes/functions.php';

?>
<?php if ($_SERVER['REQUEST_METHOD']== "POST" & $_POST['toggle'] == TRUE) { ?>
<h2>Punchcard in/out</h2>
<?
	$sqlstr = "DELETE FROM engineers_status WHERE id = " . $_POST['id'] . ";";
	$result = mysqli_query($db, $sqlstr);	

	$whichtoggle = "cmn-toggle-" . $_POST['id'];
	if ($_POST[$whichtoggle] == 'on') {
		$togglevalue = 1;
	} else {
		$togglevalue = 0;
	}

	$sqlstr = "INSERT INTO engineers_status (id, status) VALUES ('". $_POST['id'] ."','". $togglevalue ."');";
	$result = mysqli_query($db, $sqlstr);
	 } ?>


<?php
	$sqlstr = "SELECT * FROM engineers LEFT JOIN engineers_status ON engineers_status.id=engineers.idengineers;";
	$result = mysqli_query($db, $sqlstr);	
?>
<table>
<tr>
	<th>Engineer Name</th>
	<th>Status IN/OUT</th>
</tr>
<?php
	while($calls = mysqli_fetch_array($result))  {
?>
<tr>
	<td><?=$calls['engineerName'];?></td>
	<td>
		<div class="switch" style="float:left;">
			<form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="toggleform" >
				<input type="hidden" id="toggle" name="toggle" value="TRUE" />
				<input type="hidden" id="id" name="id" value="<?=$calls['idengineers'];?>" />
				<input id="cmn-toggle-<?=$calls['idengineers']?>" name="cmn-toggle-<?=$calls['idengineers']?>" class="cmn-toggle cmn-toggle-round" type="checkbox" <? if ($calls['status'] == 1) { ?>checked="true" <?}?>>
				<label for="cmn-toggle-<?=$calls['idengineers']?>"></label>
			</form>
		</div>
		
	<?
		if ($calls['status'] == NULL or $calls['status'] == 0) { 
			echo " &mdash; OUT";
		} else {
			echo " &mdash; IN";
		}?>
		
		</td>
</tr>
<?php
	}
?>
</table>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js" type="text/javascript"></script>	
	<script src="javascript/jquery.js" type="text/javascript"></script>
	<script type="text/javascript">  
    $('.toggleform').change(function(e) {
    	$.ajax(
			{
				type: 'post',
				url: '/includes/managerreport-punchcard.php',
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

