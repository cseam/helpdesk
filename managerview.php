<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
	<?php
	// load functions
	include_once 'includes/functions.php';
	
	?>
	<head>
		<title><?=$codename;?> - Managers View</title>
		<link rel="shortcut icon" href="clcfavicon.ico" type="image/x-icon" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" /> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="robots" content="nofollow" />
		<link rel="stylesheet" type="text/css" href="css/reset.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
	</head>
	<body>
	<div class="section">
	<div id="branding">
		<?php include 'includes/nav.php'; ?>
	</div>
	
	<div id="leftpage">
	<div id="stats">
		<p>stats</p>
	</div>
	<div id="calllist">
		<p>call list</p>
	</div>
	</div>
	<div id="rightpage">
		<div id="addcall">
			<div id="ajax">
				<p>ajax</p>
			</div>
		</div>
	</div>
	</div>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js" type="text/javascript"></script>	
	<script src="javascript/jquery.js" type="text/javascript"></script>
	<script src="javascript/jquery.validate.min.js" type="text/javascript"></script>
	<script type="text/javascript">
		$("#addForm").validate({
			rules: {
				email: {
					required: true,
					email: true
					}
				}
		});
	</script>
	</body>
</html>










