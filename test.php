<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');

	try {
		# MySQL with PDO_MYSQL
		$DBH = new PDO("mysql:host=".DB_LOC.";dbname=".DB_SCHEMA."", DB_USER, DB_PASSWORD);
	}
	catch(PDOException $e) {
		echo($e->getMessage());
	}
	# display development errors
	if (DEVELOPMENT_ENVIRONMENT === true) {
		$DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
	}

	# ticket object
	class ticket {
		public $name;
		public $age;

		function __construct($n, $a) {
			$this->name = $n;
			$this->age = $a;
		}
	}

	$createticket = new ticket('wibble','2');

	# here's the fun part:
	$STH = $DBH->Prepare("INSERT INTO test (name, age) value (:name, :age)");
	$STH->execute((array)$createticket);


	# creating the statement
	$STH = $DBH->query('SELECT * from test');
	# setting the fetch mode
	$STH->setFetchMode(PDO::FETCH_OBJ);
	# showing the results
	while($row = $STH->fetch()) {
		echo("<li>".$row->name);
		echo("<li>".$row->age);
	}

	# echo last id inserted
	echo($DBH->lastInsertId());

