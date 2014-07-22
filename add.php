<!DOCTYPE html>
<html lang="en">
	<?php
	// load functions
	include 'includes/functions.php';
	?>
	<head>
		<title><?php echo $codename?> - Add</title>
		<link rel="shortcut icon" href="clcfavicon.ico" type="image/x-icon" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" /> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="robots" content="nofollow" />
		<link rel="stylesheet" type="text/css" href="css/reset.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
	</head>
	<body>
	<div class="section">
	
	<div class="enviro">
	<?php
	// check environment
	echo environ();
	?>
	</div>
	<h2>Add Form</h2>
	<?php if ($_SERVER['REQUEST_METHOD']== "POST") { ?>
	<div class="enviro">
		<h3>Form Posted</h3>
		<?php echo check_input($_POST['name'])  ?><br/>
		<?php echo check_input($_POST['email'])  ?><br/>
		<?php echo check_input($_POST['urgency'])  ?><br/>
		<?php echo check_input($_POST['location'])  ?><br/>
		<?php echo check_input($_POST['room'])  ?><br/>
		<?php echo check_input($_POST['category'])  ?><br/>
		<?php echo check_input($_POST['title'])  ?><br/>
		<?php echo check_input($_POST['details']) ?><br/>
		<?php echo next_engineer() ?><br/>
	</div>	
	<?php
		// Create Query	
		$sqlstr = "INSERT INTO calls ";
		$sqlstr .= "(name, email, title, details, assigned, opened, urgency, location, room, category) ";
		$sqlstr .= "VALUES (";
		$sqlstr .= " ' " . check_input($_POST['name']) . " ',";
		$sqlstr .= " ' " . check_input($_POST['email']) . " ',";
		$sqlstr .= " ' " . check_input($_POST['title']) . " ',";
		$sqlstr .= " ' " . check_input($_POST['details']) . " ',";
		$sqlstr .= " ' " . next_engineer() . " ',";
		$sqlstr .= " ' " . date("c") . " ',";
		$sqlstr .= " ' " . check_input($_POST['urgency']) . " ',";
		$sqlstr .= " ' " . check_input($_POST['location']) . " ',";
		$sqlstr .= " ' " . check_input($_POST['room']) . " ',";
		$sqlstr .= " ' " . check_input($_POST['category']) . " ' ";
		$sqlstr .= ")";
		// Run Query
		mysqli_query($db, $sqlstr); 
		// Update engineers assignment
		mysqli_query($db, "UPDATE assign_engineers SET engineerId = '". next_engineer() ."' WHERE id='1'");
		// Close Connection
		mysqli_close($db);
	
	 } else {?>
	 	
	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
	<fieldset>
		<legend>form post to php_self</legend>
		<label for="name">Your Name</label>
			<input type="text" id="name" name="name" value="<?php echo check_input($_POST['name']) ?>" />
		<label for="email">Your Email</label>
			<input type="text" id="email" name="email" value="<?php echo check_input($_POST['email']) ?>" />
		<label for="category">Category</label>
			<select id="category" name="category">
				<option value="option1" >Option 1</option>
				<option value="option2" >Option 2</option>
				<option value="option3" >Option 3</option>
			</select>
		<label for="urgency">Urgency</label>
			<select id="urgency" name="urgency">
				<option value="1">Low</option>
				<option value="2">Normal</option>
				<option value="3">High</option>
			</select>
		<label for="location">Location</label>
			<select id="location" name="location">
				<option value="Main Site">Main Site</option>
			</select>
		<label for="room">Room</label>
			<input type="text" id="room" name="room" value="<?php echo check_input($_POST['room'])?>" />
		<label for="title">Title</label>
			<input type="text" id="title" name="title" value="<?php echo check_input($_POST['title']) ?>"/>
		<label for="details">Details</label>
			<textarea name="details" id="details" rows="10" cols="40"><?php echo check_input($_POST['details']) ?></textarea>
	</fieldset>
	
	<input type="submit" value="submit" /><input type="reset" value="clear" />
	</form>
	<?php 
		// End of if else statment
	} ?>

	<ul>
		<li><a href="index.php"><?php echo $codename?> Home</a></li>
	</ul>
	</div>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js" type="text/javascript"></script>	
	<script src="javascript/jquery.js" type="text/javascript"></script>
	</body>
</html>