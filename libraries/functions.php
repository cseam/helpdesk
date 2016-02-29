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
