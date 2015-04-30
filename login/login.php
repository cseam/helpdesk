<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<?php
	// load functions
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
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
		$ldaprdn  = $_POST['username'] . '@' . COMPANY_SUFFIX;     // lusername from form + domain suffix
		$ldappass = $_POST['password'];  // associated password
		// check password isnt blank as ldap allows anon login that results in true
			if($ldappass == "") {
				// error return false
				$error = "enter a password";
			} else {
				// connect to ldap server
				$ldap_loc = LDAP_SERVER;
				$ldap_port = 389;
				$ldapconn = ldap_connect($ldap_loc, $ldap_port) or die("Could not connect to LDAP server.");
					if ($ldapconn) {
						// binding to ldap server
						$ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);
						// verify binding
						if ($ldapbind) {
							//bind successful authenticate session details for user
							$STH = $DBH->Prepare("SELECT * FROM engineers WHERE sAMAccountName = :username");
							$STH->bindParam(":username", $_POST['username'], PDO::PARAM_STR);
							$STH->setFetchMode(PDO::FETCH_OBJ);
							$STH->execute();
							if($STH->rowCount() === 0) { $_SESSION['sAMAccountName'] = $_POST['username'];}
								while($row = $STH->fetch()) {
									// Update Session Details
									$_SESSION['sAMAccountName'] = $_POST['username'];
									$_SESSION['engineerLevel'] = $row->engineerLevel;
									$_SESSION['engineerId'] = $row->idengineers;
									$_SESSION['superuser'] = $row->superuser;
									$_SESSION['engineerHelpdesk'] = $row->helpdesk;
										// Update db enginner status
										$STHloop = $DBH->Prepare("UPDATE engineers_status SET status=1 WHERE id = : id");
										$STHloop->bindParam(":id", $row->idengineers, PDO::PARAM_STR);
										$STHloop->execute();
										// Update db enginner punchcard
										$STHloop = $DBH->Prepare("INSERT INTO engineers_punchcard (engineerid, direction, stamp) VALUES (:id, '1', :date)");
										$STHloop->bindParam(":id", $row->idengineers, PDO::PARAM_STR);
										$STHloop->bindParam(":date", date("c"), PDO::PARAM_STR);
										$STHloop->execute();
									}
									die("<script>location.href = '".$_GET['return']."'</script>");
						} else {
						// bind failed
						$error = "Password incorrect, account locked, or user does not exist";
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
				<legend>log in to <?php echo(CODENAME);?></legend>
					<form action="<?php echo($_SERVER['PHP_SELF']);?>?return=<?php echo($_GET['return']);?>" method="post" enctype="multipart/form-data" id="checkPassword">
						<label for="username">Username</label><input id="username" type="text" name="username" value="" autofocus>
						<label for="password">Password</label><input id="password" type="password" name="password" value="">
						<input id="btnLogin" type="submit" name="btnLogin" value="LOG IN" />
						<?php if ($error) { ?>
							<div class="note urgent">
							<h3>Error</h3>
							<?php echo($error)?>, check your details and try again.
							</div>
						<?php  }; ?>
					</form>
					<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/partial/user_login_help.php'); ?>
			</fieldset>
		</div>
		<div id="rightpage">
			<div id="addcall">
				<div id="ajax">
					<h2>FAQs</h2>
					<h3>What is  <?php echo(CODENAME);?>?</h3>
					<p><?php echo(CODENAME);?> is a way for users at College to quickly and easily report issues they have noticed around campus to the correct department for action.</p>
					<h3>Who Can use  <?php echo(CODENAME);?>?</h3>
					<p><?php echo(CODENAME);?> is open to both staff and students. If you notice a bulb has blown, a tap is dripping, a computer isn't working, a sign has fallen down, etc. then don't wait for someone else to report it - you can. </p>
					<h3>What should I report?</h3>
					<p>Anything you feel isn't working correctly. Engineers from the correct department will then be able to ask you questions about your ticket - your report on Helpdesk - to help resolve the problem. Please include as much information as possible. For example, reporting that a radiator isn't working but not supplying the location, or requesting ink for a printer without including the printer model or ink colour, will slow down the process.  </p>
					<h3>Why should i log a  <?php echo(CODENAME);?>?</h3>
					<p>It is a swift process and will ensure that the problem is looked at as soon as possible. With College being such a large environment, engineers may not notice a problem straight away, but with Helpdesk you can bring it to their attention immediately. </p>
					<h3>Why not just send an email?</h3>
					<p>If you do not know who to specifically contact, or an engineer is on holiday, <?php echo(CODENAME);?> takes care of that for you and directs your problem to the appropriate department and / or person. Not only that, it provides department managers with statistical data, helping them troubleshoot larger issues and even spot patterns. Emailing individuals may solve your issue, but Helpdesk can warn of future problems as well. </p>
				</div>
			</div>
		</div>
	</div>
</body>
</html>