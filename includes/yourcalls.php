<div id="ajaxforms">
	<table>
	<tbody>
	<?php 
		//run select query
		$result = mysqli_query($db, "SELECT * FROM calls WHERE owner='". $_SESSION['sAMAccountName']  ."' ORDER BY callid DESC");
		if (mysqli_num_rows($result) == 0) { echo "<p>No calls logged, please start by filling in the form on the right.</p>";};
		while($calls = mysqli_fetch_array($result))  {
		?>
		<tr>
		<td>#<?=$calls['callid'];?></td>
		<td><?php if ($calls['status'] == '2') { echo "<span class='closed'>CLOSED</span>";} else { echo date("d/m/y", strtotime($calls['opened']));} ?></td>
		<td class="view_td"><?=substr(strip_tags($calls['details']), 0, 120);?>...</td>
		<td>
		<form method="post">
				<input type="hidden" id="id" name="id" value="<?=$calls['callid'];?>" />
				<button name="submit" value="submit" type="submit" class="calllistbutton">View</button>
			</form>
		</td>
		</tr>
	<? } ?>
	</tbody>
	</table>
</div>
	
		
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js" type="text/javascript"></script>	
	<script src="javascript/jquery.js" type="text/javascript"></script>
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