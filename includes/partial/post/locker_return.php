<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
	$who = '<div class=update>Item collected from locker system<h3>Issued by '.$_SESSION['sAMAccountName'].','.date("d/m/y h:i").'</h3></div>';
	//update call
	$STH = $DBH->Prepare('UPDATE calls SET lockerid=null, lastupdate = :lastupdate, details = CONCAT(details, :details) WHERE callid = :callid');
	$STH->bindParam(':lastupdate', date("c"), PDO::PARAM_STR);
	$STH->bindParam(':details', $who, PDO::PARAM_STR);
	$STH->bindParam(':callid', $_POST['id'], PDO::PARAM_INT);
	$STH->execute();
?>
<h2>Item Returned - Ticket #<?php echo($_POST['id']);?> Updated</h2>
<p>Ticket has been updated to show when the user collected the item, and who issued the item.</p>