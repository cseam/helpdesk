<?php
	// start sessions
	session_start();
	// load functions
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
	//Check if enginner logging out
	if ($_SESSION['engineerId'] !== null) {
		// Update db enginner status out
		mysqli_query($db, "UPDATE engineers_status SET status=0 WHERE id=" . $_SESSION['engineerId'] . ";");
		// Update db enginner punchcard
		mysqli_query($db, "INSERT INTO engineers_punchcard (engineerid, direction, stamp) VALUES ('" .$_SESSION['engineerId'] ."','0','".date("c")."');");
	};
	// Destroy session
	session_destroy();
	// redirect to login
	die("<script>location.href = '/'</script>");
?>