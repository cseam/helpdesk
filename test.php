<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');

	try {
		# PDO_MYSQL
		$DBH = new PDO("mysql:host=".DB_LOC.";dbname=".DB_SCHEMA, DB_USER, DB_PASSWORD);
		# Display development errors
		if (DEVELOPMENT_ENVIRONMENT === true) {
			$DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
		}
	}
	catch(PDOException $e) {
		echo($e->getMessage());
	}


	# Ticket object
	class ticket {
		public $name;
		public $age;

		function __construct($n, $a) {
			$this->name = $n;
			$this->age = $a;
		}
	}

	$createticket = new ticket('wibble','2');

	# Prep statment
	$STH = $DBH->Prepare("INSERT INTO test (name, age) value (:name, :age)");
	# Insert object
	$STH->execute((array)$createticket);


	# Creating the statement
	$STH = $DBH->query('SELECT * from test');
	# Setting the fetch mode
	$STH->setFetchMode(PDO::FETCH_OBJ);
	# Showing the results
	while($row = $STH->fetch()) {
		echo("<li>".$row->name);
		echo("<li>".$row->age);
	}

	# Echo last id inserted
	echo($DBH->lastInsertId());

