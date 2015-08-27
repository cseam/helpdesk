<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

	// Prepare sql selecting only out of hours for correct id
	$STH = $DBH->Prepare("SELECT * FROM changecontrol WHERE id = :id");
	// bind id from form
	$STH->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
	// execute statment
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	// while results loop details to view
	while($row = $STH->fetch()) { ?>
	<h1>Change Control #<?php echo($row->id);?></h1>
	<fieldset>
		<legend>Details</legend>
		<h3><?php echo($row->server);?></h3>
		<p><?php echo(nl2br($row->changemade));?></p>
		<p><?php echo(engineer_friendlyname($row->engineersid));?> - <?= date("d/m/Y @ h:s", strtotime($row->stamp)) ?></p>
		<p><em><?php echo($row->tags);?></em></p>
	</fieldset>
	<?php } ?>