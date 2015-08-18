<?php
	// start sessions
	session_start();
	// load functions
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
	// process form
	if ($_SERVER['REQUEST_METHOD']== "POST") {

	// Prepare ticket insert PDO Statment
	$STH = $DBH->Prepare("INSERT INTO performance_review_objectives (engineerid, title, details, datedue) 
	VALUES (:engineerid, :title, :details, :datedue)");
	// Bind post values
	$STH->bindParam(':engineerid', $_POST['engineerid'], PDO::PARAM_INT);
	$STH->bindParam(':title', $_POST['title'], PDO::PARAM_STR);
	$STH->bindParam(':details', $_POST['details'], PDO::PARAM_STR);
	$STH->bindParam(':datedue', $_POST['datedue'], PDO::PARAM_STR);
	// execute statement
	$STH->execute();
	// update view
	// print_r($_POST);
?>
<h2>Performance Objectives</h2>
<p>Your objective has been added, thank you.</p>
<button onclick="update_div('#ajax','form/add_objective.php')">Add another objective</button>
<button onclick="update_div('#ajax','reports/list_all_performance_objectives.php')">View Objectives</button>
<?php
	// End post check
	}


