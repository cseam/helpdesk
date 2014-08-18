	<a href="add.php">Add Call</a><br/>
<?php 
	if ($_SESSION['engineerLevel'] >= "1") { ?>
	<a href="retrospect.php">Retrospect Call</a><br/>
	<a href="engineerview.php">Engineer View</a><br/>
<?php	};
	if ($_SESSION['engineerLevel'] >= "2") { ?> 
	<a href="managerview.php">Manager View</a><br/>
<?php	};
?>

