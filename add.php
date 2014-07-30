<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
	<?php
	include 'includes/functions.php';
	?>
	<head>
		<title><?=$codename;?> - Add</title>
		<link rel="shortcut icon" href="clcfavicon.ico" type="image/x-icon" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" /> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="robots" content="nofollow" />
		<link rel="stylesheet" type="text/css" href="css/reset.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
	</head>
	<body>
	<div class="section">
	<h2>Add Form</h2>
	<?php if ($_SERVER['REQUEST_METHOD']== "POST") { ?>
	<div class="enviro">
		<h3>Form Posted</h3>
		<?=check_input($_POST['name']);?><br/>
		<?=check_input($_POST['email']);?><br/>
		<?=check_input($_POST['location']);?><br/>
		<?=check_input($_POST['room']);?><br/>
		<?=check_input($_POST['category']);?><br/>
		<?=check_input($_POST['details']);?><br/>
		<?=next_engineer();?><br/>
	</div>	
	<?php
		// Calculate Urgency
		$urgencystr = round( (check_input($_POST['callurgency']) + check_input($_POST['callseverity'])) / 2 ); 
			
		// Create Query	
		$sqlstr = "INSERT INTO calls ";
		$sqlstr .= "(name, email, tel, details, assigned, opened, lastupdate, urgency, location, room, category) ";
		$sqlstr .= "VALUES (";
		$sqlstr .= " ' " . check_input($_POST['name']) . " ',";
		$sqlstr .= " ' " . check_input($_POST['email']) . " ',";
		$sqlstr .= " ' " . check_input($_POST['tel']) . " ',";
		$sqlstr .= " '<div class=original>" . check_input($_POST['details']) . "</div>',";
		$sqlstr .= " ' " . next_engineer() . " ',";
		$sqlstr .= " ' " . date("c") . " ',";
		$sqlstr .= " ' " . date("c") . " ',";
		$sqlstr .= " ' " . $urgencystr . " ',";
		$sqlstr .= " ' " . check_input($_POST['location']) . " ',";
		$sqlstr .= " ' " . check_input($_POST['room']) . " ',";
		$sqlstr .= " ' " . check_input($_POST['category']) . " ' ";
		$sqlstr .= ")";
		// Run Query
		mysqli_query($db, $sqlstr); 
		// Update engineers assignment (id hard coded for dev needs to be specific to department if they want round robin)
		mysqli_query($db, "UPDATE assign_engineers SET engineerId = '". next_engineer() ."' WHERE id='1'");
		// Close Connection
		mysqli_close($db);
	
	 } else {?>
	 	
	<form action="<?=htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
	<fieldset>
		<legend>Call Details</legend>
		<label for="name">Primary Contact Name</label>
			<input type="text" id="name" name="name" value="<?=$_SESSION['sAMAccountName'];?>" />
		<label for="email">Primary Contact Email</label>
			<input type="text" id="email" name="email" value="<?=$_SESSION['sAMAccountName']."@".$companysuffix;?>" />
		<label for="tel">Primary Contact Phone #</label>
			<input type="text" id="tel" name="tel" value="" />
		<hr/>
		<label for="callurgency">Call Urgency</label>
			<select id="callurgency" name="callurgency">
				<option value="1">An alternative is available</option>
				<option value="2">This is affecting my work</option>
				<option value="3">I cannot work</option>
			</select>	
		<label for="callseverity">Call Severity</label>	
			<select id="callseverity" name="callseverity">
				<option value="1">This problem affects only me</option>
				<option value="2">This problem affects multiple people</option>
				<option value="3">This problem affects all of <?=$companyname;?></option>
			</select>		
		<hr/>
		<label for="category">Category</label>
			<select id="category" name="category">
				<option value="option1" >Option 1</option>
				<option value="option2" >Option 2</option>
				<option value="option3" >Option 3</option>
			</select>
		<label for="location">Location</label>
			<select id="location" name="location">
				<option value="Main Site">Main Site</option>
			</select>
		<label for="room">Room</label>
			<input type="text" id="room" name="room" value="" />
		<hr/>
		<label for="details">Problem Details</label>
			<textarea name="details" id="details" rows="10" cols="40"></textarea>
	</fieldset>
	
	<input type="submit" value="submit" /><input type="reset" value="clear" />
	</form>
	<? } ?>
	<ul>
		<li><a href="index.php"><?=$codename;?> Home</a></li>
	</ul>
	</div>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js" type="text/javascript"></script>	
	<script src="javascript/jquery.js" type="text/javascript"></script>
	</body>
</html>