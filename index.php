<?php
	// start sessions
	session_start();
	// load config and functions
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
	// check to see if user is logged in or not
	if (empty($_SESSION['sAMAccountName'])) {
			prompt_auth($_SERVER['REQUEST_URI']);
	};
	// display correct view (will be consolodated into 1 view later)
	SWITCH ($_SESSION['engineerLevel']) {
		CASE 2:
			include_once($_SERVER['DOCUMENT_ROOT'] . '/views/manager.php');
			break;
		CASE 1:
			include_once($_SERVER['DOCUMENT_ROOT'] . '/views/engineer.php');
			break;
		DEFAULT:
			include_once($_SERVER['DOCUMENT_ROOT'] . '/views/user.php');
			break;
	};