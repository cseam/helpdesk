<h2>Open Calls</h2>
<?php session_start();?>
<?php
	// load functions
	include_once '../includes/functions.php';
?>

<div id="ajaxforms">
	<table>
	<tbody>
	<?php 
		//run select query
		$result = mysqli_query($db, "SELECT * FROM calls INNER JOIN engineers ON calls.assigned=engineers.idengineers INNER JOIN status ON calls.status=status.id WHERE status='1' ORDER BY callID");
		if (mysqli_num_rows($result) == 0) { echo "<p>All calls Closed</p>";};
		while($calls = mysqli_fetch_array($result))  {
		?>
		<tr>
		<td>#<?=$calls['callid'];?></td>
		<td>
		
		<? if ($calls['status'] ==='2') { 
			echo "<span class='closed'>Closed</span>";
			} else { 
			echo date("d/m/y", strtotime($calls['opened']));
			};
		?></td>
		<td>
			<form method="post">
				<input type="hidden" id="id" name="id" value="<?=$calls['callid'];?>" />
				<button name="submit" value="submit" type="submit" class="calllistbutton"><?=substr(strip_tags($calls['details']), 0, 40);?>...</button>
			</form>
		</td>
		<td><?=substr($calls['engineerName'], 0, 12);?></td>
		
		
		</tr>
	<? } ?>
	</tbody>
	</table>
</div>
	<script type="text/javascript">
    // Ajax form submit
    $('form').submit(function(e) {
        // Post the form data to viewcall
        $.post('viewcallpost.php', $(this).serialize(), function(resp) {
            // return response data into div
            $('#ajax').html(resp);
        });
        // Cancel the actual form post so the page doesn't refresh
        e.preventDefault();
        return false;
    });     
    </script>
