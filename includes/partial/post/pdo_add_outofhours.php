<?php
	// start sessions
	session_start();
	// load functions
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
	// process form
	if ($_SERVER['REQUEST_METHOD']== "POST") {

	// Prepare ticket insert PDO Statment
	$STH = $DBH->Prepare("INSERT INTO out_of_hours (name, dateofcall, timeofcall, calloutby, problem, previsit, timeonsite, timeleftsite, locations, resolution) VALUES (:name, :dateofcall, :timeofcall, :calloutby, :problem, :previsit, :timeonsite, :timeleftsite, :locations, :resolution)");
	// Bind post values
	$STH->bindParam(':name', $_POST['name'], PDO::PARAM_STR);
	$STH->bindParam(':dateofcall', $_POST['dateofcall'], PDO::PARAM_STR);
	$STH->bindParam(':timeofcall', $_POST['timeofcall'], PDO::PARAM_STR);
	$STH->bindParam(':calloutby', $_POST['calloutby'], PDO::PARAM_STR);
	$STH->bindParam(':problem', $_POST['problem'], PDO::PARAM_STR);
	$STH->bindParam(':previsit', $_POST['previsit'], PDO::PARAM_STR);
	$STH->bindParam(':timeonsite', $_POST['timeonsite'], PDO::PARAM_STR);
	$STH->bindParam(':timeleftsite', $_POST['timeleftsite'], PDO::PARAM_STR);
	$STH->bindParam(':locations', $_POST['locations'], PDO::PARAM_STR);
	$STH->bindParam(':resolution', $_POST['resolution'], PDO::PARAM_STR);
	// execute statement
	$STH->execute();
	// update view
	// print_r($_POST);
?>
<h2>Out of hours</h2>
<p>Your call has been logged, thank you.</p>
<button onclick="update_div('#ajax','form/add_outofhours.php')">Add another call</button>
<button onclick="update_div('#ajax','reports/list_all_outofhours.php')">View callouts</button>
<?php
	// End post check
	}


