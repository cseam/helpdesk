<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

	// Prepare sql selecting only out of hours for correct id
	$STH = $DBH->Prepare("SELECT * FROM out_of_hours WHERE id = :id");
	// bind id from form
	$STH->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
	// execute statment
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	// while results loop details to view
	while($row = $STH->fetch()) { ?>
	<h1>Out of hours call #<?php echo($row->id);?></h1>
	<fieldset>
		<legend>Call Details</legend>
		<p>Engineer Called: <?php echo($row->name);?></p>
		<p>Date of Call: <?php echo($row->dateofcall);?></p>
		<p>Time of Call: <?php echo($row->timeofcall);?></p>
		<p>Call out by: <?php echo($row->calloutby);?></p>
		<p>Problem: <?php echo($row->problem);?></p>
	</fieldset>
	<fieldset>
		<legend>Off site</legend>
		<p>Problem: <?php echo($row->previsit);?></p>
	</fieldset>
	<fieldset>
		<legend>On site</legend>
		<p>Time On Site: <?php echo($row->timeonsite);?></p>
		<p>Time Left Site: <?php echo($row->timeleftsite);?></p>
		<p>Locations Visited: <?php echo($row->locations);?></p>
		<p>Resolution: <?php echo($row->resolution);?></p>
	</fieldset>



	<?php } ?>