<!DOCTYPE html>
<html lang="en">
	<?php
	include 'includes/functions.php';
	?>
	<head>
		<title><?=$codename;?> - All Calls</title>
		<link rel="shortcut icon" href="clcfavicon.ico" type="image/x-icon" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" /> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="robots" content="nofollow" />
		<link rel="stylesheet" type="text/css" href="css/reset.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
	</head>
	<body>
	<div class="section">
	<h2>* From Calls Table</h2>
	<div id="#ajaxforms">
	<table>
	<thead>
		<tr>
			<th>Call ID</th>
			<th>Opened</th>
			<th>Details</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php 
		//run select query
		$result = mysqli_query($db, "SELECT * FROM calls");
		while($calls = mysqli_fetch_array($result))  {
		?>
		<tr>
		<td>#<?=$calls['callid'];?></td>
		<td><?=date("d/m/y h:s", strtotime($calls['opened']));?></td>
		<td><a href="viewcall.php?id=<?=$calls['callid'];?>"><?=substr($calls['details'], 0, 100);?></a></td>
		<td>
			<form method="post">
				<input type="hidden" id="id" name="id" value="<?=$calls['callid'];?>" />
				<button name="submit" value="submit" type="submit">View</button>
			</form>
		</td>
		</tr>
	<? } ?>
	</tbody>
	</table>
	</div>
	
	<div id="ajax"></div>
		
	<ul>
		<li><a href="index.php"><?=$codename;?> Home</a></li>
	</ul>
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
	</body>
</html>