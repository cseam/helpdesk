<!DOCTYPE html>
<html lang="en">
	<?php
	// load functions
	include 'includes/functions.php';
	?>
	<head>
		<title><?php echo $codename?> - Engineers</title>
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
	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
	
	<?php
		// form actions
		// on submit form
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		?>
			<div class="msgbox">
			<?php
			// if form is posted & delete button clicked, delete the engineer set in the button value field.
			if (isset($_POST['btnDelete'])) {
				echo "Deleted engineer with id:" . $_POST['btnDelete'];
				mysqli_query($db, "DELETE FROM engineers WHERE idengineers = ". $_POST['btnDelete'] ." ");
			}
			// if form posted & submit button clicked, add form to engineers table.
			if (isset($_POST['btnSubmit'])) {
				echo "Engineer added (" . $_POST['name'] .")" ;
				mysqli_query($db, "INSERT INTO engineers (engineerName, engineerEmail) VALUES ('" . $_POST['name'] . "','" . $_POST['email'] . "')");
			}
		 ?>
		 </div>
		 <?php
		 // end of submit form actions
		}
	?>
	
	
	<h2>* From Engineers Table</h2>
	<p>
	<?php 
		//list current engineers
		//run select query
		$result = mysqli_query($db, "SELECT * FROM engineers");
		
		while($engineers = mysqli_fetch_array($result)) {
			$outputstr = "<button type='submit' name='btnDelete' value='" . $engineers['idengineers'] . "'>delete engineer</button>";
			$outputstr .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $engineers['engineerName'] . " - ";
			$outputstr .= $engineers['engineerEmail'] . " - ";
			$outputstr .= " (id:" . $engineers['idengineers'] . ")<br/>";
			echo $outputstr;
		}
	?>
	</p>
	
	<h2>Add Engineer</h2>
		<fieldset>
			<legend>add engineers</legend>
			<label for="name">Engineer Name</label><input type="text" id="name" name="name" value="<?php echo check_input($_POST['name']) ?>" />
			<label for="email">Engineer Email</label><input type="text" id="email" name="email" value="<?php echo check_input($_POST['email']) ?>" />
		</fieldset>
	<input type="submit" value="submit" name="btnSubmit" /><input type="reset" value="clear" />
	
	
	
	
	</form>
	<ul>
		<li><a href="index.php"><?php echo $codename?> Home</a></li>
	</ul>
	</div>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js" type="text/javascript"></script>	
	<script src="javascript/jquery.js" type="text/javascript"></script>
	</body>
</html>