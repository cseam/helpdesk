<!DOCTYPE html>
<html lang="en">
<head>
<title>SETUP</title>
<link rel="stylesheet" type="text/css" href="/public/css/reset.css" />
<link rel="stylesheet" type="text/css" href="/public/css/style.css" />
</head>
<body>
<div class="section">
<?php
// HELPDESK SETUP SCRIPT
// Used to create initial databases, delete this setup.php once you have run successfully
// Ensure config/config.php is updated with correct mysql details before this script is run
if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/config/config.php')) {
	// Load config
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	// Options for user
	?>
	<h2>Helpdesk Setup</h2>
	<p>This page will help create the initial databases to get Helpdesk up and running, once this page has been run management is done via the web login, this page should then be deleted. </p>
	<form method="post">
		<input type="submit" name="createTables" value="Create Tables" />
		<input type="submit" name="createDummyData" value="Create Dummy Data" />
	</form>
	<?php
	// functions to create tables
	if(isset($_POST['createTables'])) { 
		// try to create tables
		try {
			// Connect to dev db
			$conn = new PDO("mysql:host=".DB_LOC.";dbname=".DEV_DB_SCHEMA, DB_USER, DB_PASSWORD);
			// set the PDO error mode to exception
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			// create tables
			// assign engineers
			$sql = "
				CREATE TABLE `assign_engineers` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`engineerId` int(11) NOT NULL,
				PRIMARY KEY (`id`),
				UNIQUE KEY `idengineers_UNIQUE` (`id`)
				) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
			";
			$conn->exec($sql);
				echo "<p>(assign_engineers) created successfully</p>";
			// call_additional_fields
			$sql = "
				CREATE TABLE `call_additional_fields` (
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`typeid` int(11) DEFAULT NULL,
				`label` varchar(45) DEFAULT NULL,
				PRIMARY KEY (`id`)
				) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
			";
			$conn->exec($sql);
				echo "<p>(call_additional_fields) created successfully</p>";
			// call additional results
			$sql = "
				CREATE TABLE `call_additional_results` (
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`callid` int(11) DEFAULT NULL,
				`label` varchar(45) DEFAULT NULL,
				`value` varchar(45) DEFAULT NULL,
				PRIMARY KEY (`id`)
				) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
			";
			$conn->exec($sql);
				echo "<p>(call_additional_results) created successfully</p>";
			// call_views
			$sql = "
				CREATE TABLE `call_views` (
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`sAMAccountName` varchar(45) DEFAULT NULL,
				`callid` int(11) DEFAULT NULL,
				`stamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
				PRIMARY KEY (`id`)
				) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
			";
			$conn->exec($sql);
				echo "<p>(call_views) created successfully</p>";
			// call reasons
			$sql = "
				CREATE TABLE `callreasons` (
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`reason_name` varchar(255) DEFAULT '',
				`helpdesk_id` int(11) DEFAULT NULL,
				PRIMARY KEY (`id`)
				) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
				";
			$conn->exec($sql);
				echo "<p>(call reasons) created successfully</p>";
			// calls
			$sql = "
				CREATE TABLE `calls` (
				`callid` int(11) NOT NULL AUTO_INCREMENT,
				`name` varchar(45) DEFAULT NULL,
				`email` varchar(255) DEFAULT NULL,
				`tel` varchar(45) DEFAULT NULL,
				`details` longtext,
				`assigned` int(11) DEFAULT NULL,
				`opened` datetime DEFAULT NULL,
				`lastupdate` datetime DEFAULT NULL,
				`closed` datetime DEFAULT NULL,
				`status` int(11) DEFAULT '1',
				`urgency` int(11) DEFAULT '2',
				`location` varchar(45) DEFAULT NULL,
				`room` varchar(45) DEFAULT NULL,
				`category` int(11) DEFAULT NULL,
				`closeengineerid` int(11) DEFAULT NULL,
				`owner` varchar(45) DEFAULT NULL,
				`helpdesk` int(11) DEFAULT NULL,
				`invoicedate` datetime DEFAULT NULL,
				`callreason` int(11) DEFAULT NULL,
				`title` longtext,
				`lockerid` int(11) DEFAULT NULL,
				`pm` int(11) DEFAULT '0',
				`requireinvoice` int(11) DEFAULT '0',
				PRIMARY KEY (`callid`),
				UNIQUE KEY `callid_UNIQUE` (`callid`)
				) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
				";
			$conn->exec($sql);
				echo "<p>(calls) created successfully</p>";
			// categories
			$sql = "
				CREATE TABLE `categories` (
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`categoryName` varchar(45) DEFAULT NULL,
				`helpdesk` int(11) DEFAULT NULL,
				PRIMARY KEY (`id`)
				) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
				";
			$conn->exec($sql);
				echo "<p>(categories) created successfully</p>";
			// change control 
			$sql = "
				CREATE TABLE `changecontrol` (
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`engineersid` int(11) DEFAULT NULL,
				`stamp` datetime DEFAULT NULL,
				`changemade` longtext,
				`tags` varchar(45) DEFAULT '',
				`server` varchar(45) DEFAULT NULL,
				`helpdesk` int(11) DEFAULT NULL,
				PRIMARY KEY (`id`)
				) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
				";
			$conn->exec($sql);
				echo "<p>(change control) created successfully</p>";
			// change control tags 
			$sql = "
				CREATE TABLE `changecontrol_tags` (
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`tagname` varchar(45) DEFAULT NULL,
				`helpdesk` int(11) DEFAULT NULL,
				PRIMARY KEY (`id`)
				) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
				";
			$conn->exec($sql);
				echo "<p>(change control tags) created successfully</p>";
			// engineers 
			$sql = "
				CREATE TABLE `engineers` (
				`idengineers` int(11) NOT NULL AUTO_INCREMENT,
				`engineerName` varchar(45) NOT NULL,
				`engineerEmail` varchar(45) NOT NULL,
				`availableDays` varchar(45) NOT NULL DEFAULT '1,2,3,4,5,6,7',
				`sAMAccountName` varchar(45) NOT NULL DEFAULT '',
				`engineerLevel` int(11) NOT NULL DEFAULT '1',
				`helpdesk` int(11) NOT NULL,
				`superuser` int(11) DEFAULT NULL,
				`disabled` int(11) DEFAULT '0',
				PRIMARY KEY (`idengineers`),
				UNIQUE KEY `idengineers_UNIQUE` (`idengineers`)
				) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
				";
			$conn->exec($sql);
				echo "<p>(engineers) created successfully</p>";
			// engineers punchcard 
			$sql = "
				CREATE TABLE `engineers_punchcard` (
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`direction` int(11) NOT NULL,
				`stamp` datetime NOT NULL,
				`engineerid` int(11) DEFAULT NULL,
				`note` varchar(45) DEFAULT NULL,
				PRIMARY KEY (`id`)
				) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
				";
			$conn->exec($sql);
				echo "<p>(engineers punchcard) created successfully</p>";
			// engineer status
			$sql = "
				CREATE TABLE `engineers_status` (
				`id` int(11) unsigned NOT NULL DEFAULT '0',
				`status` int(11) NOT NULL DEFAULT '0',
				PRIMARY KEY (`id`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8;
				";
			$conn->exec($sql);
				echo "<p>(engineers status) created successfully</p>";				
			// feedback 
			$sql = "
				CREATE TABLE `feedback` (
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`callid` int(11) DEFAULT NULL,
				`satisfaction` varchar(45) DEFAULT NULL,
				`details` longtext,
				`opened` datetime DEFAULT NULL,
				PRIMARY KEY (`id`)
				) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
				";
			$conn->exec($sql);
				echo "<p>(feedback) created successfully</p>";
			// helpdesks
			$sql = "
				CREATE TABLE `helpdesks` (
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`helpdesk_name` varchar(45) DEFAULT NULL,
				`description` varchar(2000) DEFAULT NULL,
				`deactivate` int(11) NOT NULL DEFAULT '0',
				`auto_assign` int(11) DEFAULT '0',
				`email_on_newticket` int(11) DEFAULT '0',
				PRIMARY KEY (`id`)
				) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
				";
			$conn->exec($sql);
				echo "<p>(helpdesks) created successfully</p>";
			// location 
			$sql = "
				CREATE TABLE `location` (
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`locationName` varchar(45) DEFAULT NULL,
				`iconlocation` varchar(255) DEFAULT NULL,
				`shorthand` varchar(45) DEFAULT NULL,
				PRIMARY KEY (`id`)
				) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
				";
			$conn->exec($sql);
				echo "<p>(location) created successfully</p>";
			// out of hours 
			$sql = "
				CREATE TABLE `out_of_hours` (
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`name` varchar(255) DEFAULT NULL,
				`dateofcall` varchar(255) DEFAULT NULL,
				`timeofcall` varchar(255) DEFAULT NULL,
				`calloutby` varchar(255) DEFAULT NULL,
				`problem` text,
				`previsit` text,
				`timeonsite` varchar(255) DEFAULT NULL,
				`timeleftsite` varchar(255) DEFAULT NULL,
				`locations` varchar(255) DEFAULT NULL,
				`resolution` text,
				PRIMARY KEY (`id`)
				) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
				";
			$conn->exec($sql);
				echo "<p>(Out of hours) created successfully</p>";
			// out of hours contact 
			$sql = "
				CREATE TABLE `out_of_hours_contact_details` (
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`helpdesk` int(11) DEFAULT NULL,
				`end_of_day` int(11) DEFAULT NULL,
				`message` text,
				PRIMARY KEY (`id`)
				) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
				";
			$conn->exec($sql);
				echo "<p>(Out of hours contact) created successfully</p>";
			// performance objectives 
			$sql = "
				CREATE TABLE `performance_review_objectives` (
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`engineerid` int(11) DEFAULT NULL,
				`title` longtext,
				`details` longtext,
				`progress` varchar(255) DEFAULT '0',
				`datedue` datetime DEFAULT NULL,
				`status` int(11) DEFAULT '1',
				PRIMARY KEY (`id`)
				) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
				";
			$conn->exec($sql);
				echo "<p>(Performance objectives) created successfully</p>";
			// quick responses 
			$sql = "
				CREATE TABLE `quick_responses` (
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`quick_response` varchar(255) DEFAULT NULL,
				`helpdesk_id` int(11) DEFAULT NULL,
				PRIMARY KEY (`id`)
				) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
				";
			$conn->exec($sql);
				echo "<p>(quick responses) created successfully</p>";
			// scheduled calls 
			$sql = "
				CREATE TABLE `scheduled_calls` (
				`callid` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`name` varchar(45) DEFAULT NULL,
				`email` varchar(45) DEFAULT NULL,
				`tel` varchar(45) DEFAULT NULL,
				`details` longtext,
				`assigned` int(11) DEFAULT NULL,
				`opened` datetime DEFAULT NULL,
				`lastupdate` datetime DEFAULT NULL,
				`closed` datetime DEFAULT NULL,
				`status` int(11) DEFAULT NULL,
				`urgency` int(11) DEFAULT NULL,
				`location` varchar(45) DEFAULT NULL,
				`room` varchar(45) DEFAULT NULL,
				`category` int(11) DEFAULT NULL,
				`closeengineerid` int(11) DEFAULT NULL,
				`owner` varchar(45) DEFAULT NULL,
				`helpdesk` int(11) DEFAULT NULL,
				`invoicedate` datetime DEFAULT NULL,
				`callreason` int(11) DEFAULT NULL,
				`title` longtext,
				`lockerid` int(11) DEFAULT NULL,
				`frequencytype` varchar(45) DEFAULT NULL,
				`startschedule` datetime DEFAULT NULL,
				PRIMARY KEY (`callid`)
				) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
				";
			$conn->exec($sql);
				echo "<p>(scheduled calls) created successfully</p>";
			// scheduled calls cron 
			$sql = "
				CREATE TABLE `scheduled_calls_cron_log` (
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`message` varchar(255) DEFAULT NULL,
				PRIMARY KEY (`id`)
				) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
				";
			$conn->exec($sql);
				echo "<p>(scheduled calls cron) created successfully</p>";
			// service level agreement 
			$sql = "
				CREATE TABLE `service_level_agreement` (
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`helpdesk` int(11) DEFAULT NULL,
				`urgency` int(11) DEFAULT NULL,
				`agreement` varchar(255) DEFAULT NULL,
				`close_eta_days` int(11) DEFAULT NULL,
				PRIMARY KEY (`id`)
				) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
				";
			$conn->exec($sql);
				echo "<p>(service level agreement) created successfully</p>";
			// status 
			$sql = "
				CREATE TABLE `status` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`statusCode` varchar(45) NOT NULL DEFAULT '',
				PRIMARY KEY (`id`),
				UNIQUE KEY `idengineers_UNIQUE` (`id`)
				) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
				";
			$conn->exec($sql);
				echo "<p>(status) created successfully</p>";			
			}
		catch(PDOException $e)
			{
			echo "<p class='urgent'>ERROR: " . $e->getMessage() ."</p>";
			}
		$conn = null;
	}	
	// Create Dummy Data	
	if(isset($_POST['createDummyData'])) { 
		print_r($_POST);
	}	
			
	
} else {
	echo("<h2>Config Error</h2>");
	echo("<p class='urgent'>Config not found, please create config/config.php using the supplied dist-config.php with your mysql connection details. </p>");
}
?>
</div>
</body>
</html>
