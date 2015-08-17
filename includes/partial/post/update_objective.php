<?php
	// start sessions
	session_start();
	// load functions
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

	// Process post
	if ($_SERVER['REQUEST_METHOD']== "POST") {
	
		//if Update ticket
		if (isset($_POST['update'])) {
	
			// Create update message for db
			$reason = "<div class=update>" . htmlspecialchars($_POST['updatedetails']) . "<h3> Update By ".$_SESSION['sAMAccountName'].", " . date("d/m/y H:i") . " Progress " . htmlspecialchars($_POST['progress']) . "%</h3></div>";
			// PDO update ticket
			$STH = $DBH->Prepare("UPDATE performance_review_objectives SET status = 1, progress = :progress, details = CONCAT(details, :details) WHERE id = :id");
			$STH->bindParam(':details', $reason, PDO::PARAM_STR);
			$STH->bindParam(':progress', $_POST['progress'], PDO::PARAM_STR);
			$STH->bindParam(':id', $_POST['id'], PDO::PARAM_STR);
			$STH->execute();

			// update view
			echo("<h2>Objective updated</h2><p>objective has been updated.</p>");
		}
	}
?>
<script type="text/javascript"> 
	update_div('#engineerscallview','reports/list_my_performance_objectives.php');
</script>