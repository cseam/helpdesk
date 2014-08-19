<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
	<?php
	// load functions
	include_once 'includes/functions.php';
	
	?>
	<head>
		<title><?=$codename;?> - Add Call</title>
		<link rel="shortcut icon" href="clcfavicon.ico" type="image/x-icon" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" /> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="robots" content="nofollow" />
		<link rel="stylesheet" type="text/css" href="css/reset.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
	</head>
	<body>
	<div class="section">
	<div id="branding">
		<?php include 'includes/nav.php'; ?>
	</div>
	
	<div id="leftpage">
	<div id="stats">
		<h3>Information</h3>
		<p>Welcome to helpdesk <?=$_SESSION['sAMAccountName'];?>, please use the form to log calls for engineers, once your call has been logged you will receive email feedback on your issue, you can also return here at any time to see the status of your calls.</p>
		<p>Please remember the more information you can provide the quicker the engineer can fix your problem, for example when your printer is out of ink please include as much information as possible, printer model, colour of ink cartridge, room the printer is in. etc.. this saves the engineer asking these questions at a later point.</p>
	</div>
	<div id="calllist">
		<h3>Your Helpdesks</h3>
		<?php include 'includes/yourcalls.php'; ?>
	</div>
	</div>
	<div id="rightpage">
		<div id="addcall">
			<div id="ajax">
	<?php if ($_SERVER['REQUEST_METHOD']== "POST") { ?>
	<h2>Thank you</h2>
	<p>Your Helpdesk has been added. Your call has been assigned to <?=engineer_friendlyname(next_engineer());?>, the enginner will be in touch shortly. should  they require additional information, correspondence will be emailed to the contact address you entered in the form.</p>
	<p>Please check your email for further details.</p>
	<ul>
		<li><a href="add.php">Add another Call</a></li>
	</ul>
	<?php
		// Upload attachments & move
		if (is_uploaded_file($_FILES['attachment']['tmp_name']))  {  	
			//get the uploaded file information
			$salt = "HD" . substr(md5(microtime()),rand(0,26),5);
			$name_of_uploaded_file = $salt . basename($_FILES['attachment']['name']); 
			//move the temp. uploaded file to uploads folder and salt for duplicates
			$folder = "/var/www/html/helpdesk/uploads/" . $name_of_uploaded_file;
			$tmp_path = $_FILES["attachment"]["tmp_name"];
			move_uploaded_file($tmp_path, $folder);
		}
	
		// Calculate Urgency
		$urgencystr = round( (check_input($_POST['callurgency']) + check_input($_POST['callseverity'])) / 2 ); 
			
		// Create Query	
		$sqlstr = "INSERT INTO calls ";
		$sqlstr .= "(name, email, tel, details, assigned, opened, lastupdate, urgency, location, room, category, owner, attachmentname) ";
		$sqlstr .= "VALUES (";
		$sqlstr .= " '" . check_input($_POST['name']) . "',";
		$sqlstr .= " '" . check_input($_POST['email']) . "',";
		$sqlstr .= " '" . check_input($_POST['tel']) . "',";
		$sqlstr .= " '<div class=original>" . check_input($_POST['details']) . "</div>',";
		$sqlstr .= " '" . next_engineer() . "',";
		$sqlstr .= " '" . date("c") . "',";
		$sqlstr .= " '" . date("c") . "',";
		$sqlstr .= " '" . $urgencystr . "',";
		$sqlstr .= " '" . check_input($_POST['location']) . "',";
		$sqlstr .= " '" . check_input($_POST['room']) . "',";
		$sqlstr .= " '" . check_input($_POST['category']) . "',";
		$sqlstr .= " '" . $_SESSION['sAMAccountName'] . "',";
		$sqlstr .= " '" . $name_of_uploaded_file . "'";
		$sqlstr .= ")";
		// Run Query
		mysqli_query($db, $sqlstr); 
		// Update engineers assignment (id hard coded for dev needs to be specific to department if they want round robin)
		mysqli_query($db, "UPDATE assign_engineers SET engineerId = '". next_engineer() ."' WHERE id='1'");
		// Close Connection
		mysqli_close($db);
	
	 } else {?>
	<h1>Add Call</h1>	 	
	<form action="<?=htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" enctype="multipart/form-data" id="addForm">
	<fieldset>
		<legend>Primary Contact</legend>
		<label for="name">Name</label>
			<input type="text" id="name" name="name" value="<?=$_SESSION['sAMAccountName'];?>"  required />
		<label for="email">Email</label>
			<input type="text" id="email" name="email" value="<?=$_SESSION['sAMAccountName']."@".$companysuffix;?>"  required />
		<label for="tel">Telephone</label>
			<input type="text" id="tel" name="tel" value=""  required />
	</fieldset>	
	<fieldset>
		<legend>Location</legend>
		<label for="location">Site</label>
			<select id="location" name="location">
				<option value="" SELECTED>Please Select</option>
				<?php 
					$locations = mysqli_query($db, "SELECT * FROM location ORDER BY locationName");
					while($option = mysqli_fetch_array($locations))  { ?>
					<option value="<?=$option['id'];?>"><?=$option['locationName'];?></option>
				<? } ?>
			
			</select>
		<label for="room">Room</label>
			<input type="text" id="room" name="room" value="" required />
	</fieldset>
	<fieldset>
		<legend>Scope</legend>	
		<label for="callurgency">Urgency</label>
			<select id="callurgency" name="callurgency">
				<option value="1">An alternative is available</option>
				<option value="2">This is affecting my work</option>
				<option value="3">I cannot work</option>
			</select>	
		<label for="callseverity">Severity</label>	
			<select id="callseverity" name="callseverity">
				<option value="1">This problem affects only me</option>
				<option value="2">This problem affects multiple people</option>
				<option value="3">This problem affects all of <?=$companyname;?></option>
			</select>		
	</fieldset>
	<fieldset>
		<legend>Details</legend>
		<label for="category">Type</label>
			<select id="category" name="category">
			<option value="" SELECTED>Please Select</option>
				<?php
					$categories = mysqli_query($db, "SELECT * FROM categories ORDER BY categoryName");
					while($option = mysqli_fetch_array($categories))  { ?>
					<option value="<?=$option['id'];?>"><?=$option['categoryName'];?></option>
				<? } ?>
			</select>
		<label for="details">Details</label>
			<textarea name="details" id="details" rows="10" cols="40"  required></textarea>
	</fieldset>
	<fieldset>
		<legend>Attachments</legend>
		<label for="attachment">Picture or Screenshot</label>
		<input type="file" name="attachment" accept="image/*">
	</fieldset>
	
	
	<p class="buttons">
		<button name="submit" value="submit" type="submit">Submit</button>
		<button name="clear" value="clear" type="reset">Clear</button>
	</p>
	</form>
	<? } ?>
			</div>
		</div>
	</div>
	</div>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js" type="text/javascript"></script>	
	<script src="javascript/jquery.js" type="text/javascript"></script>
	<script src="javascript/jquery.validate.min.js" type="text/javascript"></script>
	<script type="text/javascript">
		$("#addForm").validate({
			rules: {
				email: {
					required: true,
					email: true
					},
				location: {
					required: true,
					},
				category: {
					required: true,
					}
				}
		});
	</script>
	</body>
</html>










