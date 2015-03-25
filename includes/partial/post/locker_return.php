<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
	//update call
	$STH = $DBH->Prepare('UPDATE calls SET lockerid=null WHERE callid = :callid');
	$STH->bindParam(':callid', $_POST['id'], PDO::PARAM_INT);
	$STH->execute();
?>
<h2>Ticket #<?php echo($_POST['id']);?> Updated</h2>
<p>Ticket has been updated to show when the user collected the item.</p>