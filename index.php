<?php
	session_start();

	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

	if (empty($_SESSION['sAMAccountName'])) {
			prompt_auth($_SERVER['REQUEST_URI']);
	} else {
		if ($_SESSION['engineerLevel'] === "2") {
			include_once($_SERVER['DOCUMENT_ROOT'] . '/views/manager.php');
		} else if ($_SESSION['engineerLevel'] === "1") {
			include_once($_SERVER['DOCUMENT_ROOT'] . '/views/engineer.php');
		} else {
			include_once($_SERVER['DOCUMENT_ROOT'] . '/views/user.php');
		};
	};
