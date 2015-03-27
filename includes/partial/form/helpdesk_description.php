<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

	// populate helpdesk details from db
	$STH = $DBH->Prepare("SELECT * FROM helpdesks WHERE id = :id");
	$STH->bindParam(':id', $_GET['id'], PDO::PARAM_STR);
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	while($row = $STH->fetch()) { ?>
	<p><?php echo($row->description);?></p>
<?php };