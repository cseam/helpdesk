<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');

			 		$morefields = mysqli_query($db, "SELECT * FROM call_additional_fields WHERE typeid = ". $_GET['id'] .";");
			 		while($loop = mysqli_fetch_array($morefields)) { ?>
				 		<label for="<?=$loop['label'];?>"><?=$loop['label'];?></label>
				 		<input type="text" id="label<?=$loop['id'];?>" name="label<?=$loop['id'];?>" value="" required />
<? } ?>