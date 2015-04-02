<?php
	session_start();
	if (empty($_SESSION['sAMAccountName'])) {
			echo("false");
	} else {
			echo("true");
	};