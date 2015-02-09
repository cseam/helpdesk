<?php
	session_start();

	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

	if (empty($_SESSION['sAMAccountName'])) {
			prompt_auth($_SERVER['REQUEST_URI']);
	} else {
		if ($_SESSION['engineerLevel'] === "2") {
			die("<script>location.href = '/managerview.php'</script>");
		} else if ($_SESSION['engineerLevel'] === "1") {
			die("<script>location.href = '/engineerview.php'</script>");
		} else {
			die("<script>location.href = '/add.php'</script>");
	    };
	};
