<option value="" SELECTED>Please select</option>
<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

	// populate helpdesk details from db
	$STH = $DBH->Prepare("SELECT * FROM categories WHERE helpdesk = :id ORDER BY categoryName");
	$STH->bindParam(':id', $_GET['id'], PDO::PARAM_STR);
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	while($row = $STH->fetch()) { ?>
	<option value="<?php echo($row->id);?>"><?php echo($row->categoryName);?></option>
<?php };