<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
	<head>
	<?php
	// load functions
	include_once 'includes/functions.php';
	// check authentication 
	if (empty($_SESSION['sAMAccountName'])) { prompt_auth($_SERVER['REQUEST_URI']); } else 
	
	{ 
	// forward to correct page depending on user
		if ($_SESSION['engineerLevel'] == "1") {
			// forward to engineer page
			die("<script>location.href = '/engineerview.php'</script>");
		} else if ($_SESSION['engineerLevel'] == "2") {
			// forward to manager page
			die("<script>location.href = '/engineerview.php'</script>");
		} else {
			// forward to new call page
			die("<script>location.href = '/add.php'</script>");
	    };
	};
	?>
	</head>
	<body>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js" type="text/javascript"></script>	
	<script src="javascript/jquery.js" type="text/javascript"></script>
	</body>
</html>