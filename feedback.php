<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
	<?php
	// load functions
	include_once 'includes/functions.php';
	
	?>
	<head>
		<title><?=$codename;?> - Feedback</title>
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
		<h3>Feedback</h3>
		<p>We always welcome your comments, your time is appreciated, what have we done well? or how can we improve? all your comments will be provided to the line manager.</p>
		<p>Comments aren't provided to the engineer directly and are confidential.</p>
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
	<p>your comments have been passed to the engineers line manager Thank you for taking the time to provide feedback.</p>
	<ul>
		<li><a href="add.php">Add Helpdesk Call</a></li>
	</ul>
	<?php
			
		// Create Query	
		$sqlstr = "INSERT INTO feedback ";
		$sqlstr .= "(callid, satisfaction, details, opened) ";
		$sqlstr .= "VALUES (";
		$sqlstr .= " '" . check_input($_POST['callid']) . "',";
		$sqlstr .= " '" . check_input($_POST['satisfaction']) . "',";
		$sqlstr .= " '" . check_input($_POST['details']) . "',";
		$sqlstr .= " '" . date("c") . "'";
		$sqlstr .= ")";
		// Run Query
		mysqli_query($db, $sqlstr); 
		// Close Connection
		mysqli_close($db);
	
	 } else {?>
	<h1>Call Feedback</h1>	 	
	<form action="<?=htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" enctype="multipart/form-data" id="addForm">
	<fieldset>
		<legend>Satisfaction</legend>
		<label for="satisfaction1"><img src="/images/star.png" alt="star" /></label><input type="radio" id="satisfaction1" name="satisfaction" value="1"> 
		<label for="satisfaction2"><img src="/images/star.png" alt="star" /><img src="/images/star.png" alt="star" /></label><input type="radio" id="satisfaction2" name="satisfaction" value="2"> 
		<label for="satisfaction3"><img src="/images/star.png" alt="star" /><img src="/images/star.png" alt="star" /><img src="/images/star.png" alt="star" /></label><input type="radio" id="satisfaction3" name="satisfaction" value="3"> 
		<label for="satisfaction4"><img src="/images/star.png" alt="star" /><img src="/images/star.png" alt="star" /><img src="/images/star.png" alt="star" /><img src="/images/star.png" alt="star" /></label><input type="radio" id="satisfaction4" name="satisfaction" value="4"> 
		<label for="satisfaction5"><img src="/images/star.png" alt="star" /><img src="/images/star.png" alt="star" /><img src="/images/star.png" alt="star" /><img src="/images/star.png" alt="star" /><img src="/images/star.png" alt="star" /></label><input type="radio" id="satisfaction5" name="satisfaction" value="5"> 
		<input type="hidden" id="callid" name="callid" value="<?=$_GET['id'];?>" />
	</fieldset>	
	<fieldset>
		<legend>Details</legend>
		<label for="details">Comments</label>
			<textarea name="details" id="details" rows="10" cols="40"  required></textarea>
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
			rules: {}
		});
	</script>
	</body>
</html>