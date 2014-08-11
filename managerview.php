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
		<p>calls added in last day</p>
		<p>calls closed in last day</p>
		<p>average call duration</p>
		<p>most calls closed by engineer</p>
		<p>least calls closed by engineer</p>
	</div>
	<div id="calllist">
		<div id="ajaxforms">
			<table>
				<tbody>
					<tr>
						<td>All Calls</td>
						<td style="text-align: right;">
							<form method="post">
							<input type="hidden" id="id" name="id" value="1" />
							<button name="submit" value="submit" type="submit" class="calllistbutton">View</button>
							</form>
						</td>
					</tr>
					<tr>
						<td>Oldest Calls</td>
						<td style="text-align: right;">
							<form method="post">
							<input type="hidden" id="id" name="id" value="2" />
							<button name="submit" value="submit" type="submit" class="calllistbutton">View</button>
							</form>
						</td>
					</tr>
					<tr>
						<td>Engineer Workload</td>
						<td style="text-align: right;">
							<form method="post">
							<input type="hidden" id="id" name="id" value="3" />
							<button name="submit" value="submit" type="submit" class="calllistbutton">View</button>
							</form>
						</td>
					</tr>
					<tr>
						<td>Work Rate</td>
						<td style="text-align: right;">
							<form method="post">
							<input type="hidden" id="id" name="id" value="4" />
							<button name="submit" value="submit" type="submit" class="calllistbutton">View</button>
							</form>
						</td>
					</tr>
					<tr>
						<td>User Feedback</td>
						<td style="text-align: right;">
							<form method="post">
							<input type="hidden" id="id" name="id" value="5" />
							<button name="submit" value="submit" type="submit" class="calllistbutton">View</button>
							</form>
						</td>
					</tr>
					<tr>
						<td>Punchcard In/Out</td>
						<td style="text-align: right;">
							<form method="post">
							<input type="hidden" id="id" name="id" value="6" />
							<button name="submit" value="submit" type="submit" class="calllistbutton">View</button>
							</form>
						</td>
					</tr>
					<tr>
						<td>Emerging Issues</td>
						<td style="text-align: right;">
							<form method="post">
							<input type="hidden" id="id" name="id" value="7" />
							<button name="submit" value="submit" type="submit" class="calllistbutton">View</button>
							</form>
						</td>
					</tr>
			</tbody>
			</table>
		</div>
	</div>
	</div>
	<div id="rightpage">
		<div id="addcall">
			<div id="ajax">
				<?php include('includes/managerdefault.php'); ?>
			</div>
		</div>
	</div>
	</div>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js" type="text/javascript"></script>	
	<script src="javascript/jquery.js" type="text/javascript"></script>
	<script type="text/javascript">
    // Ajax form submit
    $('form').submit(function(e) {
        // Post the form data to viewcall
        $.post('includes/managerviewreport.php', $(this).serialize(), function(resp) {
            // return response data into div
            $('#ajax').html(resp);
        });
        // Cancel the actual form post so the page doesn't refresh
        e.preventDefault();
        return false;
    });     
    </script>
	</body>
</html>










