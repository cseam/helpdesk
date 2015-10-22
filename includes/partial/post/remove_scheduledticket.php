<?php
	// start sessions
	session_start();
	//load functions
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
	// check if authenticated
	if (empty($_SESSION['sAMAccountName'])) { prompt_auth($_SERVER['REQUEST_URI']); };
	// post passes over ticket id once ticket id is passed populate page
	if ($_SERVER['REQUEST_METHOD']== "POST") { 
		
		// Remove scheduled ticket
		$STH = $DBH->Prepare("DELETE FROM scheduled_calls WHERE callid = :callid");
		$STH->bindParam(":callid", $_POST['id'], PDO::PARAM_STR);
		$STH->setFetchMode(PDO::FETCH_OBJ);
		$STH->execute();
		// Update View
		echo ("<p>Scheduled Ticket Removed</p>");
	}
?>