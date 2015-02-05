<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
	//update call	
	$sqlstr = "UPDATE calls ";
	$sqlstr .= "SET ";
	$sqlstr .= "lockerid=null ";
	$sqlstr .= "WHERE callid='" . mysqli_real_escape_string($db, $_POST['id']) . "';";	
	mysqli_query($db, $sqlstr);
?>
<h2>Call #<?php echo($_POST['id']);?> Updated</h2>
<p>Call has been updated to show when the user collected the item.</p>
<p><a href="/">Home</a></p>