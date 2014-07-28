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

<?php if ($_SERVER['REQUEST_METHOD']== "POST") { 

if (isset($_POST['close'])) {
        // close call
        // setup sqlstr
       $sqlstr = "UPDATE calls ";
       $sqlstr .= "SET closed='" . date("c") . "', ";
       $sqlstr .= "status=2, ";
       $sqlstr .= "lastupdate='" . date("c") . "', ";
       $sqlstr .= "details='<div class=update><h3>Calls Closed By {EngineerName}</h3>"  . check_input($_POST['updatedetails']) . "</div>" . check_input($_POST['details']) . "'";
       $sqlstr .= "WHERE callid=" . check_input($_POST['id']);
       // Run query
       mysqli_query($db, $sqlstr); 
       // Close Connection
       mysqli_close($db);
       echo "<h2>Call Updated & Closed #" . $_POST['id'] . "</h2>";
       echo "<p>Details: " . $_POST['details'] . "</p>";
       echo "<p>Update: " . $_POST['updatedetails'] . "</p>";
    }
if (isset($_POST['update'])) {
		// update call
		// setup sqlstr
		echo "<h2>Update Call</h2>";
        echo "<p>ID:" . $_POST['id'] . "</p>";
        echo "<p>Details: " . $_POST['details'] . "</p>";
        echo "<p>Update Details: " . $_POST['updatedetails'] . "</p>";
}

} ?>

	<ul>
		<li><a href="all.php">All Calls</a></li>
		<li><a href="index.php"><?=$codename;?> Home</a></li>
	</ul>
</div>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js" type="text/javascript"></script>	
	<script src="javascript/jquery.js" type="text/javascript"></script>
	</body>
</html>