<?php

function urgency_friendlyname($data)
{
	SWITCH ($data) {
		CASE 10:
			$friendly = "Dangerous";
			break;
		CASE 9:
			$friendly = "Extremely High";
			break;
		CASE 8:
			$friendly = "Very High";
			break;
		CASE 7:
			$friendly = "High";
			break;
		CASE 6:
			$friendly = "Moderate";
			break;
		CASE 5:
			$friendly = "Low";
			break;
		CASE 4:
			$friendly = "Very Low";
			break;
		CASE 3:
			$friendly = "Minor";
			break;
		CASE 2:
			$friendly = "Very Minor";
			break;
		CASE 1:
			$friendly = "None";
			break;
		DEFAULT:
			$friendly = "None";
			break;
	};
	return 	$friendly;
}

function random_locker()
{
	global $db;
		$min=1;
		$max=30;
		$lockerid = rand($min,$max);
	return $lockerid;
}

function email_user($to, $from, $title, $message)
{
	$headers = "From:" . $from . "\r\n";
	$headers .= "Reply-To:" . $from . "\r\n";
	$headers .= "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
	$headers .= "X-Mailer: PHP/" . phpversion();
	$msgto = $to;
	$msgtitle = $title;
	$msgheaders = $headers;
	// In case any of our lines are larger than 70 characters, we wordwrap()
	$message = wordwrap($message, 70, "\r\n");
	$msgbody = $message;
	//send email
	mail($msgto, $msgtitle, $msgbody, $msgheaders);
}
