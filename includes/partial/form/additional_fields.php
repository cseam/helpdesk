<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

	// populate additional fields from db
	$STH = $DBH->Prepare("SELECT * FROM call_additional_fields WHERE typeid = :typeid");
	$STH->bindParam(':typeid', $_GET['id'], PDO::PARAM_STR);
	$STH->setFetchMode(PDO::FETCH_OBJ);
	$STH->execute();
	while($row = $STH->fetch()) { ?>
		<label for="<?php echo($row->label);?>"><?php echo($row->label);?></label>
		<input type="text" id="label<?php echo($row->id);?>" name="label<?php echo($row->id);?>" value="" required />
<?php };