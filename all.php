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
	<p>
	<form action="<?=htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
	<table>
	<thead>
		<tr>
			<th>Call ID</th>
			<th>Opened</th>
			<th>Details</th>
			<th>Button</th>
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
		<td>Submit</td>
		</tr>
	<? } ?>
	</tbody>
	</table>
	</form>
	</p>
	
	
	<div id="div2">ajax div</div>

	<script>
    // When the form is submitted run this JS code
    $('form').submit(function(e) {
        // Post the form data to page.php
        $.post('viewcallpost.php', $(this).serialize(), function(resp) {
            // Set the response data into the #div2
            $('#div2').html(resp);
        });

        // Cancel the actual form post so the page doesn't refresh
        e.preventDefault();
        return false;
    });
    </script>
	
	
	<ul>
		<li><a href="index.php"><?=$codename;?> Home</a></li>
	</ul>
	</div>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js" type="text/javascript"></script>	
	<script src="javascript/jquery.js" type="text/javascript"></script>
	</body>
</html>