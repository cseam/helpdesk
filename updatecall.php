<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
	<?php
	// load functions
	include 'includes/functions.php';
	?>
	<head>
		<title><?=$codename;?> - Update Calls</title>
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
		<a href="add.php">Add Call</a><br/>
		<a href="engineerview.php">Engineer view</a><br/>
	</div>
	
	<div id="leftpage">
	<div id="stats">
		<h3>Information</h3>
		<p>Welcome to helpdesk <?=$_SESSION['sAMAccountName'];?>, please use the form to log calls for engineers, once your call has been logged you will receive email feedback on your issue, you can also return here at any time to see the status of your calls.</p>
		<p>Please remember the more information you can provide the quicker the engineer can fix your problem, for example when your printer is out of ink please include as much information as possible, printer model, colour of ink cartridge, room the printer is in. etc.. this saves the engineer asking these questions at a later point and slowing down the process.</p>
	</div>
	<div id="calllist">
		<h3>Your Helpdesks</h3>
		<?php include 'includes/yourcalls.php'; ?>
	</div>
	</div>
	<div id="rightpage">
		<div id="addcall">
			<div id="ajax">
	




<?php if ($_SERVER['REQUEST_METHOD']== "POST") { 

if (isset($_POST['close'])) {
        // close call
       $sqlstr = "UPDATE calls ";
       $sqlstr .= "SET closed='" . date("c") . "', ";
       $sqlstr .= "status=2, ";
       $sqlstr .= "lastupdate='" . date("c") . "', ";
       $sqlstr .= "closeengineerid='".$_SESSION['engineerId']."',";
       // $sqlstr .= "details='<div class=update>"  . mysqli_real_escape_string($db,$_POST['updatedetails']) . " <h3>Closed By ".$_SESSION['sAMAccountName'].", " . date("d/m/y h:s") . " </h3></div>" . mysqli_real_escape_string($db,$_POST['details']) . "' ";
       $sqlstr .= "details='" . mysqli_real_escape_string($db,$_POST['details']) . "<div class=update>"  . mysqli_real_escape_string($db,$_POST['updatedetails']) . " <h3> Closed By ".$_SESSION['sAMAccountName'].", " . date("d/m/y h:s") . " </h3></div>'";
       $sqlstr .= "WHERE callid='" . mysqli_real_escape_string($db,$_POST['id']) . "'";
       // Run query
       mysqli_query($db, $sqlstr);
       // Email stakeholder
       $contact = mysqli_query($db, "SELECT email FROM calls WHERE callid='".$_POST['id']."'");
       $row = $contact->fetch_object();
       $to = $row->email;		
       $message = "<p>Your helpdesk (#" . $_POST['id'] .") has been closed</p>";
       $message .= "<p>To view the details of this call please visit helpdesk</p>"; 
       $message .= "<p><a href='". $helpdeskloc ."/viewcall.php?id=" . $_POST['id'] ."'>View Call</a></p>";
       $message .= "<p>this is an automated message please do not reply, to update your call please <a href='". $helpdeskloc ."'>Visit helpdesk</a></p>";
       $msgtitle = "Helpdesk Call #" . $_POST['id'] . " Closed";
       $headers = 'From: Helpdesk@cheltladiescollege.org' . "\r\n";
       $headers .= 'Reply-To: helpdesk@cheltladiescollege.org' . "\r\n"; 
       $headers .= 'MIME-Version: 1.0' . "\r\n";
       $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
       $headers .= 'X-Mailer: PHP/' . phpversion();	
       // In case any of our lines are larger than 70 characters, we should use wordwrap()
       $message = wordwrap($message, 70, "\r\n");
       // Send
       mail($to, $msgtitle, $message, $headers);
       echo "<h2>Updated & Closed</h2>";
       echo "<p>Call #" . $_POST['id'] . " has been updated and closed, all stake holders have been emailed.</p>";
       echo "<p><a href='/'>Home</a></p>";
    }
if (isset($_POST['update'])) {
		// update call
		$sqlupdatestr = "UPDATE calls ";
		$sqlupdatestr .= "SET status=1, ";
		$sqlupdatestr .= "lastupdate='" . date("c") . "', ";
		$sqlupdatestr .= "closed=NULL, ";
		// $sqlupdatestr .= "details='<div class=update>" .  mysqli_real_escape_string($db,$_POST['updatedetails']) . " <h3>Update By ".$_SESSION['sAMAccountName'].", " . date("d/m/y h:s") . "</h3></div>" .  mysqli_real_escape_string($db,$_POST['details']) . "' ";
		$sqlupdatestr .= "details='".  mysqli_real_escape_string($db,$_POST['details']) . "<div class=update>" .  mysqli_real_escape_string($db,$_POST['updatedetails']) . " <h3> Update By ".$_SESSION['sAMAccountName'].", " . date("d/m/y h:s") . "</h3></div>'";
		$sqlupdatestr .= "WHERE callid='" . mysqli_real_escape_string($db,$_POST['id']) . "'";
		// Run query
		mysqli_query($db, $sqlupdatestr);
		// Email stakeholder
		$contact = mysqli_query($db, "SELECT email FROM calls WHERE callid='".$_POST['id']."'");
		$row = $contact->fetch_object();
		$to = $row->email;		
		$message = "<p>Your helpdesk (#" . $_POST['id'] .") has been updated</p>";
		$message .= "<p>To view the details of this update please visit helpdesk</p>"; 
		$message .= "<p><a href='". $helpdeskloc ."/viewcall.php?id=" . $_POST['id'] ."'>View Call</a></p>";
		$message .= "<p>this is an automated message please do not reply, to update your call please <a href='". $helpdeskloc ."'>Visit helpdesk</a></p>";
		$msgtitle = "Helpdesk Call #" . $_POST['id'] . " Update";
		$headers = 'From: Helpdesk@cheltladiescollege.org' . "\r\n";
		$headers .= 'Reply-To: helpdesk@cheltladiescollege.org' . "\r\n"; 
		$headers .= 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'X-Mailer: PHP/' . phpversion();	
		// In case any of our lines are larger than 70 characters, we should use wordwrap()
		$message = wordwrap($message, 70, "\r\n");
		// Send
		mail($to, $msgtitle, $message, $headers);
		//display message
		echo "<h2>Call updated</h2>";
        echo "<p>Call #" . $_POST['id'] . " has been updated, stake holder has been emailed to update them.</p>";
        echo "<p><a href='/'>Home</a></p>";        
}

} ?>
</div>
		</div>
	</div>
	</div>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js" type="text/javascript"></script>	
	<script src="javascript/jquery.js" type="text/javascript"></script>
	</body>
</html>