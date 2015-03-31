<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
	//Check if enginner logging out
	if ($_SESSION['engineerId'] !== null) {
		// Update db enginner status out
		$STH = $DBH->Prepare("UPDATE engineers_status SET status=0 WHERE id = :id");
		$STH->bindParam(":id", $_SESSION['engineerId'], PDO::PARAM_INT);
		$STH->execute();
		// Update db enginner punchcard
		$STH = $DBH->Prepare("INSERT INTO engineers_punchcard (engineerid, direction, stamp) VALUES (:id, '0', :date)");
		$STH->bindParam(":id", $_SESSION['engineerId'], PDO::PARAM_INT);
		$STH->bindParam(":date", date("c"), PDO::PARAM_STR);
		$STH->execute();
	};
	// Destroy session
	session_destroy();
	// redirect to login
	die("<script>location.href = '/'</script>");
?>