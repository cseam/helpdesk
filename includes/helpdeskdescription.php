<?php
	session_start();
	include_once 'functions.php';

			 		$thedetails = mysqli_query($db, "SELECT * FROM helpdesks WHERE id = ". $_GET['id'] .";");
			 		while($loop = mysqli_fetch_array($thedetails)) { ?>
				 		<p><?=$loop['description'];?></p>
<? } ?>