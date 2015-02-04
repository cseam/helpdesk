<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<?php
	// load functions
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
	// reset session details
	$_SESSION['engineerLevel'] = 0;
	$_SESSION['engineerId'] = null;
	$_SESSION['superuser'] = null;
	$_SESSION['engineerHelpdesk'] = null;
	$_SESSION['sAMAccountName'] = null;
	// on post
	if ($_SERVER['REQUEST_METHOD']== "POST") {
		// using ldap bind
		$ldaprdn  = $_POST['username'] . '@' . $companysuffix;     // lusername from form + domain suffix
		$ldappass = $_POST['password'];  // associated password
		// check password isnt blank as ldap allows anon login that results in true
			if($ldappass == "") {
				// error return false
				$error = "enter a password";
			} else {
				// connect to ldap server
				$ldap_loc = $ldapserver;
				$ldap_port = 389;
				$ldapconn = ldap_connect($ldap_loc, $ldap_port) or die("Could not connect to LDAP server.");
					if ($ldapconn) {
						// binding to ldap server
						$ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);
						// verify binding
						if ($ldapbind) {
							//bind successful authenticate session details for user
							$result = mysqli_query($db, "SELECT * FROM engineers WHERE sAMAccountName='". $_POST['username'] ."'");
								if(mysqli_num_rows($result) === 0) {
									$_SESSION['sAMAccountName'] = $_POST['username'];
								}
								while($engineers = mysqli_fetch_array($result))  {
									// Update Session Details
									$_SESSION['sAMAccountName'] = $_POST['username'];
									$_SESSION['engineerLevel'] = $engineers['engineerLevel'];
									$_SESSION['engineerId'] = $engineers['idengineers'];
									$_SESSION['superuser'] = $engineers['superuser'];
									$_SESSION['engineerHelpdesk'] = $engineers['helpdesk'];
										// Update db enginner status
										mysqli_query($db, "UPDATE engineers_status SET status=1 WHERE id=" . $engineers['idengineers'] . ";");
										// Update db enginner punchcard
										mysqli_query($db, "INSERT INTO engineers_punchcard (engineerid, direction, stamp) VALUES ('" .$engineers['idengineers']."','1','".date("c")."');");
									}
									die("<script>location.href = '".$_GET['return']."'</script>");
						} else {
						// bind failed
						$error = "password incorrect, account locked, or user does not exist";
						}
					}
			}
	};
	?>
	<head>	
		<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'); ?>
	</head>
	<body>
		<div class="section">
		<div id="branding">
		</div>
		<div id="leftpage">
			<fieldset id="login">
				<legend>login to helpdesk</legend>
				<?php if ($error) { ?>
				<div id="formError">
					<h3>Error</h3>
					Please <?php echo($error)?>, check your details and try again.
				</div>
				<?php  }; ?>
					<form action="<?php echo($_SERVER['PHP_SELF']);?>?return=<?php echo($_GET['return']);?>" method="post" enctype="multipart/form-data" id="checkPassword">
						<label for="username">Username</label><input id="username" type="text" name="username" value="">
						<label for="password">Password</label><input id="password" type="password" name="password" value="">
						<input id="btnLogin" type="submit" name="btnLogin" value="LOGIN" />
					</form>
				<p>Welcome to <?php echo($codename);?>, please login with your standard college username and password.</p>
				<p>You do not need to prefix your username with CLC\, login like you would to one of the College computers. E.G. username: smitha</p>
				<p>If you have any issues with <?php echo($codename);?> contact the IT Support department. </p>
			</fieldset>
		</div>
		<div id="rightpage">
			<div id="addcall">
				<div id="ajax">
					<h2>FAQ's</h2>
					<h3>What is <?php echo($codename);?>?</h3>
					<p><?php echo($codename);?> is a way for users at CLC to report issues they have noticed around College and the boarding houses, quickly and easily to the correct department for action.</p>
					<h3>Who Can use <?php echo($codename);?>?</h3>
					<p><?php echo($codename);?> is open to both Staff & Students, it is a way to open communication with the correct department. if you notice a bulb has blown, tap is dripping, computer isn't working, sign has fallen down, don't wait for someone else to report it, you can.</p>
					<h3>What should I report?</h3>
					<p>Anything you feel isn't working correctly, engineers from the correct department will then be able to ask you questions about your ticket to help resolve the problem. Please include as much information as possible, saying a radiator doesn't work but not saying the location, or asking for ink for your printer but not telling the engineer the printer model or ink colour will slow down the process.</p>
					<h3>Why should i log a <?php echo($codename);?>?</h3>
					<p>It's a quick process, that will ensure the problem is looked at. College is a large environment and something you notice may take weeks to be noticed by engineers in their day to day routine. Reporting your issues will help resolve frustration when someone else comes to use the equipment to find it broken.</p>
					<h3>Why not just send an email?</h3>
					<p>If an engineer is on holiday or you are unsure who to contact <?php echo($codename);?> takes care of that for you, while providing department managers with statistical data on issues helping them troubleshoot larger issues or spot patterns, emailing individuals may solve your issue but wont help solve future issues.</p>
				</div>
			</div>
		</div>
	</div>
</body>
</html>










