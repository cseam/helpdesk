<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
	<?php
	// load functions
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');	
	// check authentication
	if (empty($_SESSION['sAMAccountName'])) { prompt_auth($_SERVER['REQUEST_URI']); };
	?>
	<head>
		<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'); ?>
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

if (isset($_POST['forward'])) {
	echo "<h2>Call forwarded</h2>";
	echo "<p>Call #" . $_POST['id'] . " has been forwarded, and call details have been updated.</p>";
	echo "<p><a href='/'>Home</a></p>";
	// Update Message
	$reasonstr = "<div class=update><h3>Call forwarded (".date("l jS \of F Y h:i:s A").") for the following reason,</h3>".$_POST['details']."</div>";
	// Create SQL for reassign
	$sqlstr = "UPDATE calls ";
	$sqlstr .= "SET ";
	$sqlstr .= "helpdesk='".$_POST['fwdhelpdesk']."', ";
	$sqlstr .= "assigned='".next_engineer(check_input($_POST['fwdhelpdesk']))."', ";
	$sqlstr .= "lastupdate='" . date("c") . "', ";
	$sqlstr .= "details=CONCAT(details,'".mysqli_real_escape_string($db, $reasonstr)."') ";
	$sqlstr .= "WHERE callid='" . mysqli_real_escape_string($db, $_POST['id']) . "'";
	// Run Query
	mysqli_query($db, $sqlstr);
	// Update engineers assignment
	mysqli_query($db, "UPDATE assign_engineers SET engineerId = '". next_engineer(check_input($_POST['fwdhelpdesk'])) ."' WHERE id='".$_POST['fwdhelpdesk']."'");
}

if (isset($_POST['reassign'])) {
	echo "<h2>Call Reassigned</h2>";
	echo "<p>Call #" . $_POST['id'] . " has been reassigned, and call details have been updated.</p>";
	echo "<p><a href='/'>Home</a></p>";
	// Update Message
	$reasonstr = "<div class=update><h3>Call reassigned (".date("l jS \of F Y h:i:s A").") for the following reason,</h3>".$_POST['details']."</div>";
	// Create SQL for reassign
	$sqlstr = "UPDATE calls ";
	$sqlstr .= "SET assigned=".$_POST['engineer'].", ";
	$sqlstr .= "status=1, ";
	$sqlstr .= "lastupdate='" . date("c") . "', ";
	$sqlstr .= "details=CONCAT(details,'".mysqli_real_escape_string($db, $reasonstr)."') ";
	$sqlstr .= "WHERE callid='" . mysqli_real_escape_string($db, $_POST['id']) . "'";
	// Run Query
	mysqli_query($db, $sqlstr);

}

if (isset($_POST['close'])) {
		// Check for image
		if (is_uploaded_file($_FILES['attachment']['tmp_name']))  {
			//get the uploaded file information
			$salt = "HD" . substr(md5(microtime()),rand(0,26),5);
			$name_of_uploaded_file = $salt . basename($_FILES['attachment']['name']);
			//move the temp. uploaded file to uploads folder and salt for duplicates
			$folder = "/var/www/html/helpdesk/uploads/" . $name_of_uploaded_file;
			$tmp_path = $_FILES["attachment"]["tmp_name"];
			move_uploaded_file($tmp_path, $folder);
			$upload_img_code = "<img src=/uploads/" . $name_of_uploaded_file . " width=100% />";
		}
        // close call
       $sqlstr = "UPDATE calls ";
       $sqlstr .= "SET closed='" . date("c") . "', ";
       $sqlstr .= "status=2, ";
       if ($_POST['callreason'] > 0) { $sqlstr .= "callreason=" . $_POST['callreason'] . ", "; };
       $sqlstr .= "lastupdate='" . date("c") . "', ";
       $sqlstr .= "closeengineerid='".$_SESSION['engineerId']."',";
       $sqlstr .= "details='" . mysqli_real_escape_string($db,$_POST['details']) . "<div class=update>"  . $upload_img_code . mysqli_real_escape_string($db,$_POST['updatedetails']) . " <h3> Closed By ".$_SESSION['sAMAccountName'].", " . date("d/m/y h:i") . " </h3></div>'";
       $sqlstr .= "WHERE callid='" . mysqli_real_escape_string($db,$_POST['id']) . "'";
       // Run query
       mysqli_query($db, $sqlstr);
       // Email stakeholder
       $contact = mysqli_query($db, "SELECT email FROM calls WHERE callid='".$_POST['id']."'");
       $row = $contact->fetch_object();
       $to = $row->email;
       $message = "<p>Helpdesk (#" . $_POST['id'] .") has been closed</p>";
       $message .= "<p>To view the details of this call please <a href='". $helpdeskloc ."/viewcall.php?id=" . $_POST['id'] ."'>visit helpdesk</a></p>";
       $message .= "<p>this is an automated message please do not reply, to update your call please <a href='". $helpdeskloc ."'>Visit helpdesk</a></p>";
       $message .= "<p>you can provide confidential feedback to the engineers line manager, let us know how well your call was dealt with <a href='". $helpdeskloc ."/feedback.php?id=" . $_POST['id'] ."'>Provide Feedback</a></p>";
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
       echo "<p>Call #" . $_POST['id'] . " has been updated and closed, email sent.</p>";
       echo "<p><a href='/'>Home</a></p>";
    }
if (isset($_POST['update'])) {
		// Check for image
		if (is_uploaded_file($_FILES['attachment']['tmp_name']))  {
			//get the uploaded file information
			$salt = "HD" . substr(md5(microtime()),rand(0,26),5);
			$name_of_uploaded_file = $salt . basename($_FILES['attachment']['name']);
			//move the temp. uploaded file to uploads folder and salt for duplicates
			$folder = "/var/www/html/helpdesk/uploads/" . $name_of_uploaded_file;
			$tmp_path = $_FILES["attachment"]["tmp_name"];
			move_uploaded_file($tmp_path, $folder);
			$upload_img_code = "<img src=/uploads/" . $name_of_uploaded_file . " width=100% />";
		}
		// update call
		$sqlupdatestr = "UPDATE calls ";
		$sqlupdatestr .= "SET status=1, ";
		$sqlupdatestr .= "lastupdate='" . date("c") . "', ";
		$sqlupdatestr .= "closed=NULL, ";
		$sqlupdatestr .= "callreason=NULL, ";
		$sqlupdatestr .= "details='".  mysqli_real_escape_string($db,$_POST['details']) . "<div class=update>" . $upload_img_code .  mysqli_real_escape_string($db,$_POST['updatedetails']) . " <h3> Update By ".$_SESSION['sAMAccountName'].", " . date("d/m/y h:i") . "</h3></div>'";
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
        echo "<p>Call #" . $_POST['id'] . " has been updated, email sent to update users.</p>";
        echo "<p><a href='/'>Home</a></p>";
}

} ?>
</div>
		</div>
	</div>
	</div>
	</body>
</html>